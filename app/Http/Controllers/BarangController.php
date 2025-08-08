<?php

// app/Http/Controllers/BarangController.php
namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Ruangan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BarangController extends Controller
{
    public function index()
    {
        $barang = Barang::with('ruangan')->get();
        return view('data_barang.index', compact('barang'));
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
            'kategori' => 'required',
            'kondisi' => 'required|in:baik,rusak_ringan,rusak_berat',
            'tanggal_pembelian' => 'required|date',
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