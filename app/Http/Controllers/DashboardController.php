<?php

// app/Http/Controllers/DashboardController.php
namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Ruangan;

class DashboardController extends Controller
{
    public function index()
    {
        $totalBarang = Barang::count();
        $totalRuangan = Ruangan::count();
        
        $barangBaik = Barang::where('kondisi', 'baik')->count();
        $barangRusak = Barang::whereIn('kondisi', ['rusak_ringan', 'rusak_berat'])->count();
        
        // Data untuk chart distribusi barang per ruangan
        $ruanganLabels = Ruangan::pluck('nama');
        $barangPerRuangan = Ruangan::withCount('barangs')->pluck('barangs_count');
        
        // Data untuk chart status barang
        $statusBarang = [
            Barang::where('status', 'tersedia')->count(),
            Barang::where('status', 'dipinjam')->count(),
            Barang::where('status', 'perbaikan')->count()
        ];
        
        // Data untuk chart kondisi barang
        $kondisiBarang = [
            Barang::where('kondisi', 'baik')->count(),
            Barang::where('kondisi', 'rusak_ringan')->count(),
            Barang::where('kondisi', 'rusak_berat')->count()
        ];
        
        // Aktivitas terbaru
        $recentActivities = Barang::with('ruangan')
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard', compact(
            'totalBarang',
            'totalRuangan',
            'barangBaik',
            'barangRusak',
            'ruanganLabels',
            'barangPerRuangan',
            'statusBarang',
            'kondisiBarang',
            'recentActivities'
        ));
    }
}