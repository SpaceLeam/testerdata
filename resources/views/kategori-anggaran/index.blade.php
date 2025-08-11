@extends('layouts.app')

@section('title', 'Kategori Anggaran')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <h1 class="text-3xl font-bold text-white flex items-center">
            <i class="fas fa-list-alt text-robot-blue mr-3"></i>
            Kategori Anggaran
        </h1>
        <a href="{{ route('kategori-anggaran.create') }}" 
           class="bg-robot-blue hover:bg-robot-cyan text-white px-4 py-2 rounded-lg transition-colors flex items-center">
            <i class="fas fa-plus mr-2"></i>Tambah Kategori
        </a>
    </div>

    <!-- Search & Filter -->
    <div class="bg-dark-secondary p-4 rounded-lg border border-dark-accent">
        <form method="GET" action="{{ route('kategori-anggaran.index') }}" class="flex gap-4">
            <div class="flex-1">
                <input type="text" 
                       name="search" 
                       value="{{ request('search') }}"
                       placeholder="Cari kategori anggaran..."
                       class="w-full bg-dark-primary border border-dark-accent rounded-lg px-4 py-2 text-white placeholder-gray-400 focus:ring-2 focus:ring-robot-blue focus:border-transparent">
            </div>
            <button type="submit" class="bg-robot-blue hover:bg-robot-cyan text-white px-6 py-2 rounded-lg transition-colors">
                <i class="fas fa-search"></i>
            </button>
            @if(request('search'))
                <a href="{{ route('kategori-anggaran.index') }}" 
                   class="bg-gray-600 hover:bg-gray-500 text-white px-4 py-2 rounded-lg transition-colors">
                    <i class="fas fa-times"></i>
                </a>
            @endif
        </form>
    </div>

    <!-- Data Table -->
    <div class="bg-dark-secondary rounded-lg border border-dark-accent overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-dark-accent">
                <thead class="bg-dark-accent">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                            <i class="fas fa-hashtag mr-2"></i>ID
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                            <i class="fas fa-tag mr-2"></i>Nama Kategori
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                            <i class="fas fa-calendar mr-2"></i>Dibuat
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                            <i class="fas fa-cogs mr-2"></i>Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-dark-accent">
                    @forelse($kategoriAnggaran as $item)
                        <tr class="hover:bg-dark-accent/50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                                #{{ $item->id_kag }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-white">{{ $item->nama_kag }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                                {{ \Carbon\Carbon::parse($item->created_at)->format('d M Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm space-x-2">
                                <a href="{{ route('kategori-anggaran.show', $item->id_kag) }}" 
                                   class="text-robot-cyan hover:text-robot-blue transition-colors">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('kategori-anggaran.edit', $item->id_kag) }}" 
                                   class="text-robot-green hover:text-green-400 transition-colors">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form method="POST" action="{{ route('kategori-anggaran.destroy', $item->id_kag) }}" 
                                      class="inline-block" onsubmit="return confirm('Yakin ingin menghapus?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-400 hover:text-red-300 transition-colors">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center text-gray-400">
                                <i class="fas fa-inbox text-4xl mb-4"></i>
                                <p>Tidak ada data kategori anggaran</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    @if($kategoriAnggaran->hasPages())
        <div class="flex justify-center">
            {{ $kategoriAnggaran->links() }}
        </div>
    @endif
</div>
@endsection