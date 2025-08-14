<!-- create.blade.php -->
@extends('layouts.app')

@section('content')
<div class="bg-white rounded-lg shadow-sm p-6 mb-6 border border-gray-100">
    <h3 class="text-lg font-medium text-gray-800 mb-4 flex items-center">
        <i class="fas fa-plus-circle text-blue-500 mr-2"></i> Tambah Barang
    </h3>
    
    <form action="{{ route('data_barang.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            <!-- Ruangan -->
            <div class="space-y-1">
                <label class="block text-sm font-medium text-gray-700">
                    <span class="text-red-500">*</span> Ruangan
                </label>
                <select name="id_ruangan" 
                        class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 text-sm py-2.5 px-4 shadow-sm" required>
                    <option value="">Pilih Ruangan</option>
                    @foreach($ruangan as $item)
                        <option value="{{ $item->id }}">{{ $item->nama }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Foto Barang -->
            <div class="space-y-1">
                <label class="block text-sm font-medium text-gray-700">Foto Barang</label>
                <input type="file" name="foto" id="foto" 
                       class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 text-sm py-2.5 px-4 shadow-sm">
            </div>

            <!-- Nama Barang -->
            <div class="space-y-1">
                <label class="block text-sm font-medium text-gray-700">
                    <span class="text-red-500">*</span> Nama Barang
                </label>
                <input type="text" name="nama" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 text-sm py-2.5 px-4 shadow-sm" required>
            </div>

            <!-- Total -->
            <div class="space-y-1">
                <label class="block text-sm font-medium text-gray-700">
                    <span class="text-red-500">*</span> Total
                </label>
                <input type="number" name="total" min="1" value="{{ old('total') }}" 
                       class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 text-sm py-2.5 px-4 shadow-sm" required>
            </div>

            <!-- Kategori -->
            <div class="space-y-1">
                <label class="block text-sm font-medium text-gray-700">Kategori</label>
                <select name="kategori" id="kategori" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                <option value="Elektronik">Elektronik</option>
                <option value="Furniture">Furniture</option>
                <option value="ATK">ATK</option>
                </select>
            </div>
            
            <!-- Kondisi -->
            <div class="space-y-1">
                <label class="block text-sm font-medium text-gray-700">
                    <span class="text-red-500">*</span> Kondisi
                </label>
                <select name="kondisi" 
                        class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 text-sm py-2.5 px-4 shadow-sm" required>
                    <option value="">Pilih Kondisi</option>
                     <option value="baik">Baik</option>
                    <option value="rusak_ringan">Rusak Ringan</option>
                    <option value="rusak_berat">Rusak Berat</option>
                </select>
            </div>

                        <!-- Status -->
            <div class="space-y-1">
                <label class="block text-sm font-medium text-gray-700">Status</label>
                 <select name="status" id="status" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 text-sm py-2.5 px-4 shadow-sm">
                    <option value="tersedia">Tersedia</option>
                    <option value="dipinjam">Dipinjam</option>
                    <option value="perbaikan">Perbaikan</option>
                </select>
            </div>
<!-- Tanggal Pembelian -->
<div class="space-y-1">
    <label for="tanggal_pembelian" class="block text-sm font-medium text-gray-700">
        <span class="text-red-500">*</span> Tanggal Pembelian
    </label>
    <input type="text" name="tanggal_pembelian" id="tanggal_pembelian"
           value="{{ old('tanggal_pembelian', date('Y-m-d')) }}" 
           class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 text-sm py-2.5 px-4 shadow-sm" required>
</div>

        </div>
            <div class="pt-4 flex justify-end space-x-3 border-t border-gray-100">
            <a href="{{ route('data_barang.index') }}" 
               class="px-5 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">
                <i class="fas fa-times mr-2"></i> Batal
            </a>
            <button type="submit" 
                    class="px-5 py-2.5 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 flex items-center">
                <i class="fas fa-save mr-2"></i> Simpan Data
            </button>
        </div>
    </form>
</div>
@endsection
@push('styles')
    <!-- Flatpickr CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
@endpush

@push('scripts')
    <!-- Flatpickr JS -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://npmcdn.com/flatpickr/dist/l10n/id.js"></script>
    <script>
flatpickr("#tanggal_pembelian", {
    dateFormat: "Y-m-d", // format untuk database
    altInput: true,
    altFormat: "j F Y", // format untuk user (bulan lengkap)
    locale: "id",
    defaultDate: "{{ old('tanggal_pembelian', date('Y-m-d')) }}",
    maxDate: "today" // hanya bisa pilih sampai hari ini
});
</script>
@endpush