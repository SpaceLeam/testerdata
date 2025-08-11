@extends('layouts.app')

@section('title', 'Sampah Kategori PM')

@section('content')
<div class="bg-dark-secondary rounded-lg shadow-lg p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-white">
            <i class="fas fa-trash mr-2 text-red-400"></i>Sampah Kategori PM
        </h1>
        <a href="{{ route('kategori-pm.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg transition-colors">
            <i class="fas fa-arrow-left mr-2"></i>Kembali ke Daftar
        </a>
    </div>

    <!-- Info -->
    <div class="mb-6 bg-yellow-600/20 border border-yellow-500/50 text-yellow-300 px-4 py-3 rounded-lg">
        <i class="fas fa-info-circle mr-2"></i>
        Data yang dihapus akan tersimpan di sini. Anda dapat memulihkan atau menghapus permanen.
    </div>

    <!-- Table -->
    <div class="overflow-x-auto">
        <table class="w-full table-auto">
            <thead>
                <tr class="bg-dark-accent">
                    <th class="px-4 py-3 text-left text-white">#</th>
                    <th class="px-4 py-3 text-left text-white">Nama Kategori</th>
                    <th class="px-4 py-3 text-left text-white">Dihapus</th>
                    <th class="px-4 py-3 text-center text-white">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($kategoriPm as $item)
                    <tr class="border-b border-dark-accent hover:bg-dark-accent/50 transition-colors">
                        <td class="px-4 py-3 text-gray-300">{{ $item->id_kpm }}</td>
                        <td class="px-4 py-3 text-white font-medium">
                            <span class="line-through text-gray-400">{{ $item->nama_kpm }}</span>
                        </td>
                        <td class="px-4 py-3 text-gray-300">
                            {{ \Carbon\Carbon::parse($item->updated_at)->format('d/m/Y H:i') }}
                        </td>
                        <td class="px-4 py-3 text-center">
                            <div class="flex justify-center space-x-2">
                                <form method="POST" action="{{ route('kategori-pm.restore', $item->id_kpm) }}" class="inline">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" 
                                            class="bg-robot-green hover:bg-green-600 text-white px-3 py-1 rounded text-sm transition-colors"
                                            onclick="return confirm('Yakin ingin memulihkan kategori ini?')">
                                        <i class="fas fa-undo"></i>
                                    </button>
                                </form>
                                <form method="POST" action="{{ route('kategori-pm.force-delete', $item->id_kpm) }}" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-sm transition-colors"
                                            onclick="return confirm('PERINGATAN: Data akan dihapus permanen dan tidak dapat dipulihkan. Yakin melanjutkan?')">
                                        <i class="fas fa-trash-alt"></i>
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