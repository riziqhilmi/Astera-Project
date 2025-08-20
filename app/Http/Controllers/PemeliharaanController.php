<?php

namespace App\Http\Controllers;

use App\Models\Pemeliharaan;
use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class PemeliharaanController extends Controller
{
    public function index()
{
    $pemeliharaan = Pemeliharaan::with('barang')->latest()->paginate(10);
    $barangOptions = Barang::where('kondisi', '!=', 'rusak_berat')->get();
    
    // Data untuk chart
    $chartData = Pemeliharaan::select(
        DB::raw('MONTH(tanggal_mulai) as month'),
        DB::raw('YEAR(tanggal_mulai) as year'),
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
    
    return view('operasional.pemeliharaan.index', compact('pemeliharaan', 'barangOptions', 'months', 'totals'));
}

    public function create()
    {
        $barang = Barang::where('kondisi', '!=', 'rusak_berat')->get();
        return view('operasional.pemeliharaan.create', compact('barang'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'barang_id' => 'required|exists:barangs,id',
            'tanggal_mulai' => 'required|date',
            'jenis_pemeliharaan' => 'required|in:rutin,preventif,korektif',
            'biaya' => 'required|numeric|min:0',
            'keterangan' => 'required',
            'teknisi' => 'required',
            'status' => 'required|in:dijadwalkan,dalam_pengerjaan,selesai,ditunda'
        ]);

        Pemeliharaan::create($request->all());

        // Update status barang jika pemeliharaan sedang berlangsung
        if ($request->status == 'dalam_pengerjaan') {
            Barang::find($request->barang_id)->update(['status' => 'perbaikan']);
        }

        return redirect()->route('pemeliharaan.index')->with('success', 'Jadwal pemeliharaan berhasil dibuat');
    }

    public function edit(Pemeliharaan $pemeliharaan)
    {
        $barang = Barang::all();
        return view('operasional.pemeliharaan.edit', compact('pemeliharaan', 'barang'));
    }

    public function update(Request $request, Pemeliharaan $pemeliharaan)
    {
        $request->validate([
            'barang_id' => 'required|exists:barangs,id',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'nullable|date',
            'jenis_pemeliharaan' => 'required|in:rutin,preventif,korektif',
            'biaya' => 'required|numeric|min:0',
            'keterangan' => 'required',
            'teknisi' => 'required',
            'status' => 'required|in:dijadwalkan,dalam_pengerjaan,selesai,ditunda'
        ]);

        $pemeliharaan->update($request->all());

        // Update status barang berdasarkan status pemeliharaan
        $barang = Barang::find($request->barang_id);
        if ($request->status == 'selesai') {
            $barang->update(['status' => 'tersedia', 'kondisi' => 'baik']);
        } elseif ($request->status == 'dalam_pengerjaan') {
            $barang->update(['status' => 'perbaikan']);
        }

        return redirect()->route('pemeliharaan.index')->with('success', 'Data pemeliharaan berhasil diupdate');
    }

    public function destroy(Pemeliharaan $pemeliharaan)
    {
        $pemeliharaan->delete();
        return redirect()->route('pemeliharaan.index')->with('success', 'Data pemeliharaan berhasil dihapus');
    }
}