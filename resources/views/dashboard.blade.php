@extends('layouts.app')

@section('title', 'Dashboard - ASTERA')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-4 gap-6 mb-6">
    <!-- Card Statistik -->
    <div class="bg-white rounded-xl shadow-sm p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500">Total Barang</p>
                <h3 class="text-2xl font-bold text-gray-800">{{ $totalBarang }}</h3>
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
                <h3 class="text-2xl font-bold text-gray-800">{{ $totalRuangan }}</h3>
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
                <h3 class="text-2xl font-bold text-gray-800">{{ $barangBaik }}</h3>
            </div>
            <div class="p-3 rounded-full bg-emerald-100 text-emerald-600">
                <i class="fas fa-check-circle text-xl"></i>
            </div>
        </div>
        <div class="mt-4">
            <span class="text-green-500 text-sm font-medium">
                {{ number_format(($barangBaik/$totalBarang)*100, 1) }}% dari total
            </span>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500">Barang Rusak</p>
                <h3 class="text-2xl font-bold text-gray-800">{{ $barangRusak }}</h3>
            </div>
            <div class="p-3 rounded-full bg-red-100 text-red-600">
                <i class="fas fa-exclamation-triangle text-xl"></i>
            </div>
        </div>
        <div class="mt-4">
            <span class="text-red-500 text-sm font-medium">
                {{ number_format(($barangRusak/$totalBarang)*100, 1) }}% dari total
            </span>
        </div>
    </div>
</div>

<!-- Grafik Utama -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
    <div class="bg-white rounded-xl shadow-sm p-6 lg:col-span-2">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold text-gray-800">Distribusi Barang per Ruangan</h3>
            <select class="border rounded-lg px-3 py-1 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option>Bulan Ini</option>
                <option>3 Bulan Terakhir</option>
                <option>Tahun Ini</option>
            </select>
        </div>
        <div class="h-80">
            <canvas id="barangPerRuanganChart"></canvas>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Status Barang</h3>
        <div class="h-80">
            <canvas id="statusBarangChart"></canvas>
        </div>
    </div>
</div>

<!-- Tabel dan Grafik Tambahan -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="bg-white rounded-xl shadow-sm p-6 lg:col-span-2">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Aktivitas Terbaru</h3>
        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead>
                    <tr class="text-left border-b">
                        <th class="pb-3">Barang</th>
                        <th class="pb-3">Ruangan</th>
                        <th class="pb-3">Status</th>
                        <th class="pb-3">Terakhir Diupdate</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($recentActivities as $activity)
                    <tr>
                        <td class="py-3">{{ $activity->nama }}</td>
                        <td class="py-3">{{ $activity->ruangan->nama }}</td>
                        <td class="py-3">
                            <span class="px-2 py-1 rounded-full text-xs 
                                @if($activity->status == 'tersedia') bg-blue-100 text-blue-800
                                @elseif($activity->status == 'dipinjam') bg-purple-100 text-purple-800
                                @else bg-orange-100 text-orange-800 @endif">
                                {{ ucfirst($activity->status) }}
                            </span>
                        </td>
                        <td class="py-3">{{ $activity->updated_at->diffForHumans() }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Kondisi Barang</h3>
        <div class="h-80">
            <canvas id="kondisiBarangChart"></canvas>
        </div>
    </div>
</div>

<!-- Chart.js Script -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Chart 1: Distribusi Barang per Ruangan
        const ctx1 = document.getElementById('barangPerRuanganChart').getContext('2d');
        new Chart(ctx1, {
            type: 'bar',
            data: {
                labels: {!! json_encode($ruanganLabels) !!},
                datasets: [{
                    label: 'Jumlah Barang',
                    data: {!! json_encode($barangPerRuangan) !!},
                    backgroundColor: '#4F46E5',
                    borderRadius: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });

        // Chart 2: Status Barang
        const ctx2 = document.getElementById('statusBarangChart').getContext('2d');
        new Chart(ctx2, {
            type: 'doughnut',
            data: {
                labels: ['Tersedia', 'Dipinjam', 'Perbaikan'],
                datasets: [{
                    data: {!! json_encode($statusBarang) !!},
                    backgroundColor: [
                        '#3B82F6',
                        '#8B5CF6',
                        '#F59E0B'
                    ],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '70%',
                plugins: {
                    legend: { position: 'bottom' }
                }
            }
        });

        // Chart 3: Kondisi Barang
        const ctx3 = document.getElementById('kondisiBarangChart').getContext('2d');
        new Chart(ctx3, {
            type: 'pie',
            data: {
                labels: ['Baik', 'Rusak Ringan', 'Rusak Berat'],
                datasets: [{
                    data: {!! json_encode($kondisiBarang) !!},
                    backgroundColor: [
                        '#10B981',
                        '#F59E0B',
                        '#EF4444'
                    ],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { position: 'bottom' }
                }
            }
        });
    });
</script>
@endsection