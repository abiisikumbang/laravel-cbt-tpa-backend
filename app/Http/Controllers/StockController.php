<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Stock;
use Illuminate\Support\Facades\Storage;

class StockController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $stocks = Stock::latest()->get();
        return view('admin.stocks.index', compact('stocks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
         return view('admin.stocks.modals.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
        'name' => 'required|string',
        'point_cost' => 'required|integer',
        'stock' => 'required|integer',
        'image' => 'required|image|max:2048',
    ]);

    $imagePath = $request->file('image')->store('stocks', 'public');

    Stock::create([
        'name' => $validated['name'],
        'point_cost' => $validated['point_cost'],
        'stock' => $validated['stock'],
        'image' => $imagePath,
    ]);

    return redirect()->route('stocks.index')->with('success', 'Stock berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $stock = Stock::findOrFail($id);
        return view('admin.stocks.modals.show', compact('stock'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $stock = Stock::findOrFail($id);
        return view('admin.stocks.modals.edit', compact('stock'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
        'name' => 'required|string|max:255',
        'point_cost' => 'required|numeric',
        'stock' => 'required|integer',
        'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
    ]);

    $stock = Stock::findOrFail($id);

    $imagePath = $stock->image;
    if ($request->hasFile('image')) {
        // Hapus gambar lama jika ada
        if ($stock->image && Storage::disk('public')->exists($stock->image)) {
            Storage::disk('public')->delete($stock->image);
        }
        $imagePath = $request->file('image')->store('products', 'public');
    }

    $stock->update([
        'name' => $request->name,
        'point_cost' => $request->point_cost,
        'stock' => $request->stock,
        'image' => $imagePath,
    ]);

    return redirect()->route('stocks.index')->with('success', 'Produk berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $stock = Stock::findOrFail($id);
        // Hapus gambar jika ada
        if ($stock->image && Storage::disk('public')->exists($stock->image)) {
            Storage::disk('public')->delete($stock->image);
        }

        $stock->delete();

        return redirect()->route('stocks.index')->with('success', 'Produk berhasil dihapus');
    }
}
