<?php

namespace App\Http\Controllers;
use App\Http\Requests\StoreWasteRequest;
use App\Http\Requests\UpdateWasteRequest;
use App\Models\Waste;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;


class WasteController extends Controller
{

    //controller untuk menampilkan daftar sampah
    public function indexApi()
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




    //controller untuk menampilkan daftar sampah untuk admin
    public function index()
    {
        $wastes = Waste::all();
        return view('admin.wastes.index', compact('wastes'));
    }
    //controller untuk menampilkan form tambah sampah
    public function create()
    {
        return view('wastes.create');
    }
    //controller untuk menyimpan data sampah baru
    public function store(StoreWasteRequest $request)
    {
        try {
            // Simpan file gambar secara publik dan dapatkan pathnya
            $imagePath = $request->file('image')->storePublicly('wastes', 'public');

            // Buat data sampah baru dengan informasi yang diberikan
            $waste = Waste::create([
                'name' => $request->name, // Set nama sampah
                'point_value' => $request->point_value, // Set nilai poin
                'satuan' => $request->satuan, // Set satuan
                'image' => $imagePath, // Set path gambar
            ]);

            // Periksa jika response yang diharapkan adalah JSON
            if ($request->expectsJson()) {
                // Kembalikan response JSON dengan pesan sukses dan data sampah
                return response()->json([
                    'message' => 'Data sampah berhasil ditambahkan.',
                    'data' => $waste->append('image_url'), // Tambahkan URL gambar
                ], 201);
            }

            // Redirect ke halaman indeks sampah dengan pesan sukses
            return redirect()->route('wastes.index')
                            ->with('success', 'Data berhasil ditambahkan.');
        } catch (\Exception $e) {
            // Catat error jika terjadi kegagalan saat menyimpan sampah
            Log::error('Failed to store waste: '.$e->getMessage());
            // Kembalikan response error secara JSON
            return response()->json(['error' => 'Something went wrong.'], 500);
        }
    }
    //controller untuk mengupdate data sampah
    public function update(UpdateWasteRequest $request, Waste $waste)
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            if ($waste->image) {
                Storage::disk('public')->delete($waste->image);
            }
            $data['image'] = $request->file('image')->storePublicly('wastes', 'public');
        }

        $waste->update($data);

        return redirect()->route('wastes.index')->with('success', 'Data sampah diperbarui.');
    }
    //controller untuk menghapus data sampah
    public function destroy(Waste $waste) {
        try {
            // Hapus gambar dari penyimpanan jika ada
            if ($waste->image && Storage::disk('public')->exists($waste->image)) {
                Storage::disk('public')->delete($waste->image);
            }

            // Hapus data sampah
            $waste->delete();

            return back()->with('success', 'Data sampah dihapus.');
        } catch (\Exception $e) {
            // Catat error jika terjadi kegagalan saat menghapus sampah
            Log::error("Failed to delete waste with ID {$waste->id}: {$e->getMessage()}");
            return redirect()->route('wastes.index')->with('error', 'Gagal menghapus data sampah.');
        }
    }
}

