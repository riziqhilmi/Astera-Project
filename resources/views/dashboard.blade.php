@extends('layouts.app')

@section('title', 'Dashboard - ASTERA')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-4 gap-6 mb-6">
    <!-- Card Statistik -->
    <div class="bg-white rounded-xl shadow-sm p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500">Total Barang</p>
                <h3 class="text-2xl font-bold text-gray-800">{{ $totalBarang ?? 0 }}</h3>
                <p class="text-sm text-gray-500 mt-1">Jumlah: {{ $totalQuantity ?? 0 }}</p>
            </div>
            <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                <i class="fas fa-box-open text-xl"></i>
            </div>
        </div>
        <div class="mt-4">
            <span class="text-green-500 text-sm font-medium">
                <i class="fas fa-arrow-up"></i> 12% dari bulan lalu
            </span>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500">Total Ruangan</p>
                <h3 class="text-2xl font-bold text-gray-800">{{ $totalRuangan ?? 0 }}</h3>
            </div>
            <div class="p-3 rounded-full bg-green-100 text-green-600">
                <i class="fas fa-door-open text-xl"></i>
            </div>
        </div>
        <div class="mt-4">
            <span class="text-green-500 text-sm font-medium">
                <i class="fas fa-arrow-up"></i> 5% dari bulan lalu
            </span>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500">Barang Baik</p>
                <h3 class="text-2xl font-bold text-gray-800">{{ $barangBaik ?? 0 }}</h3>
                <p class="text-sm text-gray-500 mt-1">Jumlah: {{ $barangBaikQuantity ?? 0 }}</p>
            </div>
            <div class="p-3 rounded-full bg-emerald-100 text-emerald-600">
                <i class="fas fa-check-circle text-xl"></i>
            </div>
        </div>
        <div class="mt-4">
            <span class="text-green-500 text-sm font-medium">
                {{ number_format(($persenBaik ?? 0), 1) }}% dari total
            </span>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500">Barang Rusak</p>
                <h3 class="text-2xl font-bold text-gray-800">{{ $barangRusak ?? 0 }}</h3>
                <p class="text-sm text-gray-500 mt-1">Jumlah: {{ $barangRusakQuantity ?? 0 }}</p>
            </div>
            <div class="p-3 rounded-full bg-red-100 text-red-600">
                <i class="fas fa-exclamation-triangle text-xl"></i>
            </div>
        </div>
        <div class="mt-4">
            <span class="text-red-500 text-sm font-medium">
                {{ number_format(($persenRusak ?? 0), 1) }}% dari total
            </span>
        </div>
    </div>
</div>

@if(($totalBarang ?? 0) == 0)
<div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 mb-6" role="alert">
    <p class="font-bold">Tidak ada data barang</p>
    <p>Silahkan tambahkan data barang terlebih dahulu untuk melihat statistik.</p>
</div>
@endif

