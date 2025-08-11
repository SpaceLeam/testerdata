@extends('layouts.app')

@section('title', 'Tambah Kategori Anggaran')

@section('content')
<div class="max-w-2xl mx-auto">
    <!-- Header -->
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-white flex items-center">
            <i class="fas fa-plus-circle text-robot-blue mr-3"></i>
            Tambah Kategori Anggaran
        </h1>
        <p class="text-gray-400 mt-2">Buat kategori anggaran baru untuk sistem</p>
    </div>

    <!-- Form Card -->
    <div class="bg-dark-secondary rounded-lg border border-dark-accent p-6">
       <form method="POST" action="{{ route('kategori-anggaran.store') }}" class="space-y-6">
    @csrf

    <!-- ID Kategori -->
    <div>
        <label for="id_kag" class="block text-sm font-medium text-gray-300 mb-2">
            <i class="fas fa-key mr-2"></i>ID Kategori
        </label>
        <input type="number" 
               id="id_kag" 
               name="id_kag" 
               value="{{ old('id_kag') }}"
               class="w-full bg-dark-primary border border-dark-accent rounded-lg px-4 py-3 text-white placeholder-gray-400 focus:ring-2 focus:ring-robot-blue focus:border-transparent @error('id_kag') border-red-500 @enderror" 
               placeholder="Masukkan ID kategori (misal: 101)">
        @error('id_kag')
            <p class="mt-2 text-sm text-red-400">
                <i class="fas fa-exclamation-triangle mr-1"></i>{{ $message }}
            </p>
        @enderror
    </div>

    <!-- Nama Kategori -->
    <div>
        <label for="nama_kag" class="block text-sm font-medium text-gray-300 mb-2">
            <i class="fas fa-tag mr-2"></i>Nama Kategori
        </label>
        <input type="text" 
               id="nama_kag" 
               name="nama_kag" 
               value="{{ old('nama_kag') }}"
               class="w-full bg-dark-primary border border-dark-accent rounded-lg px-4 py-3 text-white placeholder-gray-400 focus:ring-2 focus:ring-robot-blue focus:border-transparent @error('nama_kag') border-red-500 @enderror" 
               placeholder="Masukkan nama kategori anggaran"
               required>
        @error('nama_kag')
            <p class="mt-2 text-sm text-red-400">
                <i class="fas fa-exclamation-triangle mr-1"></i>{{ $message }}
            </p>
        @enderror
    </div>

            <div class="flex gap-4 pt-4">
                <button type="submit" 
                        class="flex-1 bg-robot-blue hover:bg-robot-cyan text-white py-3 px-4 rounded-lg transition-colors font-medium">
                    <i class="fas fa-save mr-2"></i>Simpan Kategori
                </button>
                <a href="{{ route('kategori-anggaran.index') }}" 
                   class="flex-1 bg-gray-600 hover:bg-gray-500 text-white py-3 px-4 rounded-lg transition-colors font-medium text-center">
                    <i class="fas fa-times mr-2"></i>Batal
                </a>
            </div>
        </form>
    </div>

    <!-- Info Card -->
    <div class="mt-6 bg-robot-blue/10 border border-robot-blue/30 rounded-lg p-4">
        <div class="flex items-start">
            <i class="fas fa-info-circle text-robot-blue text-xl mr-3 mt-1"></i>
            <div>
                <h3 class="text-robot-blue font-medium mb-2">Informasi</h3>
                <ul class="text-sm text-gray-300 space-y-1">
                    <li>• Nama kategori maksimal 100 karakter</li>
                    <li>• Kategori akan otomatis aktif setelah dibuat</li>
                    <li>• Pastikan nama kategori unik dan mudah dimengerti</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection