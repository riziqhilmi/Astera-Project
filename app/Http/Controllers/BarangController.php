<?php

// app/Http/Controllers/BarangController.php
namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Ruangan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BarangController extends Controller
{
    public function index(Request $request)
{
    // Simpan keyword pencarian untuk dikirim ke view
    $search = $request->input('search');

    // Mulai query barang dengan relasi 'ruangan'
    $query = Barang::with('ruangan');

    // Jika ada input pencarian
    if ($request->filled('search')) {
        $query->where(function ($q) use ($search) {
            $q->where('nama', 'like', '%' . $search . '%')
              ->orWhere('id', 'like', '%' . $search . '%')
              ->orWhere('kategori', 'like', '%' . $search . '%');
        });
    }

    // Ambil data hasil pencarian atau semua barang
    $barang = $query->get();

    // Kirim data + search ke view
    return view('data_barang.index', compact('barang', 'search'));
}

    public function create()
    {
        $ruangan = Ruangan::all();
        return view('data_barang.create', compact('ruangan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_ruangan' => 'required|exists:ruangans,id',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'nama' => 'required',
            'total' => 'required|integer|min:0',
            'kategori' => 'required',
            'tanggal_pembelian' => 'required|date',
            'kondisi' => 'required|in:baik,rusak_ringan,rusak_berat',
            'status' => 'required|in:tersedia,dipinjam,perbaikan'
        ]);

        $data = $request->except('foto');
        
        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('barang', 'public');
        }

        Barang::create($data);
        return redirect()->route('data_barang.index')->with('success', 'Barang berhasil ditambahkan');
    }

    public function edit(Barang $data_barang)
    {
        $ruangan = Ruangan::all();
        return view('data_barang.edit', compact('data_barang', 'ruangan'));
    }

    public function update(Request $request, Barang $data_barang)
    {
        $request->validate([
            'id_ruangan' => 'required|exists:ruangans,id',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'nama' => 'required',
            'total' => 'required|integer|min:0',
            'kategori' => 'required',
            'kondisi' => 'required|in:baik,rusak_ringan,rusak_berat',
            'tanggal_pembelian' => 'required|date',
            'status' => 'required|in:tersedia,dipinjam,perbaikan'
        ]);

        $data = $request->except('foto');
        
        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if ($data_barang->foto) {
                Storage::disk('public')->delete($data_barang->foto);
            }
            $data['foto'] = $request->file('foto')->store('barang', 'public');
        }

        $data_barang->update($data);
        return redirect()->route('data_barang.index')->with('success', 'Barang berhasil diupdate');
    }

    public function destroy(Barang $data_barang)
    {
        if ($data_barang->foto) {
            Storage::disk('public')->delete($data_barang->foto);
        }
        $data_barang->delete();
        return redirect()->route('data_barang.index')->with('success', 'Barang berhasil dihapus');
    }
}
