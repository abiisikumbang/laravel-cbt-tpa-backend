<?php

namespace App\Http\Controllers;

use App\Models\RewardRedeem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


 // controller untuk mengurus tabel redeem pada admin
class RedeemController extends Controller
{
    public function index(Request $request)
    {
        // //buat variabel totalRedeems untuk menyimpan jumlah total redeems berdasarkan id
        // $totalRedeems = RewardRedeem::count();
        // $totalRedeemStatus = RewardRedeem::where('status', 'selesai')->count();

        //untuk filter
        $allowedStatuses = ['all', 'Menunggu Konfirmasi', 'diantar', 'diproses', 'selesai'];
        $status = in_array($request->get('status'), $allowedStatuses) ? $request->get('status') : 'all';

        //buat query untuk mengambil data redeem
        $query = RewardRedeem::with('user', 'items.stock');

        if ($status !== 'all') {
            $query->where('status', $status);
        }

        $redeems = $query->latest()->paginate(10);

        //return view dengan data redeem
        return response(view('admin.redeem.index', compact('redeems')), 200);
    }
    public function detail($id)
    {
    $redeem = RewardRedeem::with(['user', 'items.stock'])->findOrFail($id);

    $data = [
        'id' => $redeem->id,
        'user_name' => $redeem->user->name,
        'total_points_spent' => $redeem->total_points_spent,
        'items' => $redeem->items->map(function ($item) {
            return [
                'name' => $item->stock->name,
                'quantity' => $item->quantity,
                'point_spent_per_item' => $item->point_spent_per_item,
            ];
        }),
    ];

    return response()->json($data);
    }

    //fungsi delivered transaction redeem
    public function delivered($id)
    {
        $redeem = RewardRedeem::find($id);
        $redeem->status = 'diantar';
        $redeem->save();

        return redirect()->back()->with('success', 'Transaksi sedang diantar');
    }

    //admin ubah status menjadi diproses
    public function Processed($id)
    {
        $redeem = RewardRedeem::find($id);
        $redeem->status = 'diproses';
        $redeem->save();

        return redirect()->back()->with('success', 'Transaksi sedang diproses');
    }

    //Admin selesaikan transaksi rededem dan kurangi poin ke user
    public function completeRedeem($id)
    {
        DB::beginTransaction();

        try {
            $redeem = RewardRedeem::with('items', 'user')->findOrFail($id);

            if ($redeem->status !== 'diproses') {
                return redirect()->back()->with('error', 'Transaksi tidak dalam status yang valid untuk diselesaikan.');
            }

            // Gunakan total poin yang disimpan di reward_redeem
            $totalPoints = $redeem->total_points_spent;

            if ($redeem->user->total_points < $totalPoints) {
                return redirect()->back()->with('error', 'Poin tidak cukup. Dibutuhkan: ' . $totalPoints . ', Tersedia: ' . $redeem->user->total_points);
            }

            // Kurangi poin user
            $redeem->user->total_points -= $totalPoints;
            $redeem->user->save();

            // Update status transaksi
            $redeem->status = 'selesai';
            $redeem->save();

            DB::commit();
            return redirect()->back()->with('success', 'Transaksi diselesaikan dan poin dikurangi.');
        } catch (\Throwable $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyelesaikan transaksi: ' . $e->getMessage());
        }
    }

    public function deleteTransaction($id)
    {
        $redeem = RewardRedeem::findOrFail($id);
        $redeem->items()->delete(); // Hapus item terkait
        $redeem->delete(); // Hapus transaksi utama
        return back()->with('success', 'Transaksi berhasil dihapus.');
    }

}

