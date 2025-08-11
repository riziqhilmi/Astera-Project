<!-- create.blade.php -->
@extends('layouts.app')

@section('content')
<div class="bg-white rounded-lg shadow-sm p-6 max-w-3xl mx-auto">
    <h2 class="text-xl font-semibold mb-6">Tambah Barang</h2>
    
    <form action="{{ route('data_barang.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="id_ruangan" class="block text-gray-700 mb-2">Ruangan</label>
                <select name="id_ruangan" id="id_ruangan" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    <option value="">Pilih Ruangan</option>
                    @foreach($ruangan as $item)
                    <option value="{{ $item->id }}">{{ $item->nama }}</option>
                    @endforeach
                </select>
            </div>
            
            <div>
                <label for="foto" class="block text-gray-700 mb-2">Foto Barang</label>
                <input type="file" name="foto" id="foto" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            
            <div>
                <label for="nama" class="block text-gray-700 mb-2">Nama Barang</label>
                <input type="text" name="nama" id="nama" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>
            
            <div>
    <label for="total" class="block text-gray-700 mb-2">Total</label>
    <input type="number" name="total" id="total" min="0"
        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
        value="{{ old('total') }}" required>
</div>
            
            <div>
                <label for="kategori" class="block text-gray-700 mb-2">Kategori</label>
                <select name="kategori" id="kategori" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                <option value="baik">Elektronik</option>
                <option value="baik">Furniture</option>
                <option value="baik">ATK</option>
                </select>
            </div>
            
            <div>
                <label for="kondisi" class="block text-gray-700 mb-2">Kondisi</label>
                <select name="kondisi" id="kondisi" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    <option value="baik">Baik</option>
                    <option value="rusak_ringan">Rusak Ringan</option>
                    <option value="rusak_berat">Rusak Berat</option>
                </select>
            </div>
            
            <div>
                <label for="status" class="block text-gray-700 mb-2">Status</label>
                <select name="status" id="status" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    <option value="tersedia">Tersedia</option>
                    <option value="dipinjam">Dipinjam</option>
                    <option value="perbaikan">Perbaikan</option>
                </select>
            </div>
            
            <div>
                <label for="tanggal_pembelian" class="block text-gray-700 mb-2">Tanggal Pembelian</label>
                <input type="date" name="tanggal_pembelian" id="tanggal_pembelian" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>
        </div>
        
        <div class="flex justify-end mt-6">
            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded-lg">
                Simpan
            </button>
        </div>
    </form>
</div>
@endsection

