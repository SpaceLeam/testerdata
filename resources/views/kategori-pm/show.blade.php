@extends('layouts.app')

@section('title', 'Detail Kategori PM')

@section('content')
<div class="bg-dark-secondary rounded-lg shadow-lg p-6">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-white mb-2">
            <i class="fas fa-eye mr-2 text-robot-blue"></i>Detail Kategori PM
        </h1>
        <nav class="text-sm text-gray-400">
            <a href="{{ route('kategori-pm.index') }}" class="hover:text-robot-cyan transition-colors">Kategori PM</a>
            <span class="mx-2">/</span>
            <span>Detail</span>
        </nav>
    </div>

    <div class="space-y-6">
        <!-- Detail Information -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-white mb-2">ID Kategori</label>
                <div class="px-4 py-2 bg-dark-accent border border-gray-600 rounded-lg text-white">
                    {{ $kategoriPm->id_kpm }}
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium text-white mb-2">Status</label>
                <div class="px-4 py-2 bg-dark-accent border border-gray-600 rounded-lg">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-robot-green/20 text-robot-green">
                        <i class="fas fa-check-circle mr-1"></i>Aktif
                    </span>
                </div>
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-white mb-2">Nama Kategori PM</label>
            <div class="px-4 py-2 bg-dark-accent border border-gray-600 rounded-lg text-white text-lg font-medium">
                {{ $kategoriPm->nama_kpm }}
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-white mb-2">Dibuat</label>
                <div class="px-4 py-2 bg-dark-accent border border-gray-600 rounded-lg text-white">
                    <i class="fas fa-calendar-plus mr-2 text-robot-blue"></i>
                    {{ \Carbon\Carbon::parse($kategoriPm->created_at)->format('d/m/Y H:i') }}
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium text-white mb-2">Terakhir Diperbarui</label>
                <div class="px-4 py-2 bg-dark-accent border border-gray-600 rounded-lg text-white">
                    <i class="fas fa-calendar-edit mr-2 text-robot-cyan"></i>
                    {{ \Carbon\Carbon::parse($kategoriPm->updated_at)->format('d/m/Y H:i') }}
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex space-x-4 pt-4 border-t border-dark-accent">
            <a href="{{ route('kategori-pm.edit', $kategoriPm->id_kpm) }}" 
               class="bg-yellow-600 hover:bg-yellow-700 text-white px-6 py-2 rounded-lg transition-colors">
                <i class="fas fa-edit mr-2"></i>Edit
            </a>
            <form method="POST" action="{{ route('kategori-pm.destroy', $kategoriPm->id_kpm) }}" 
                  onsubmit="return confirm('Yakin ingin menghapus kategori ini?')" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded-lg transition-colors">
                    <i class="fas fa-trash mr-2"></i>Hapus
                </button>
            </form>
            <a href="{{ route('kategori-pm.index') }}" 
               class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-2 rounded-lg transition-colors">
                <i class="fas fa-arrow-left mr-2"></i>Kembali
            </a>
        </div>
    </div>
</div>
@endsection