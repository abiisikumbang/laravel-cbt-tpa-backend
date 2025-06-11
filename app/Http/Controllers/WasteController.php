<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Waste;

class WasteController extends Controller
{
    public function index()
{
    $wastes = Waste::all(); // Bisa juga pakai paginate() kalau banyak

    return response()->json([
        'message' => 'Daftar semua jenis sampah',
        'data' => $wastes
    ], 200);
}
}
