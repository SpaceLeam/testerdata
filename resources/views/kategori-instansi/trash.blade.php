@extends('layouts.app')

@section('title', 'Sampah Kategori Instansi')

@section('content')
<div class="bg-dark-secondary rounded-lg shadow-lg">
    <div class="p-6 border-b border-dark-accent">
        <div class="flex justify-between items-center">
            <h1 class="text-2xl font-bold text-white">
                <i class="fas fa-trash mr-2 text-red-400"></i>Sampah Kategori Instansi
            </h1>
            <a href="{{ route('kategori-instansi.index') }}" 
               class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg transition-colors">
                <i class="fas fa-arrow-left mr-2"></i>Kembali
            </a>
        </div>
    </div>

    <div class="p-6">
        @if($kategoriInstansi->count() > 0)
            <div class="mb-4 bg-yellow-500/20 border border-yellow-500/50 text-yellow-400 px-4 py-3 rounded-lg">
                <i class="fas fa-info-circle mr-2"></i>
                Data di sampah dapat dipulihkan atau dihapus permanen
            </div>
        @endif

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-dark-accent">
                    <tr>
                        <th class="px-4 py-3 text-left text-gray-300">ID</th>
                        <th class="px-4 py-3 text-left text-gray-300">Nama Kategori</th>
                        <th class="px-4 py-3 text-left text-gray-300">Dihapus</th>
                        <th class="px-4 py-3 text-center text-gray-300">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($kategoriInstansi as $item)
                    <tr class="border-b border-dark-accent hover:bg-dark-accent/30 transition-colors">
                        <td class="px-4 py-3 text-gray-300">#{{ $item->id_kin }}</td>
                        <td class="px-4 py-3 text-gray-400">{{ $item->nama_kin }}</td>
                        <td class="px-4 py-3 text-gray-400">{{ \Carbon\Carbon::parse($item->updated_at)->format('d/m/Y H:i') }}</td>
                        <td class="px-4 py-3 text-center">
                            <div class="flex justify-center space-x-2">
                                <form method="POST" action="{{ route('kategori-instansi.restore', $item->id_kin) }}" 
                                      class="inline">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" 
                                            class="bg-robot-green hover:bg-green-600 text-white px-3 py-1 rounded transition-colors"
                                            onclick="return confirm('Yakin ingin memulihkan data ini?')">
                                        <i class="fas fa-undo"></i>
                                    </button>
                                </form>
                                <form method="POST" action="{{ route('kategori-instansi.force-delete', $item->id_kin) }}" 
                                      class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded transition-colors"
                                            onclick="return confirm('Yakin ingin menghapus permanen? Data tidak dapat dipulihkan!')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-4 py-8 text-center text-gray-400">
                            <i class="fas fa-inbox text-4xl mb-4"></i>
                            <p>Tidak ada data di sampah</p>
                            <p class="text-sm">Data yang dihapus akan muncul di sini</p>
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