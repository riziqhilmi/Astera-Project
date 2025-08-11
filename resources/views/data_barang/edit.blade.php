@extends('layouts.app')

@section('content')
<div class="bg-white rounded-lg shadow-sm p-6 max-w-3xl mx-auto">
    <h2 class="text-xl font-semibold mb-6">Edit Data Barang</h2>
    
    <form action="{{ route('data_barang.update', $data_barang->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="id_ruangan" class="block text-gray-700 mb-2">Ruangan</label>
                <select name="id_ruangan" id="id_ruangan" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    <option value="">Pilih Ruangan</option>
                    @foreach($ruangan as $item)
                    <option value="{{ $item->id }}" {{ $data_barang->id_ruangan == $item->id ? 'selected' : '' }}>
                        {{ $item->nama }}
                    </option>
                    @endforeach
                </select>
            </div>
            
            <div>
                <label for="foto" class="block text-gray-700 mb-2">Foto Barang</label>
                <input type="file" name="foto" id="foto" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                
                @if($data_barang->foto)
                <div class="mt-2">
                    <img src="{{ asset('storage/'.$data_barang->foto) }}" alt="Foto Barang" class="w-32 h-32 object-cover rounded">
                    <p class="text-sm text-gray-500 mt-1">Foto saat ini</p>
                </div>
                @endif
            </div>
            
            <div>
                <label for="nama" class="block text-gray-700 mb-2">Nama Barang</label>
                <input type="text" name="nama" id="nama" value="{{ old('nama', $data_barang->nama) }}" 
                       class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>
            
            <div>
    <label for="total" class="block text-gray-700 mb-2">Total</label>
    <input type="number" name="total" id="total" min="0"
           value="{{ old('total', $data_barang->total) }}" 
           class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
</div>

<div>
    <label for="kategori" class="block text-gray-700 mb-2">Kategori</label>
    <select name="kategori" id="kategori" 
        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
        <option value="Elektronik" {{ old('kategori', $data_barang->kategori) == 'Elektronik' ? 'selected' : '' }}>Elektronik</option>
        <option value="Furniture" {{ old('kategori', $data_barang->kategori) == 'Furniture' ? 'selected' : '' }}>Furniture</option>
        <option value="ATK" {{ old('kategori', $data_barang->kategori) == 'ATK' ? 'selected' : '' }}>ATK</option>
    </select>
</div>

            
            <div>
                <label for="kondisi" class="block text-gray-700 mb-2">Kondisi</label>
                <select name="kondisi" id="kondisi" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    <option value="baik" {{ $data_barang->kondisi == 'baik' ? 'selected' : '' }}>Baik</option>
                    <option value="rusak_ringan" {{ $data_barang->kondisi == 'rusak_ringan' ? 'selected' : '' }}>Rusak Ringan</option>
                    <option value="rusak_berat" {{ $data_barang->kondisi == 'rusak_berat' ? 'selected' : '' }}>Rusak Berat</option>
                </select>
            </div>
            
            <div>
                <label for="status" class="block text-gray-700 mb-2">Status</label>
                <select name="status" id="status" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    <option value="tersedia" {{ $data_barang->status == 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                    <option value="dipinjam" {{ $data_barang->status == 'dipinjam' ? 'selected' : '' }}>Dipinjam</option>
                    <option value="perbaikan" {{ $data_barang->status == 'perbaikan' ? 'selected' : '' }}>Perbaikan</option>
                </select>
            </div>
            
            <div>
                <label for="tanggal_pembelian" class="block text-gray-700 mb-2">Tanggal Pembelian</label>
                <input type="date" name="tanggal_pembelian" id="tanggal_pembelian" 
                       value="{{ old('tanggal_pembelian', $data_barang->tanggal_pembelian->format('Y-m-d')) }}" 
                       class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>
        </div>
        
        <div class="flex justify-end mt-6 space-x-3">
            <a href="{{ route('data_barang.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-6 py-2 rounded-lg">
                Batal
            </a>
            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded-lg">
                Update
            </button>
        </div>
    </form>
</div>
@endsection