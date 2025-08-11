@extends('layouts.app')

@section('title', 'Edit Kategori Anggaran')

@section('content')
<div class="max-w-2xl mx-auto">
    <!-- Header -->
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-white flex items-center">
            <i class="fas fa-edit text-robot-blue mr-3"></i>
            Edit Kategori Anggaran
        </h1>
        <p class="text-gray-400 mt-2">Perbarui informasi kategori anggaran</p>
    </div>

    <!-- Form Card -->
    <div class="bg-dark-secondary rounded-lg border border-dark-accent p-6">
        <form method="POST" action="{{ route('kategori-anggaran.update', $kategoriAnggaran->id_kag) }}" class="space-y-6">
            @csrf
            @method('PUT')
            
            <!-- ID Display -->
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-2">
                    <i class="fas fa-hashtag mr-2"></i>ID Kategori
                </label>
                <div class="bg-dark-primary border border-dark-accent rounded-lg px-4 py-3">
                    <span class="text-gray-400 font-mono">#{{ $kategoriAnggaran->id_kag }}</span>
                </div>
            </div>

            <!-- Nama Kategori -->
            <div>
                <label for="nama_kag" class="block text-sm font-medium text-gray-300 mb-2">
                    <i class="fas fa-tag mr-2"></i>Nama Kategori
                </label>
                <input type="text" 
                       id="nama_kag" 
                       name="nama_kag" 
                       value="{{ old('nama_kag', $kategoriAnggaran->nama_kag) }}"
                       class="w-full bg-dark-primary border border-dark-accent rounded-lg px-4 py-3 text-white placeholder-gray-400 focus:ring-2 focus:ring-robot-blue focus:border-transparent @error('nama_kag') border-red-500 @enderror" 
                       placeholder="Masukkan nama kategori anggaran"
                       required>
                @error('nama_kag')
                    <p class="mt-2 text-sm text-red-400">
                        <i class="fas fa-exclamation-triangle mr-1"></i>{{ $message }}
                    </p>
                @enderror
            </div>

            <!-- Metadata -->
            <div class="bg-dark-primary rounded-lg p-4 border border-dark-accent">
                <h3 class="text-sm font-medium text-gray-300 mb-3 flex items-center">
                    <i class="fas fa-info-circle mr-2"></i>Informasi Tambahan
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                    <div>
                        <span class="text-gray-400">Dibuat:</span>
                        <span class="text-white ml-2">{{ \Carbon\Carbon::parse($kategoriAnggaran->created_at)->format('d M Y, H:i') }}</span>
                    </div>
                    <div>
                        <span class="text-gray-400">Terakhir diubah:</span>
                        <span class="text-white ml-2">{{ \Carbon\Carbon::parse($kategoriAnggaran->updated_at)->format('d M Y, H:i') }}</span>
                    </div>
                </div>
            </div>

            <!-- Buttons -->
            <div class="flex gap-4 pt-4">
                <button type="submit" 
                        class="flex-1 bg-robot-blue hover:bg-robot-cyan text-white py-3 px-4 rounded-lg transition-colors font-medium">
                    <i class="fas fa-save mr-2"></i>Simpan Perubahan
                </button>
                <a href="{{ route('kategori-anggaran.show', $kategoriAnggaran->id_kag) }}" 
                   class="flex-1 bg-gray-600 hover:bg-gray-500 text-white py-3 px-4 rounded-lg transition-colors font-medium text-center">
                    <i class="fas fa-times mr-2"></i>Batal
                </a>
            </div>
        </form>
    </div>

    <!-- Quick Actions -->
    <div class="mt-6 bg-dark-secondary rounded-lg border border-dark-accent p-4">
        <h3 class="text-sm font-medium text-gray-300 mb-3 flex items-center">
            <i class="fas fa-bolt mr-2"></i>Aksi Cepat
        </h3>
        <div class="flex flex-wrap gap-2">
            <a href="{{ route('kategori-anggaran.show', $kategoriAnggaran->id_kag) }}" 
               class="text-robot-cyan hover:text-robot-blue transition-colors text-sm">
                <i class="fas fa-eye mr-1"></i>Lihat Detail
            </a>
            <a href="{{ route('kategori-anggaran.index') }}" 
               class="text-gray-400 hover:text-gray-300 transition-colors text-sm">
                <i class="fas fa-list mr-1"></i>Daftar Kategori
            </a>
        </div>
    </div>
</div>
@endsection