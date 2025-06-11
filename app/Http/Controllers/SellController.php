<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSellRequest;
use App\Models\SellTransaction;
use App\Models\SellTransactionItem;
use App\Models\Waste;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SellController extends Controller
{
    /**
     * Simpan transaksi penjualan oleh user.
     */
    public function store(StoreSellRequest $request)
    {
        $data = $request->validated();
        DB::beginTransaction();

        try {
            $user = User::findOrFail(Auth::id());

            // Buat transaksi utama
            $transaction = SellTransaction::create([
                'user_id'       => $user->id,
                'address'       => $data['address'],
                'phone_number'  => $data['phone_number'],
                'pickup_date'   => $data['pickup_date'],
                'status'        => 'menunggu konfirmasi',
            ]);

            // Simpan item-item transaksi
            foreach ($data['wastes'] as $waste) {
                $wasteModel = Waste::findOrFail($waste['waste_id']);
                $subtotalPoint = $wasteModel->point_value * $waste['quantity'];

                SellTransactionItem::create([
                    'transaction_id' => $transaction->id,
                    'waste_id'       => $waste['waste_id'],
                    'quantity'       => $waste['quantity'],
                    'subtotal_point' => $subtotalPoint,
                ]);
            }

            DB::commit();

            return response()->json([
                'message' => 'Transaksi berhasil disimpan',
                'data'    => $transaction
            ], 201);
        }
        catch (\Throwable $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Gagal menyimpan transaksi',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Menampilkan riwayat transaksi user.
     */
    public function history()
    {
        $userId = Auth::id();

        $transactions = SellTransaction::with('wastes', 'items.waste')
            ->where('user_id', $userId)
            ->orderByDesc('pickup_date')
            ->get();

        return response()->json([
            'data' => $transactions,
        ]);
    }

    /**
     * Admin: Ubah status menjadi 'dijemput'.
     */
    public function pickup($id)
    {
        $transaction = SellTransaction::findOrFail($id);
        $transaction->status = 'dijemput';
        $transaction->save();

        return redirect()->back()->with('success', 'Transaksi telah dijemput');
    }

    /**
     * Admin: Ubah status menjadi 'diproses'.
     */
    public function markProcessed($id)
    {
        $transaction = SellTransaction::findOrFail($id);
        $transaction->status = 'diproses';
        $transaction->save();

        return redirect()->back()->with('success', 'Transaksi sedang diproses');
    }

    /**
     * Admin: Selesaikan transaksi dan tambahkan poin ke user.
     */
    public function completeTransaction($id)
    {
        DB::beginTransaction();

        try {
            $transaction = SellTransaction::with('items', 'user')->findOrFail($id);

            // Validasi status sebelum menyelesaikan
            if ($transaction->status !== 'diproses') {
                return redirect()->back()->with('error', 'Transaksi tidak dalam status yang valid untuk diselesaikan.');
            }

            // Hitung poin total dari item
            $totalPoints = $transaction->items->sum('subtotal_point');

            // Tambahkan poin ke user
            $user = $transaction->user;
            $user->total_points += $totalPoints;
            $user->save();

            // Update status transaksi
            $transaction->status = 'selesai';
            $transaction->save();

            DB::commit();

            return redirect()->back()->with('success', 'Transaksi diselesaikan dan poin ditambahkan.');
        } catch (\Throwable $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal menyelesaikan transaksi: ' . $e->getMessage());
        }
    }

    public function allTransactions()
    {
        $transactions = SellTransaction::with('user', 'items.waste')->orderBy('created_at', 'desc')->get();

        return response()->json($transactions);
    }

}
