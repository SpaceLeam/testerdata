@extends('layouts.app')

@section('title', 'Detail Kategori Instansi')

@section('content')
<div class="bg-dark-secondary rounded-lg shadow-lg">
    <div class="p-6 border-b border-dark-accent">
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-bold text-white">
                <i class="fas fa-eye mr-2 text-robot-blue"></i>Detail Kategori Instansi
            </h1>
            <div class="flex space-x-2">
                <a href="{{ route('kategori-instansi.edit', $kategoriInstansi->id_kin) }}" 
                   class="bg-yellow-600 hover:bg-yellow-700 text-white px-4 py-2 rounded-lg transition-colors">
                    <i class="fas fa-edit mr-2"></i>Edit
                </a>
                <a href="{{ route('kategori-instansi.index') }}" 
                   class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg transition-colors">
                    <i class="fas fa-arrow-left mr-2"></i>Kembali
                </a>
            </div>
        </div>
    </div>

    <div class="p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-dark-accent rounded-lg p-4">
                <h3 class="text-lg font-semibold text-white mb-4">
                    <i class="fas fa-info-circle mr-2 text-robot-blue"></i>Informasi Dasar
                </h3>
                <div class="space-y-3">
                    <div>
                        <label class="text-sm font-medium text-gray-300">ID Kategori</label>
                        <p class="text-white font-mono">#{{ $kategoriInstansi->id_kin }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-300">Nama Kategori</label>
                        <p class="text-white text-lg">{{ $kategoriInstansi->nama_kin }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-300">Status</label>
                        <span class="inline-block px-2 py-1 text-xs font-semibold rounded-full bg-robot-green/20 text-robot-green">
                            <i class="fas fa-check-circle mr-1"></i>Aktif
                        </span>
                    </div>
                </div>
            </div>

            <div class="bg-dark-accent rounded-lg p-4">
                <h3 class="text-lg font-semibold text-white mb-4">
                    <i class="fas fa-clock mr-2 text-robot-blue"></i>Waktu
                </h3>
                <div class="space-y-3">
                    <div>
                        <label class="text-sm font-medium text-gray-300">Dibuat</label>
                        <p class="text-white">
                            {{ \Carbon\Carbon::parse($kategoriInstansi->created_at)->format('d F Y, H:i') }}
                            <span class="text-gray-400 text-sm">
                                ({{ \Carbon\Carbon::parse($kategoriInstansi->created_at)->diffForHumans() }})
                            </span>
                        </p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-300">Diperbarui</label>
                        <p class="text-white">
                            {{ \Carbon\Carbon::parse($kategoriInstansi->updated_at)->format('d F Y, H:i') }}
                            <span class="text-gray-400 text-sm">
                                ({{ \Carbon\Carbon::parse($kategoriInstansi->updated_at)->diffForHumans() }})
                            </span>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-6 flex justify-end space-x-4">
            <form method="POST" action="{{ route('kategori-instansi.destroy', $kategoriInstansi->id_kin) }}" 
                  onsubmit="return confirm('Yakin ingin menghapus kategori ini?')">
                @csrf
                @method('DELETE')
                <button type="submit" 
                        class="bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded-lg transition-colors">
                    <i class="fas fa-trash mr-2"></i>Hapus
                </button>
            </form>
        </div>
    </div>
</div>
@endsection