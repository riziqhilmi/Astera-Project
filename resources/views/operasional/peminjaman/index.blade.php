@extends('operasional.layout')

@section('title', 'Peminjaman Barang')
@section('chart-label', 'Peminjaman per Bulan')

@section('form')
<div class="bg-white rounded-lg shadow-sm p-6 mb-6 border border-gray-100">
    <h3 class="text-lg font-medium text-gray-800 mb-4 flex items-center">
        <i class="fas fa-hand-holding text-blue-500 mr-2"></i> Form Peminjaman Barang
    </h3>
    
    <form action="{{ route('peminjaman.store') }}" method="POST" class="space-y-4">
        @csrf
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Barang -->
            <div class="space-y-1">
                <label class="block text-sm font-medium text-gray-700">
                    <span class="text-red-500">*</span> Barang
                </label>
                <select name="barang_id" id="barangSelect" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 text-sm py-2.5 px-4 transition-all duration-200 shadow-sm" required onchange="updateStokInfo()">
                    <option value="">Pilih Barang</option>
                    @foreach($barangOptions as $barang)
                    <option value="{{ $barang->id }}" data-stok="{{ $barang->total }}" @selected(old('barang_id') == $barang->id)>
                        {{ $barang->nama }} (Stok: {{ $barang->total }})
                    </option>
                    @endforeach
                </select>
                <div id="stokInfo" class="text-xs text-gray-500 mt-1 hidden">
                    Stok tersedia: <span id="stokValue" class="font-medium">0</span>
                </div>
                <p class="text-xs text-gray-500 mt-1">Pilih barang yang akan dipinjam</p>
            </div>
            
            <!-- Jumlah -->
            <div class="space-y-1">
                <label class="block text-sm font-medium text-gray-700">
                    <span class="text-red-500">*</span> Jumlah
                </label>
                <div class="relative">
                    <input type="number" name="jumlah" id="jumlahInput" min="1" value="{{ old('jumlah') }}" 
                           class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 text-sm py-2.5 px-4 pr-10 transition-all duration-200 shadow-sm" 
                           required oninput="validateStok()">
                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                        <span class="text-gray-500 text-sm">unit</span>
                    </div>
                </div>
                <div id="stokWarning" class="text-xs text-red-500 mt-1 hidden flex items-start">
                    <i class="fas fa-exclamation-circle mr-1 mt-0.5"></i>
                    <span>Jumlah melebihi stok tersedia!</span>
                </div>
                <p class="text-xs text-gray-500 mt-1">Masukkan jumlah barang yang dipinjam</p>
            </div>
            
            <!-- Peminjam -->
            <div class="space-y-1">
                <label class="block text-sm font-medium text-gray-700">
                    <span class="text-red-500">*</span> Peminjam
                </label>
                <input type="text" name="peminjam" value="{{ old('peminjam') }}" 
                       class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 text-sm py-2.5 px-4 transition-all duration-200 shadow-sm" 
                       placeholder="Nama peminjam" required>
                <p class="text-xs text-gray-500 mt-1">Masukkan nama peminjam</p>
            </div>
            
            <!-- Tanggal Pinjam -->
            <div class="space-y-1">
                <label class="block text-sm font-medium text-gray-700">
                    <span class="text-red-500">*</span> Tanggal Pinjam
                </label>
                <div class="relative">
                    <input type="date" name="tanggal_pinjam" value="{{ old('tanggal_pinjam', date('Y-m-d')) }}" 
                           class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 text-sm py-2.5 px-4 transition-all duration-200 shadow-sm" 
                           required>
                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                        <i class="fas fa-calendar text-gray-400"></i>
                    </div>
                </div>
                <p class="text-xs text-gray-500 mt-1">Tanggal peminjaman barang</p>
            </div>
            
            <!-- Penanggung Jawab -->
            <div class="space-y-1">
                <label class="block text-sm font-medium text-gray-700">
                    <span class="text-red-500">*</span> Penanggung Jawab
                </label>
                <input type="text" name="penanggung_jawab" value="{{ old('penanggung_jawab') }}" 
                       class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 text-sm py-2.5 px-4 transition-all duration-200 shadow-sm" 
                       placeholder="Nama penanggung jawab" required>
                <p class="text-xs text-gray-500 mt-1">Masukkan nama penanggung jawab</p>
            </div>
            
            <!-- Keperluan -->
            <div class="space-y-1 md:col-span-2">
                <label class="block text-sm font-medium text-gray-700">
                    <span class="text-red-500">*</span> Keperluan
                </label>
                <textarea name="keperluan" rows="3" 
                          class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 text-sm py-2.5 px-4 transition-all duration-200 shadow-sm" 
                          placeholder="Tujuan peminjaman" required>{{ old('keperluan') }}</textarea>
                <p class="text-xs text-gray-500 mt-1">Jelaskan keperluan peminjaman</p>
            </div>
        </div>
        
        <div class="pt-4 flex justify-end space-x-3 border-t border-gray-100">
            <button type="button" onclick="toggleForm()" 
                    class="px-5 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all duration-200 shadow-sm">
                <i class="fas fa-times mr-2"></i> Batal
            </button>
            <button type="submit" id="submitButton"
                    class="px-5 py-2.5 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all duration-200 shadow-sm flex items-center">
                <i class="fas fa-paper-plane mr-2"></i> Simpan Peminjaman
            </button>
        </div>
    </form>
