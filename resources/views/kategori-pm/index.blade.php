@extends('layouts.app')

@section('title', 'Kategori PM')

@section('content')
<div class="bg-dark-secondary rounded-lg shadow-lg p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-white">
            <i class="fas fa-list mr-2 text-robot-blue"></i>Kategori PM
        </h1>
        <a href="{{ route('kategori-pm.create') }}" class="bg-robot-blue hover:bg-robot-cyan text-white px-4 py-2 rounded-lg transition-colors">
            <i class="fas fa-plus mr-2"></i>Tambah Kategori
        </a>
    </div>

    <!-- Search Form -->
    <div class="mb-6">
        <form method="GET" action="{{ route('kategori-pm.index') }}" class="flex gap-4">
            <div class="flex-1">
                <input type="text" name="search" value="{{ request('search') }}" 
                       placeholder="Cari kategori PM..." 
                       class="w-full px-4 py-2 bg-dark-accent border border-gray-600 rounded-lg text-white focus:outline-none focus:border-robot-blue">
            </div>
            <button type="submit" class="bg-robot-green hover:bg-green-600 text-white px-6 py-2 rounded-lg transition-colors">
                <i class="fas fa-search"></i>
            </button>
            @if(request('search'))
                <a href="{{ route('kategori-pm.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-2 rounded-lg transition-colors">
                    <i class="fas fa-times"></i>
                </a>
            @endif
        </form>
    </div>

    <!-- Table -->
    <div class="overflow-x-auto">
        <table class="w-full table-auto">
            <thead>
                <tr class="bg-dark-accent">
                    <th class="px-4 py-3 text-left text-white">#</th>
                    <th class="px-4 py-3 text-left text-white">Nama Kategori</th>
                    <th class="px-4 py-3 text-left text-white">Dibuat</th>
                    <th class="px-4 py-3 text-left text-white">Diperbarui</th>
                    <th class="px-4 py-3 text-center text-white">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($kategoriPm as $item)
                    <tr class="border-b border-dark-accent hover:bg-dark-accent/50 transition-colors">
                        <td class="px-4 py-3 text-gray-300">{{ $item->id_kpm }}</td>
                        <td class="px-4 py-3 text-white font-medium">{{ $item->nama_kpm }}</td>
                        <td class="px-4 py-3 text-gray-300">{{ \Carbon\Carbon::parse($item->created_at)->format('d/m/Y H:i') }}</td>
                        <td class="px-4 py-3 text-gray-300">{{ \Carbon\Carbon::parse($item->updated_at)->format('d/m/Y H:i') }}</td>
                        <td class="px-4 py-3 text-center">
                            <div class="flex justify-center space-x-2">
                                <a href="{{ route('kategori-pm.show', $item->id_kpm) }}" 
                                   class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded text-sm transition-colors">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('kategori-pm.edit', $item->id_kpm) }}" 
                                   class="bg-yellow-600 hover:bg-yellow-700 text-white px-3 py-1 rounded text-sm transition-colors">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form method="POST" action="{{ route('kategori-pm.destroy', $item->id_kpm) }}" 
                                      onsubmit="return confirm('Yakin ingin menghapus kategori ini?')" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-sm transition-colors">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-4 py-8 text-center text-gray-400">
                            <i class="fas fa-inbox text-4xl mb-4"></i>
                            <p>Tidak ada data kategori PM</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if($kategoriPm->hasPages())
        <div class="mt-6 flex justify-center">
            {{ $kategoriPm->links() }}
        </div>
    @endif
</div>
@endsection