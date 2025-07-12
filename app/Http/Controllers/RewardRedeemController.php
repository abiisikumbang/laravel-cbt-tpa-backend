<?php
//ini controller untuk menangani penukaran stock dengan point

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Stock;
use App\Models\RewardRedeem;
use App\Models\RewardRedeemItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class RewardRedeemController extends Controller
{
    /**
     * Controller untuk membuat transaksi redeem dan mengurus data reward pada api
     */
    public function store(Request $request)
    {
        // Validasi request yang masuk
        $request->validate([
            'items' => 'required|array|min:1',
            'items.*.stock_id' => 'required|exists:stocks,id', // Memastikan stock_id valid
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        // Mendapatkan user saat ini
        $user = User::find(Auth::id());

        // Memulai transaksi database
        DB::beginTransaction();

        try {
            // Inisialisasi variabel untuk total poin yang dibutuhkan dan item yang akan ditebus
            $totalPointsNeeded = 0;
            $redeemItemsData = []; // Ubah nama variabel agar lebih jelas, ini adalah data array untuk item

            // Iterasi setiap item dalam request
            foreach ($request->items as $item) {
                // Mencari item reward berdasarkan ID
                // Cek apakah stock sudah diambil sebelumnya, jika belum ambil dan simpan di array
                static $stockCache = [];
                if (!isset($stockCache[$item['stock_id']])) {
                    $stockCache[$item['stock_id']] = Stock::find($item['stock_id']);
                }
                $stock = $stockCache[$item['stock_id']];

                // Jika stok tidak ditemukan atau tidak cukup, lemparkan exception
                if (!$stock) { // Pastikan stok ditemukan sebelum cek kuantitas
                    throw new \Exception("Produk reward dengan ID {$item['stock_id']} tidak ditemukan.");
                }
                if ($stock->stock < $item['quantity']) {
                    throw new \Exception("Stok untuk {$stock->name} tidak cukup. Tersedia: {$stock->stock}, Diminta: {$item['quantity']}.");
                }

                // Tambahkan item ke daftar item yang akan ditebus
                $redeemItemsData[] = [
                    'stock_id' => $stock->id, // <--- PENTING: Gunakan 'stock_id' di sini
                    'quantity' => $item['quantity'],
                    'point_spent_per_item' => $stock->point_cost, // Ini adalah poin per unit item
                ];
            }

            // Jika poin user tidak cukup, lemparkan exception
            if ($user->total_points < $totalPointsNeeded) {
                throw new \Exception("Poin Anda tidak cukup. Dibutuhkan: $totalPointsNeeded, Tersedia: $user->total_points");
            }

            // Simpan transaksi redeem utama
            $redeem = RewardRedeem::create([
                'user_id' => $user->id,
                'total_points_spent' => $totalPointsNeeded,
                'status' => 'menunggu konfirmasi',
            ]);

            // Iterasi setiap item yang ditebus untuk disimpan dan update stok
            foreach ($redeemItemsData as $itemData) { // Gunakan itemData agar tidak bentrok dengan $item dari request awal
                // Simpan item redeem ke tabel reward_redeem_items
                RewardRedeemItem::create([
                    'reward_redeem_id' => $redeem->id,
                    'stock_id' => $itemData['stock_id'],
                    'quantity' => $itemData['quantity'],
                    'point_spent_per_item' => $itemData['point_spent_per_item'],
                ]);

                $currentStock = Stock::find($itemData['stock_id']);
                if ($currentStock) { // Periksa lagi jika stock masih ada (meskipun sudah divalidasi di awal)
                    $currentStock->stock -= $itemData['quantity'];
                    $currentStock->save();
                }
            }

            // Kurangi poin user
            $user->total_points -= $totalPointsNeeded;
            $user->save();

            // Commit transaksi database
            DB::commit();

            // Kembalikan respon JSON sukses
            return response()->json([
                'message' => 'Penukaran berhasil diajukan.',
                'redeem' => $redeem->load(['redeemItems.stock']) // <--- Perbaiki pemuatan relasi
                // 'redeemItems.stock' untuk memuat item redeem dan stock terkait
            ], 200);

        } catch (\Exception $e) {
            // Rollback transaksi jika terjadi kesalahan
            DB::rollBack();

            // Kembalikan respon JSON error
            return response()->json([
                'message' => 'Penukaran gagal.',
                'error' => $e->getMessage(),
            ], 400);
        }
    }

    public function history()
    {
        // Mendapatkan user saat ini
        $userId = Auth::id();

        // Mendapatkan daftar reward redeem milik user
        $redeems = RewardRedeem::with('items.stock')
                    ->where('user_id', $userId)
                    ->orderByDesc('created_at')
                    ->get();

        // Kembalikan respon JSON dengan data reward redeem
        return response()->json($redeems);
    }
}

