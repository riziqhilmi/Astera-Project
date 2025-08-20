<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class PeminjamanController extends Controller
{
    public function index()
{
    $peminjaman = Peminjaman::with('barang')->latest()->paginate(10);
    $barangOptions = Barang::where('status', 'tersedia')->get();
    
    // Data untuk chart
    $chartData = Peminjaman::select(
        DB::raw('MONTH(tanggal_pinjam) as month'),
        DB::raw('YEAR(tanggal_pinjam) as year'),
        DB::raw('COUNT(*) as total')
    )
    ->groupBy('year', 'month')
    ->orderBy('year', 'asc')
    ->orderBy('month', 'asc')
    ->get();
    
    $months = [];
    $totals = [];
    
    foreach ($chartData as $data) {
        $months[] = date('M Y', mktime(0, 0, 0, $data->month, 1, $data->year));
        $totals[] = $data->total;
    }
    
    return view('operasional.peminjaman.index', compact('peminjaman', 'barangOptions', 'months', 'totals'));
}

    public function create()
    {
        $barang = Barang::where('status', 'tersedia')->get();
        return view('operasional.peminjaman.create', compact('barang'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'barang_id' => 'required|exists:barangs,id',
            'peminjam' => 'required',
            'tanggal_pinjam' => 'required|date',
            'jumlah' => 'required|integer|min:1',
            'keperluan' => 'required',
            'penanggung_jawab' => 'required'
        ]);

        $barang = Barang::find($request->barang_id);

        // Cek stok cukup
        if ($barang->total < $request->jumlah) {
            return back()->with('error', 'Stok barang tidak mencukupi. Stok tersedia: ' . $barang->total);
        }

        Peminjaman::create($request->all());

        // Kurangi stok barang
        $barang->decrement('total', $request->jumlah);

        // Update status barang jika stok habis
        if ($barang->total == 0) {
            $barang->update(['status' => 'dipinjam']);
        }

        return redirect()->route('peminjaman.index')->with('success', 'Peminjaman berhasil dicatat');
    }

    public function kembali($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        $barang = $peminjaman->barang;

        // Kembalikan stok barang
        $barang->increment('total', $peminjaman->jumlah);

        // Update status peminjaman
        $peminjaman->update([
            'tanggal_kembali' => now(),
            'status' => 'dikembalikan'
        ]);

        // Update status barang
        if ($barang->total > 0) {
            $barang->update(['status' => 'tersedia']);
        }

        return redirect()->route('peminjaman.index')->with('success', 'Barang berhasil dikembalikan');
    }

    public function destroy(Peminjaman $peminjaman)
    {
        // Kembalikan stok barang sebelum menghapus
        $barang = $peminjaman->barang;
        $barang->increment('total', $peminjaman->jumlah);

        $peminjaman->delete();
        return redirect()->route('peminjaman.index')->with('success', 'Data peminjaman berhasil dihapus');
    }
}