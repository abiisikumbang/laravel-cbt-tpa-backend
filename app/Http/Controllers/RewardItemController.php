<?php

namespace App\Http\Controllers;
use App\Models\Stock;


//controller untuk menampilkan data reward pada api
class RewardItemController extends Controller
{
    public function index()
    {
        $items = Stock::where('stock', '>', 0)->get();

        // Ubah field image menjadi full URL
        $items->transform(function ($item) {
            if ($item->image) {
                $item->image = url('storage/' . ltrim($item->image, '/'));
            }
            return $item;
        });

        return response()->json([
            'status' => true,
            'data' => $items
        ]);
    }
}

