@extends('layouts.app')

@section('title', 'Edit Kategori Instansi')

@section('content')
<div class="bg-dark-secondary rounded-lg shadow-lg">
    <div class="p-6 border-b border-dark-accent">
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-bold text-white">
                <i class="fas fa-edit mr-2 text-robot-blue"></i>Edit Kategori Instansi
            </h1>
            <a href="{{ route('kategori-instansi.index') }}" 
               class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg transition-colors">
                <i class="fas fa-arrow-left mr-2"></i>Kembali
            </a>
        </div>
    </div>

    <div class="p-6">
        <form method="POST" action="{{ route('kategori-instansi.update', $kategoriInstansi->id_kin) }}" class="space-y-6">
            @csrf
            @method('PUT')
            
            <div>
                <label for="id_kin" class="block text-sm font-medium text-gray-300 mb-2">
                    ID Kategori
                </label>
                <input type="text" 
                       name="id_kin" 
                       id="id_kin"
                       value="{{ $kategoriInstansi->id_kin }}"
                       class="w-full bg-dark-accent border border-gray-600 text-gray-400 px-4 py-2 rounded-lg cursor-not-allowed"
                       readonly>
                <p class="mt-1 text-sm text-gray-400">ID kategori tidak dapat diubah</p>
            </div>

            <div>
                <label for="nama_kin" class="block text-sm font-medium text-gray-300 mb-2">
                    Nama Kategori <span class="text-red-400">*</span>
                </label>
                <input type="text" 
                       name="nama_kin" 
                       id="nama_kin"
                       value="{{ old('nama_kin', $kategoriInstansi->nama_kin) }}"
                       class="w-full bg-dark-accent border border-gray-600 text-white px-4 py-2 rounded-lg focus:outline-none focus:border-robot-blue @error('nama_kin') border-red-500 @enderror"
                       placeholder="Masukkan nama kategori"
                       maxlength="100"
                       required>
                @error('nama_kin')
                    <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div class="bg-dark-accent rounded-lg p-4">
                <h3 class="text-sm font-medium text-gray-300 mb-2">Informasi Waktu</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                    <div>
                        <label class="text-gray-400">Dibuat</label>
                        <p class="text-white">{{ \Carbon\Carbon::parse($kategoriInstansi->created_at)->format('d F Y, H:i') }}</p>
                    </div>
                    <div>
                        <label class="text-gray-400">Diperbarui</label>
                        <p class="text-white">{{ \Carbon\Carbon::parse($kategoriInstansi->updated_at)->format('d F Y, H:i') }}</p>
                    </div>
                </div>
            </div>

            <div class="flex justify-end space-x-4">
                <a href="{{ route('kategori-instansi.index') }}" 
                   class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-2 rounded-lg transition-colors">
                    <i class="fas fa-times mr-2"></i>Batal
                </a>
                <button type="submit" 
                        class="bg-robot-blue hover:bg-robot-cyan text-white px-6 py-2 rounded-lg transition-colors">
                    <i class="fas fa-save mr-2"></i>Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection