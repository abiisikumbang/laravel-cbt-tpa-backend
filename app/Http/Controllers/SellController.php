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
use Illuminate\Support\Facades\Log;

class SellController extends Controller
{
    //Simpan transaksi penjualan oleh user.
    /**
     * Store a newly created SellTransaction in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSellRequest $request)
    {
        // Ambil data yang diinput dan divalidasi oleh StoreSellRequest
        $data = $request->validated();

        // Mulai transaksi database
        DB::beginTransaction();

        try {
            // Ambil user yang sedang login
            $user = User::findOrFail(Auth::id());

            // Buat SellTransaction baru
            $transaction = SellTransaction::create([
                'user_id'       => $user->id,
                'address'       => $data['address'],
                // 'phone_number'  => $data['phone_number'],
                'phone'         => $data['phone'],
                'pickup_date'   => $data['pickup_date'],
                'status'        => 'menunggu konfirmasi',
            ]);

            // Iterasi setiap item transaksi yang diinput
            foreach ($data['wastes'] as $waste) {
                // Ambil data waste berdasarkan id
                $wasteModel = Waste::findOrFail($waste['waste_id']);

                // Hitung subtotal poin untuk setiap item
                $subtotalPoint = $wasteModel->point_value * $waste['quantity'];

                // Buat SellTransactionItem baru untuk setiap item transaksi
                SellTransactionItem::create([
                    'transaction_id' => $transaction->id,
                    'waste_id'       => $waste['waste_id'],
                    'quantity'       => $waste['quantity'],
                    'subtotal_point' => $subtotalPoint,
                ]);
            }

            // Commit transaksi database
            DB::commit();

            // Kembalikan response JSON dengan data transaksi yang dibuat
            return response()->json([
                'message' => 'Transaksi berhasil disimpan',
                'data'    => $transaction
            ], 201)->toResponse($request);
        }
        catch (\Throwable $e) {
            // Rollback transaksi database jika terjadi error
            DB::rollBack();

            // Kembalikan response JSON dengan error message
            return response()->json([
                'message' => 'Gagal menyimpan transaksi',
                'error'   => $e->getMessage()
            ], 500)->toResponse($request);
        }
    }


    public function index(Request $request)
    {
        // // buat variabel totalTransactions untuk menyimpan jumlah total transaksi berdasarkan id
        // $totalTransactions = SellTransaction::count();

        // // buat variabel totalTransactionsStatus untuk menyimpan jumlah total transaksi yang selesai
        // $totalTransactionsStatus = SellTransaction::where('status', 'selesai')->count();

        // buat array status yang diperbolehkan untuk filter
        $allowedStatuses = ['all', 'menunggu konfirmasi', 'dijemput', 'diproses', 'selesai'];

        // ambil parameter status dari request
        $status = in_array($request->get('status'), $allowedStatuses) ? $request->get('status') : 'all';

        // buat query untuk mengambil data transaksi
        $query = SellTransaction::with('user', 'wastes');

        // filter berdasarkan status jika status tidak sama dengan 'all'
        if ($status !== 'all') {
            $query->where('status', $status);
        }

        // ambil data transaksi dengan pagination
        $transactions = $query->latest()->paginate(10);

        // return view dengan data transaksi
        return response(view('admin.transactions.index', compact('transactions')), 200);
    }


    // Menampilkan riwayat transaksi user.
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

    //Menampilkan detail transaksi berdasarkan ID.
    public function show($id)
    {
        $transaction = SellTransaction::with('items.waste')->findOrFail($id);

        // Hitung total_point sekaligus siapkan daftar item
        $totalPoint = 0;

        $items = $transaction->items->map(function ($item) use (&$totalPoint) {
            $pointPerItem = $item->waste->point_value * $item->quantity;
            $totalPoint += $pointPerItem;
            return [
                'name' => $item->waste->name,
                'point_value' => $item->waste->point_value,
                'quantity' => $item->quantity,
                // 'image' => Storage::url($item->waste->image),
            ];
        });
            // Susun data response
            $data = [
                'id' => $transaction->id,
                'date' => $transaction->created_at->toDateTimeString(),
                'total_point' => $totalPoint,
                'items' => $items,
            ];
        return response()->json($data);
    }

    //Admin: Ubah status menjadi 'dijemput'.
    public function pickup($id)
    {
        $transaction = SellTransaction::findOrFail($id);
        $transaction->status = 'dijemput';
        $transaction->save();

        return redirect()->back()->with('success', 'Transaksi sedang dijemput');
    }

    //Admin: Ubah status menjadi 'diproses'.
    public function markProcessed($id)
    {
        $transaction = SellTransaction::findOrFail($id);
        $transaction->status = 'diproses';
        $transaction->save();

        return redirect()->back()->with('success', 'Transaksi sedang diproses');
    }

    //Admin: Selesaikan transaksi dan tambahkan poin ke user.
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

    //Admin: Membatalkan transaksi.
    public function cancelTransaction($id)
    {
        $transaction = SellTransaction::findOrFail($id);
        $transaction->status = 'batal';
        $transaction->save();

        return redirect()->back()->with('success', 'Transaksi berhasil dibatalkan.');
    }

    // Hapus transaksi
    public function deleteTransaction($id)
    {
        $transaction = SellTransaction::findOrFail($id);
        $transaction->items()->delete(); // Hapus item terkait
        $transaction->delete(); // Hapus transaksi utama
        return back()->with('success', 'Transaksi berhasil dihapus.');
    }

}

