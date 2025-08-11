@extends('layouts.app')

@section('title', 'Kategori Instansi')

@section('content')
<div class="bg-dark-secondary rounded-lg shadow-lg">
    <div class="p-6 border-b border-dark-accent">
        <div class="flex justify-between items-center">
            <h1 class="text-2xl font-bold text-white">
                <i class="fas fa-building mr-2 text-robot-blue"></i>Kategori Instansi
            </h1>
            <a href="{{ route('kategori-instansi.create') }}" 
               class="bg-robot-blue hover:bg-robot-cyan text-white px-4 py-2 rounded-lg transition-colors">
                <i class="fas fa-plus mr-2"></i>Tambah Kategori
            </a>
        </div>
    </div>

    <div class="p-6">
        <!-- Search Form -->
        <form method="GET" class="mb-6">
            <div class="flex gap-4">
                <input type="text" 
                       name="search" 
                       value="{{ request('search') }}"
                       placeholder="Cari kategori instansi..."
                       class="flex-1 bg-dark-accent border border-gray-600 text-white px-4 py-2 rounded-lg focus:outline-none focus:border-robot-blue">
                <button type="submit" class="bg-robot-green hover:bg-green-600 text-white px-6 py-2 rounded-lg transition-colors">
                    <i class="fas fa-search mr-2"></i>Cari
                </button>
            </div>
        </form>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-dark-accent">
                    <tr>
                        <th class="px-4 py-3 text-left text-gray-300">ID</th>
                        <th class="px-4 py-3 text-left text-gray-300">Nama Kategori</th>
                        <th class="px-4 py-3 text-left text-gray-300">Dibuat</th>
                        <th class="px-4 py-3 text-left text-gray-300">Diperbarui</th>
                        <th class="px-4 py-3 text-center text-gray-300">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($kategoriInstansi as $item)
                    <tr class="border-b border-dark-accent hover:bg-dark-accent/30 transition-colors">
                        <td class="px-4 py-3 text-gray-300">#{{ $item->id_kin }}</td>
                        <td class="px-4 py-3 text-white font-medium">{{ $item->nama_kin }}</td>
                        <td class="px-4 py-3 text-gray-400">{{ \Carbon\Carbon::parse($item->created_at)->format('d/m/Y H:i') }}</td>
                        <td class="px-4 py-3 text-gray-400">{{ \Carbon\Carbon::parse($item->updated_at)->format('d/m/Y H:i') }}</td>
                        <td class="px-4 py-3 text-center">
                            <div class="flex justify-center space-x-2">
                                <a href="{{ route('kategori-instansi.show', $item->id_kin) }}" 
                                   class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded transition-colors">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('kategori-instansi.edit', $item->id_kin) }}" 
                                   class="bg-yellow-600 hover:bg-yellow-700 text-white px-3 py-1 rounded transition-colors">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form method="POST" action="{{ route('kategori-instansi.destroy', $item->id_kin) }}" 
                                      class="inline" onsubmit="return confirm('Yakin ingin menghapus?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded transition-colors">
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
                            <p>Tidak ada data kategori instansi</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $kategoriInstansi->links('pagination::tailwind') }}
        </div>
    </div>
</div>
@endsection