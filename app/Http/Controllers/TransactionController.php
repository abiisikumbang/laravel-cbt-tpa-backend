<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SellTransaction;

class TransactionController extends Controller
{
    /**
     * Menampilkan halaman tabel transaksi.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
{
    //buat variabel totalTransactions untuk menyimpan jumlah total transaksi berdasarkan id
    $totalTransactions = SellTransaction::count();
    $totalTransactionsStatus = SellTransaction::where('status', 'selesai')->count();

    $allowedStatuses = ['all', 'menunggu konfirmasi', 'dijemput', 'diproses', 'selesai'];
    $status = in_array($request->get('status'), $allowedStatuses) ? $request->get('status') : 'all';

    $query = SellTransaction::with('user');

    if ($status !== 'all') {
        $query->where('status', $status);
    }

    $transactions = $query->latest()->get();

    return response(view('admin.transactions.index', compact('transactions', 'totalTransactions')), 200);
}

}

