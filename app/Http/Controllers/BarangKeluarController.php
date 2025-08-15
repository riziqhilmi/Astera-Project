<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\BarangKeluar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Services\NotificationService;
use Illuminate\Support\Facades\Auth;

class BarangKeluarController extends Controller
{
    public function index()
    {
        $barangKeluar = BarangKeluar::with('barang')->latest()->paginate(10);
        $barangOptions = Barang::all();
        
        // Data untuk chart
        $chartData = BarangKeluar::select(
            DB::raw('strftime("%m", tanggal_keluar) as month'),
            DB::raw('strftime("%Y", tanggal_keluar) as year'),
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
        
        return view('operasional.barang_keluar.index', compact('barangKeluar', 'barangOptions', 'months', 'totals'));
    }

    public function store(Request $request)
{
    $request->validate([
        'id_barang' => 'required|exists:barangs,id',
        'jumlah' => 'required|integer|min:1',
        'tanggal_keluar' => 'required|date',
        'tujuan' => 'required|string|max:255',
        'penanggung_jawab' => 'required|string|max:255',
        'keterangan' => 'nullable|string'
    ]);
    
    $barang = Barang::find($request->id_barang);
    
    // Validasi stok cukup dengan pesan error khusus
    if ($barang->total < $request->jumlah) {
        return back()
            ->withInput()
            ->with('error', 'Stok barang tidak mencukupi. Stok tersedia: ' . $barang->total);
    }
    
    // Tambahkan barang keluar
    $barangKeluar = BarangKeluar::create($request->all());
    
    // Kurangi stok barang
    $barang->decrement('total', $request->jumlah);
    
    // Buat notifikasi untuk admin dan user operasional
    $users = \App\Models\User::whereIn('role', ['admin', 'user_operasional'])->get();
    foreach ($users as $user) {
        NotificationService::createBarangKeluarNotification(
            $user,
            $barang->nama_barang,
            $request->jumlah
        );
    }
    
    // Cek apakah stok menipis atau habis
    if ($barang->total <= 0) {
        // Notifikasi stok habis
        foreach ($users as $user) {
            NotificationService::createStokHabisNotification($user, $barang->nama_barang);
        }
    } elseif ($barang->total <= 5) {
        // Notifikasi stok menipis
        foreach ($users as $user) {
            NotificationService::createStokMenipisNotification($user, $barang->nama_barang, $barang->total);
        }
    }
    
    return redirect()->route('barang_keluar.index')
        ->with('success', 'Barang keluar berhasil dicatat');
}

    public function destroy($id)
    {
        $barangKeluar = BarangKeluar::findOrFail($id);
        $barang = $barangKeluar->barang;
        
        // Tambahkan kembali stok barang sebelum menghapus
        $barang->increment('total', $barangKeluar->jumlah);
        
        $barangKeluar->delete();
        
        return redirect()->route('barang_keluar.index')->with('success', 'Catatan barang keluar berhasil dihapus');
    }
}