</div>

<script>
    // Fungsi untuk update info stok
    function updateStokInfo() {
        const select = document.getElementById('barangSelect');
        const stokInfo = document.getElementById('stokInfo');
        const stokValue = document.getElementById('stokValue');
        const selectedOption = select.options[select.selectedIndex];
        
        if (selectedOption.value) {
            const stok = selectedOption.getAttribute('data-stok');
            stokValue.textContent = stok;
            stokInfo.classList.remove('hidden');
            validateStok();
        } else {
            stokInfo.classList.add('hidden');
        }
    }
    
    // Fungsi validasi stok
    function validateStok() {
        const select = document.getElementById('barangSelect');
        const jumlahInput = document.getElementById('jumlahInput');
        const stokWarning = document.getElementById('stokWarning');
        const submitButton = document.getElementById('submitButton');
        
        const selectedOption = select.options[select.selectedIndex];
        
        if (selectedOption.value && jumlahInput.value) {
            const stok = parseInt(selectedOption.getAttribute('data-stok'));
            const jumlah = parseInt(jumlahInput.value);
            
            if (jumlah > stok) {
                stokWarning.classList.remove('hidden');
                submitButton.disabled = true;
                submitButton.classList.add('opacity-50', 'cursor-not-allowed');
            } else {
                stokWarning.classList.add('hidden');
                submitButton.disabled = false;
                submitButton.classList.remove('opacity-50', 'cursor-not-allowed');
            }
        } else {
            stokWarning.classList.add('hidden');
        }
    }
    
    // Validasi saat form akan disubmit
    document.querySelector('form').addEventListener('submit', function(e) {
        const select = document.getElementById('barangSelect');
        const jumlahInput = document.getElementById('jumlahInput');
        const selectedOption = select.options[select.selectedIndex];
        
        if (selectedOption.value && jumlahInput.value) {
            const stok = parseInt(selectedOption.getAttribute('data-stok'));
            const jumlah = parseInt(jumlahInput.value);
            
            if (jumlah > stok) {
                e.preventDefault();
                alert('Jumlah barang pinjam melebihi stok yang tersedia!');
            }
        }
    });
    
    // Datepicker default to today
    document.addEventListener('DOMContentLoaded', function() {
        if (!document.querySelector('input[name="tanggal_pinjam"]').value) {
            document.querySelector('input[name="tanggal_pinjam"]').valueAsDate = new Date();
        }
        
        // Inisialisasi stok info jika ada old input
        if (document.querySelector('select[name="barang_id"]').value) {
            updateStokInfo();
        }
    });
</script>
@endsection

@section('table')
<table class="min-w-full divide-y divide-gray-200">
    <thead class="bg-gray-50">
        <tr>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Barang</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Peminjam</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Pinjam</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
        </tr>
    </thead>
    <tbody class="bg-white divide-y divide-gray-200">
        @forelse($peminjaman as $item)
        <tr>
            <td class="px-6 py-4 whitespace-nowrap">
                <div class="text-sm font-medium text-gray-900">{{ $item->barang->nama }}</div>
                <div class="text-sm text-gray-500">{{ $item->barang->kategori }}</div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                {{ $item->peminjam }}
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                {{ $item->jumlah }}
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                {{ $item->tanggal_pinjam->format('d M Y') }}
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
                <span class="px-2 py-1 rounded-full text-xs 
                    @if($item->status == 'dikembalikan') bg-green-100 text-green-800
                    @elseif($item->status == 'terlambat') bg-red-100 text-red-800
                    @else bg-blue-100 text-blue-800 @endif">
                    {{ ucfirst($item->status) }}
                </span>
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                <div class="flex space-x-2">
                    @if($item->status == 'dipinjam')
                    <form action="{{ route('peminjaman.kembali', $item->id) }}" method="POST" onsubmit="return confirm('Apakah barang sudah dikembalikan?')">
                        @csrf
                        <button type="submit" class="text-green-500 hover:text-green-700" title="Kembalikan Barang">
                            <i class="fas fa-undo"></i>
                        </button>
                    </form>
                    @endif
                    <form action="{{ route('peminjaman.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-500 hover:text-red-700">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </div>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500">Tidak ada data peminjaman</td>
        </tr>
        @endforelse
    </tbody>
</table>

<div class="mt-4">
    {{ $peminjaman->links() }}
</div>
@endsection