<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Waste;
use Illuminate\Support\Facades\Storage;

class WasteController extends Controller
{
    public function index()
    {
        $wastes = Waste::select('id', 'name', 'point_value', 'satuan', 'image')->paginate(10);

        // Ubah field `image` menjadi full URL
        $wastes = $wastes->map(function ($waste) {
            $waste->image = $waste->image ? url(Storage::url($waste->image)) : null;
            return $waste;
        });

        return response()->json([
            'data' => $wastes,
            'message' => 'Daftar sampah berhasil dimuat.'
        ], 200);
    }

    public function adminIndex()
    {
        $wastes = Waste::all();
        return view('admin.wastes.index', compact('wastes'));
    }

    public function create()
    {
        return view('wastes.create');
    }

    public function store(Request $request)
    {
        $request->validate([

            'name' => 'required|string|max:255',
            'point_value' => 'required|integer|min:0',
            'satuan' => 'required|string|max:50',
            'image' => 'nullable|image|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('wastes', 'public');
        }

        $waste = Waste::create([
            'name' => $request->name,
            'point_value' => $request->point_value,
            'satuan' => $request->satuan,
            'image' => $imagePath,
        ]);

        if ($request->expectsJson() || $request->isJson()) {
            return response()->json([
                'message' => 'Data sampah berhasil ditambahkan.',
                'data' => $waste->append('image_url')
            ], 201);
        }

        return redirect()->route('wastes.index')->with('success', 'Data berhasil ditambahkan.');
    }

    public function update(Request $request, Waste $waste) {
        $data = $request->validate([
            'name' => 'required',
            'point_value' => 'required|integer|min:0',
            'satuan' => 'required',
            'image' => 'nullable|image',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('wastes', 'public');
        }

        $waste->update($data);
        return back()->with('success', 'Data sampah diperbarui.');
    }

    public function destroy(Waste $waste) {
        $waste->delete();
        return back()->with('success', 'Data sampah dihapus.');
    }
}

