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
        // 1. Validasi Request
        $request->validate([
            'items' => 'required|array|min:1',
            'items.*.stock_id' => 'required|exists:stocks,id',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        // 2. Ambil user yang sedang login
        $user = User::find(Auth::id());

        // 3. Mulai transaksi database
        DB::beginTransaction();

        try {
            // 4. Proses tiap item: validasi stok, hitung poin, siapkan data
            $totalPointsNeeded = 0;
            $redeemItemsData = [];
            $stockCache = [];

            foreach ($request->items as $item) {
                $stockId = $item['stock_id'];
                $quantity = $item['quantity'];

                // Ambil stock dari cache jika sudah, jika belum ambil dari DB
                if (!isset($stockCache[$stockId])) {
                    $stockCache[$stockId] = Stock::find($stockId);
                }
                $stock = $stockCache[$stockId];

                // Validasi stok
                if (!$stock) {
                    throw new \Exception("Produk reward dengan ID {$stockId} tidak ditemukan.");
                }
                if ($stock->stock < $quantity) {
                    throw new \Exception("Stok untuk {$stock->name} tidak cukup. Tersedia: {$stock->stock}, Diminta: {$quantity}.");
                }

                // Hitung total poin yang dibutuhkan
                $pointCost = $stock->point_cost;
                $totalPointsNeeded += $pointCost * $quantity;

                // Simpan data item untuk proses berikutnya
                $redeemItemsData[] = [
                    'stock_id' => $stock->id,
                    'quantity' => $quantity,
                    'point_spent_per_item' => $pointCost,
                ];
            }

            // 5. Cek apakah poin user cukup
            if ($user->total_points < $totalPointsNeeded) {
                throw new \Exception("Poin tidak cukup. Dibutuhkan: $totalPointsNeeded, Tersedia: $user->total_points.");
            }

            // 6. Simpan transaksi redeem utama
            $redeem = RewardRedeem::create([
                'user_id' => $user->id,
                'total_points_spent' => $totalPointsNeeded,
                'status' => 'menunggu konfirmasi',
            ]);

            // 7. Simpan tiap item dan update stok
            foreach ($redeemItemsData as $itemData) {
                // Simpan item ke tabel reward_redeem_items
                RewardRedeemItem::create([
                    'reward_redeem_id' => $redeem->id,
                    'stock_id' => $itemData['stock_id'],
                    'quantity' => $itemData['quantity'],
                    'point_spent_per_item' => $itemData['point_spent_per_item'],
                ]);

                // Update stok produk
                $stock = $stockCache[$itemData['stock_id']];
                $stock->stock -= $itemData['quantity'];
                $stock->save();
            }

            // 8. Kurangi poin user
            // $user->total_points -= $totalPointsNeeded;
            $user->save();

            // 9. Commit transaksi dan return sukses
            DB::commit();

            return response()->json([
                'message' => 'Penukaran berhasil diajukan.',
                'redeem' => $redeem->load(['redeemItems.stock']),
            ], 200);

        } catch (\Exception $e) {
            // 10. Rollback jika ada error
            DB::rollBack();

            return response()->json([
                'message' => 'Penukaran gagal.',
                'error' => $e->getMessage(),
            ], 400);
        }
    }


    public function history()
    {
        try {
            // Mendapatkan user saat ini
            $userId = Auth::id();

            // Mendapatkan daftar reward redeem milik user
            $redeems = RewardRedeem::with('stocks', 'redeemItems.stock')
                        ->where('user_id', $userId)
                        ->orderByDesc('created_at')
                        ->get();

            return response()->json([
                'data' => $redeems
            ]);
        } catch (\Throwable $e) {
            Log::error("Gagal mengambil riwayat penukaran: " . $e->getMessage());
            return response()->json([
                'message' => 'Terjadi kesalahan saat mengambil riwayat.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            // Mendapatkan detail redeem berdasarkan ID
            $redeem = RewardRedeem::with('redeemItems.stock')->findOrFail($id);

            return response()->json([
                'data' => $redeem
            ]);
        } catch (\Throwable $e) {
            Log::error("Gagal mengambil detail penukaran: " . $e->getMessage());
            return response()->json([
                'message' => 'Terjadi kesalahan saat mengambil detail penukaran.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}

