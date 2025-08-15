<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\BarangMasuk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Services\NotificationService;
use Illuminate\Support\Facades\Auth;

class BarangMasukController extends Controller
{
    public function index()
    {
        $barangMasuk = BarangMasuk::with('barang')->latest()->paginate(10);
        $barangOptions = Barang::all();
        
        // Data untuk chart
        $chartData = BarangMasuk::select(
            DB::raw('strftime("%m", tanggal_masuk) as month'),
            DB::raw('strftime("%Y", tanggal_masuk) as year'),
            DB::raw('SUM(jumlah) as total')
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
        
        return view('operasional.barang_masuk.index', compact('barangMasuk', 'barangOptions', 'months', 'totals'));
    }

    public function store(Request $request)
    {
    $request->validate([
        'id_barang' => 'required|exists:barangs,id',
        'jumlah' => 'required|integer|min:1',
        'tanggal_masuk' => 'required|date',
        'supplier' => 'required|string|max:255',
        'penerima' => 'required|string|max:255',
        'keterangan' => 'nullable|string'
    ]);

    DB::transaction(function () use ($request) {
        // Ambil barang
        $barang = Barang::findOrFail($request->id_barang);

        // Tambahkan barang masuk
        $barangMasuk = BarangMasuk::create([
            'id_barang'     => $barang->id,
            'jumlah'        => $request->jumlah,
            'tanggal_masuk' => $request->tanggal_masuk,
            'supplier'      => $request->supplier,
            'penerima'      => $request->penerima,
            'keterangan'    => $request->keterangan
        ]);

        // Update stok barang
        $barang->increment('total', $request->jumlah);

        // Buat notifikasi hanya kalau nama barang tidak null
        $barangName = $barang->nama_barang ?? $barang->nama ?? null;
        if (!empty($barangName)) {
            $users = \App\Models\User::whereIn('role', ['admin', 'user_operasional'])->get();
            foreach ($users as $user) {
                NotificationService::createBarangMasukNotification(
                    $user,
                    $barangName,
                    (int) $request->jumlah
                );
            }
        }
    });

    return redirect()->route('barang_masuk.index')
        ->with('success', 'Barang masuk berhasil dicatat');
    }


    public function destroy($id)
    {
        $barangMasuk = BarangMasuk::findOrFail($id);
        $barang = $barangMasuk->barang;
        
        // Kurangi stok barang sebelum menghapus
        $barang->decrement('total', $barangMasuk->jumlah);
        
        $barangMasuk->delete();
        
        return redirect()->route('barang_masuk.index')->with('success', 'Catatan barang masuk berhasil dihapus');
    }
}