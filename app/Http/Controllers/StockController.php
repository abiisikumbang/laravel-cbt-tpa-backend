<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\StoreStockRequest;
use App\Http\Requests\UpdateStockRequest;
use App\Models\Stock;
use Illuminate\Support\Facades\Storage;

class StockController extends Controller
{

    //controller untuk menampilkan detail stok
    public function show(string $id)
    {
        $stock = Stock::findOrFail($id);
        return view('admin.stocks.modals.show', compact('stock'));
    }
    //controller untuk menampilkan form edit stok
    public function edit(string $id)
    {
        $stock = Stock::findOrFail($id);
        return view('admin.stocks.modals.edit', compact('stock'));
    }
     //controller untuk menampilkan form tambah stok
    public function create()
    {
         return view('admin.stocks.modals.create');
    }


    //controller untuk menampilkan daftar stok
    public function index()
    {
        $stocks = Stock::latest()->get();
        return view('admin.stocks.index', compact('stocks'));
    }

    //controller untuk menyimpan data stok baru
    public function store(StoreStockRequest $request)
    {
        try {
            $imagePath = $request->file('image')->storePublicly('stocks', 'public');

            Stock::create([
                'name' => $request->name,
                'point_cost' => $request->point_cost,
                'stock' => $request->stock,
                'image' => $imagePath,
            ]);

            return redirect()->route('stocks.index')->with('success', 'Stock berhasil ditambahkan.');
        } catch (\Exception $e) {
            Log::error('Failed to store stock: ' . $e->getMessage());

            return redirect()->back()->withInput()->with('error', 'Gagal menyimpan data stok.');
        }
    }

    //controller untuk memperbarui data stok
    public function update(UpdateStockRequest $request, Stock $stock)
    {
        try {
            $data = $request->validated();

            if ($request->hasFile('image')) {
                if ($stock->image && Storage::disk('public')->exists($stock->image)) {
                    Storage::disk('public')->delete($stock->image);
                }

                $data['image'] = $request->file('image')->store('stocks', 'public');
            }

            $stock->update($data);

            return redirect()->route('stocks.index')->with('success', 'Produk berhasil diperbarui');
        } catch (\Exception $e) {
            Log::error("Failed to update stock with ID {$stock->id}: {$e->getMessage()}");

            return redirect()->back()->withInput()->with('error', 'Gagal memperbarui produk.');
        }
    }

    //controller untuk menghapus stok
    public function destroy(string $id)
    {
        try {
            $stock = Stock::findOrFail($id);
            // Hapus gambar jika ada
            if ($stock->image && Storage::disk('public')->exists($stock->image)) {
                Storage::disk('public')->delete($stock->image);
            }

            $stock->delete();

            return redirect()->route('stocks.index')->with('success', 'Produk berhasil dihapus');
        } catch (\Exception $e) {
            Log::error("Gagal menghapus produk dengan ID {$id}: {$e->getMessage()}");

            return redirect()->back()->withInput()->with('error', 'Gagal menghapus produk.');
        }
    }
}
