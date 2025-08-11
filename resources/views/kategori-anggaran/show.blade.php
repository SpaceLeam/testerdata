@extends('layouts.app')

@section('title', 'Detail Kategori Anggaran')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Header -->
    <div class="mb-6 flex justify-between items-center">
        <h1 class="text-3xl font-bold text-white flex items-center">
            <i class="fas fa-eye text-robot-blue mr-3"></i>
            Detail Kategori Anggaran
        </h1>
        <div class="flex gap-3">
            <a href="{{ route('kategori-anggaran.edit', $kategoriAnggaran->id_kag) }}" 
               class="bg-robot-green hover:bg-green-400 text-white px-4 py-2 rounded-lg transition-colors">
                <i class="fas fa-edit mr-2"></i>Edit
            </a>
            <a href="{{ route('kategori-anggaran.index') }}" 
               class="bg-gray-600 hover:bg-gray-500 text-white px-4 py-2 rounded-lg transition-colors">
                <i class="fas fa-arrow-left mr-2"></i>Kembali
            </a>
        </div>
    </div>

    <!-- Detail Card -->
    <div class="bg-dark-secondary rounded-lg border border-dark-accent overflow-hidden">
        <div class="bg-dark-accent px-6 py-4">
            <h2 class="text-xl font-semibold text-white flex items-center">
                <i class="fas fa-info-circle text-robot-blue mr-3"></i>
                Informasi Kategori
            </h2>
        </div>
        
        <div class="p-6 space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">
                        <i class="fas fa-hashtag mr-2"></i>ID Kategori
                    </label>
                    <div class="bg-dark-primary border border-dark-accent rounded-lg px-4 py-3">
                        <span class="text-white font-mono">#{{ $kategoriAnggaran->id_kag }}</span>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">
                        <i class="fas fa-toggle-on mr-2"></i>Status
                    </label>
                    <div class="bg-dark-primary border border-dark-accent rounded-lg px-4 py-3">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-robot-green/20 text-robot-green">
                            <i class="fas fa-check-circle mr-1"></i>Aktif
                        </span>
                    </div>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-300 mb-2">
                    <i class="fas fa-tag mr-2"></i>Nama Kategori
                </label>
                <div class="bg-dark-primary border border-dark-accent rounded-lg px-4 py-3">
                    <span class="text-white text-lg font-medium">{{ $kategoriAnggaran->nama_kag }}</span>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">
                        <i class="fas fa-calendar-plus mr-2"></i>Dibuat Pada
                    </label>
                    <div class="bg-dark-primary border border-dark-accent rounded-lg px-4 py-3">
                        <span class="text-white">
                            {{ \Carbon\Carbon::parse($kategoriAnggaran->created_at)->format('d F Y, H:i') }} WIB
                        </span>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">
                        <i class="fas fa-calendar-edit mr-2"></i>Terakhir Diubah
                    </label>
                    <div class="bg-dark-primary border border-dark-accent rounded-lg px-4 py-3">
                        <span class="text-white">
                            {{ \Carbon\Carbon::parse($kategoriAnggaran->updated_at)->format('d F Y, H:i') }} WIB
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Action Card -->
    <div class="mt-6 bg-dark-secondary rounded-lg border border-dark-accent p-6">
        <h3 class="text-lg font-semibold text-white mb-4 flex items-center">
            <i class="fas fa-cogs text-robot-blue mr-3"></i>
            Aksi Tersedia
        </h3>
        <div class="flex flex-wrap gap-4">
            <a href="{{ route('kategori-anggaran.edit', $kategoriAnggaran->id_kag) }}" 
               class="bg-robot-green hover:bg-green-400 text-white px-4 py-2 rounded-lg transition-colors flex items-center">
                <i class="fas fa-edit mr-2"></i>Edit Kategori
            </a>
            <form method="POST" action="{{ route('kategori-anggaran.destroy', $kategoriAnggaran->id_kag) }}" 
                  class="inline-block" onsubmit="return confirm('Yakin ingin menghapus kategori ini?')">
                @csrf
                @method('DELETE')
                <button type="submit" 
                        class="bg-red-500 hover:bg-red-400 text-white px-4 py-2 rounded-lg transition-colors flex items-center">
                    <i class="fas fa-trash mr-2"></i>Hapus Kategori
                </button>
            </form>
        </div>
    </div>
</div>
@endsection