<!-- Tabel Aktivitas Terbaru -->
<div class="bg-white rounded-xl shadow-sm p-6 mb-6">
    <h3 class="text-lg font-semibold text-gray-800 mb-4">Aktivitas Terbaru</h3>
    <div class="overflow-x-auto">
        <table class="min-w-full">
            <thead>
                <tr class="text-left border-b">
                    <th class="pb-3">Barang</th>
                    <th class="pb-3">Ruangan</th>
                    <th class="pb-3">Jumlah</th>
                    <th class="pb-3">Status</th>
                    <th class="pb-3">Kondisi</th>
                    <th class="pb-3">Terakhir Diupdate</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($recentActivities ?? [] as $activity)
                <tr>
                    <td class="py-3">{{ $activity->nama ?? 'N/A' }}</td>
                    <td class="py-3">{{ $activity->ruangan->nama ?? 'N/A' }}</td>
                    <td class="py-3">{{ $activity->total ?? 0 }}</td>
                    <td class="py-3">
                        @php
                            $status = $activity->status ?? '';
                            $statusClass = '';
                            if ($status == 'tersedia') {
                                $statusClass = 'bg-blue-100 text-blue-800';
                            } elseif ($status == 'dipinjam') {
                                $statusClass = 'bg-purple-100 text-purple-800';
                            } else {
                                $statusClass = 'bg-orange-100 text-orange-800';
                            }
                        @endphp
                        <span class="px-2 py-1 rounded-full text-xs {{ $statusClass }}">
                            {{ ucfirst($status ?: 'N/A') }}
                        </span>
                    </td>
                    <td class="py-3">
                        @php
                            $kondisi = $activity->kondisi ?? '';
                            $kondisiClass = '';
                            if ($kondisi == 'baik') {
                                $kondisiClass = 'bg-green-100 text-green-800';
                            } elseif ($kondisi == 'rusak_ringan') {
                                $kondisiClass = 'bg-yellow-100 text-yellow-800';
                            } else {
                                $kondisiClass = 'bg-red-100 text-red-800';
                            }
                        @endphp
                        <span class="px-2 py-1 rounded-full text-xs {{ $kondisiClass }}">
                            {{ ucfirst(str_replace('_', ' ', $kondisi ?: 'N/A')) }}
                        </span>
                    </td>
                    <td class="py-3">
                        @if($activity->updated_at)
                            {{ $activity->updated_at->diffForHumans() }}
                        @else
                            N/A
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="py-3 text-center text-gray-500">Tidak ada aktivitas terbaru</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Statistik Detail -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <div class="bg-white rounded-xl shadow-sm p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Statistik Status Barang</h3>
        <div class="space-y-4">
            <div class="flex justify-between items-center">
                <span class="text-gray-600">Tersedia</span>
                <span class="font-semibold">{{ $statusBarang[0] ?? 0 }} barang</span>
            </div>
            <div class="flex justify-between items-center">
                <span class="text-gray-600">Dipinjam</span>
                <span class="font-semibold">{{ $statusBarang[1] ?? 0 }} barang</span>
            </div>
            <div class="flex justify-between items-center">
                <span class="text-gray-600">Perbaikan</span>
                <span class="font-semibold">{{ $statusBarang[2] ?? 0 }} barang</span>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Statistik Kondisi Barang</h3>
        <div class="space-y-4">
            <div class="flex justify-between items-center">
                <span class="text-gray-600">Baik</span>
                <span class="font-semibold">{{ $kondisiBarang[0] ?? 0 }} barang</span>
            </div>
            <div class="flex justify-between items-center">
                <span class="text-gray-600">Rusak Ringan</span>
                <span class="font-semibold">{{ $kondisiBarang[1] ?? 0 }} barang</span>
            </div>
            <div class="flex justify-between items-center">
                <span class="text-gray-600">Rusak Berat</span>
                <span class="font-semibold">{{ $kondisiBarang[2] ?? 0 }} barang</span>
            </div>
        </div>
    </div>
</div>

<!-- Distribusi per Ruangan -->
@if(!empty($ruanganLabels))
<div class="bg-white rounded-xl shadow-sm p-6 mt-6">
    <h3 class="text-lg font-semibold text-gray-800 mb-4">Distribusi Barang per Ruangan</h3>
    <div class="overflow-x-auto">
        <table class="min-w-full">
            <thead>
                <tr class="text-left border-b">
                    <th class="pb-3">Ruangan</th>
                    <th class="pb-3">Jumlah Barang</th>
                    <th class="pb-3">Total Kuantitas</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach($ruanganLabels as $index => $ruangan)
                <tr>
                    <td class="py-3">{{ $ruangan }}</td>
                    <td class="py-3">{{ $barangPerRuangan[$index] ?? 0 }}</td>
                    <td class="py-3">{{ $barangQuantityPerRuangan[$index] ?? 0 }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif
@endsection