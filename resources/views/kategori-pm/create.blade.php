@extends('layouts.app')

@section('title', 'Tambah Kategori PM')

@section('content')
<div class="bg-dark-secondary rounded-lg shadow-lg p-6">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-white mb-2">
            <i class="fas fa-plus mr-2 text-robot-blue"></i>Tambah Kategori PM
        </h1>
        <nav class="text-sm text-gray-400">
            <a href="{{ route('kategori-pm.index') }}" class="hover:text-robot-cyan transition-colors">Kategori PM</a>
            <span class="mx-2">/</span>
            <span>Tambah</span>
        </nav>
    </div>

    <form method="POST" action="{{ route('kategori-pm.store') }}">
        @csrf
        <!-- ID Kategori -->
<div>
    <label for="id_kpm" class="block text-sm font-medium text-white mb-2">
        ID Kategori PM <span class="text-red-400">*</span>
    </label>
    <input type="text" 
           id="id_kpm" 
           name="id_kpm" 
           value="{{ old('id_kpm') }}"
           class="w-full px-4 py-2 bg-dark-accent border border-gray-600 rounded-lg text-white focus:outline-none focus:border-robot-blue @error('id_kpm') border-red-500 @enderror"
           placeholder="hanya bisa numerik">
    @error('id_kpm')
        <p class="mt-2 text-sm text-red-400">
            <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
        </p>
    @enderror
</div>

        <div class="space-y-6">
            <!-- Nama Kategori -->
            <div>
                <label for="nama_kpm" class="block text-sm font-medium text-white mb-2">
                    Nama Kategori PM <span class="text-red-400">*</span>
                </label>
                <input type="text" 
                       id="nama_kpm" 
                       name="nama_kpm" 
                       value="{{ old('nama_kpm') }}"
                       class="w-full px-4 py-2 bg-dark-accent border border-gray-600 rounded-lg text-white focus:outline-none focus:border-robot-blue @error('nama_kpm') border-red-500 @enderror"
                       placeholder="Masukkan nama kategori PM">
                @error('nama_kpm')
                    <p class="mt-2 text-sm text-red-400">
                        <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                    </p>
                @enderror
            </div>

            <!-- Buttons -->
            <div class="flex space-x-4">
                <button type="submit" class="bg-robot-blue hover:bg-robot-cyan text-white px-6 py-2 rounded-lg transition-colors">
                    <i class="fas fa-save mr-2"></i>Simpan
                </button>
                <a href="{{ route('kategori-pm.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-2 rounded-lg transition-colors">
                    <i class="fas fa-arrow-left mr-2"></i>Kembali
                </a>
            </div>
        </div>
    </form>
</div>
@endsection