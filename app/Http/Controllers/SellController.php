<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\SellTransaction;
use App\Models\SellTransactionItem;
use App\Models\Waste;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class SellController extends Controller
{
    public function store(Request $request)
{
    $request->validate([
        'address' => 'required|string|max:255',
        'phone_number' => 'required|string|max:20',
        'pickup_date' => 'required|date_format:Y-m-d',
        'wastes' => 'required|array|min:1',
        'wastes.*.waste_id' => 'required|exists:wastes,id',
        'wastes.*.quantity' => 'required|integer|min:1',
    ]);

    DB::beginTransaction();

    try {
        // Simpan transaksi utama
        $transaction = SellTransaction::create([
            'user_id' => Auth::user()->id, // pastikan sudah login
            'address' => $request->address,
            'phone_number' => $request->phone_number,
            'pickup_date' => $request->pickup_date,
        ]);

        // Simpan tiap jenis sampah (item transaksi)
        foreach ($request->wastes as $waste) {
            SellTransactionItem::create([
                'transaction_id' => $transaction->id,
                'waste_id' => $waste['waste_id'],
                'quantity' => $waste['quantity'],
                'subtotal_point' => Waste::find($waste['waste_id'])->point * $waste['quantity'],
            ]);
        }

        DB::commit();

        return response()->json([
            'message' => 'Transaksi berhasil disimpan',
            'data' => $transaction
        ], 201);
    } catch (\Throwable $e) {
        DB::rollBack();

        return response()->json([
            'message' => 'Terjadi kesalahan saat menyimpan transaksi',
            'error' => $e->getMessage()
        ], 500);
    }
}
}

