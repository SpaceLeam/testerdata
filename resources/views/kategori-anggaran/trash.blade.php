@extends('layouts.app')

@section('title', 'Trash Kategori Anggaran')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <h1 class="text-3xl font-bold text-white flex items-center">
            <i class="fas fa-trash text-red-400 mr-3"></i>
            Trash Kategori Anggaran
        </h1>
        <a href="{{ route('kategori-anggaran.index') }}" 
           class="bg-robot-blue hover:bg-robot-cyan text-white px-4 py-2 rounded-lg transition-colors flex items-center">
            <i class="fas fa-arrow-left mr-2"></i>Kembali ke Daftar
        </a>
    </div>

    <!-- Info Alert -->
    <div class="bg-red-500/10 border border-red-500/30 rounded-lg p-4">
        <div class="flex items-start">
            <i class="fas fa-exclamation-triangle text-red-400 text-xl mr-3 mt-1"></i>
            <div>
                <h3 class="text-red-400 font-medium mb-2">Perhatian</h3>
                <p class="text-sm text-gray-300">
                    Data di halaman ini adalah kategori yang telah dihapus. Anda dapat memulihkan atau menghapus permanen.
                </p>
            </div>
        </div>
    </div>

    <!-- Data Table -->
    <div class="bg-dark-secondary rounded-lg border border-dark-accent overflow-hidden">
        <div class="bg-dark-accent px-6 py-4">
            <h2 class="text-lg font-semibold text-white flex items-center">
                <i class="fas fa-recycle text-orange-400 mr-3"></i>
                Data Terhapus
            </h2>
        </div>
        
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-dark-accent">
                <thead class="bg-dark-accent">
                    <tr>
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
                                <div class="text-sm font-medium text-gray-300 line-through">{{ $item->nama_kag }}</div>
                                <div class="text-xs text-red-400">
                                    <i class="fas fa-trash mr-1"></i>Dihapus
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                                {{ \Carbon\Carbon::parse($item->updated_at)->format('d M Y, H:i') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm space-x-2">
                                <form method="POST" action="{{ route('kategori-anggaran.restore', $item->id_kag) }}" 
                                      class="inline-block" onsubmit="return confirm('Yakin ingin memulihkan kategori ini?')">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" 
                                            class="text-robot-green hover:text-green-400 transition-colors" 
                                            title="Pulihkan">
                                        <i class="fas fa-undo"></i>
                                    </button>
                                </form>
                                <form method="POST" action="{{ route('kategori-anggaran.force-delete', $item->id_kag) }}" 
                                      class="inline-block" onsubmit="return confirm('PERINGATAN: Data akan dihapus permanen dan tidak dapat dipulihkan. Yakin ingin melanjutkan?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="text-red-400 hover:text-red-300 transition-colors" 
                                            title="Hapus Permanen">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center text-gray-400">
                                <i class="fas fa-smile text-4xl mb-4"></i>
                                <p>Tidak ada data di trash</p>
                                <p class="text-sm mt-2">Semua kategori anggaran masih aktif</p>
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

    <!-- Bulk Actions -->
    @if($kategoriAnggaran->count() > 0)
        <div class="bg-dark-secondary rounded-lg border border-dark-accent p-4">
            <h3 class="text-sm font-medium text-gray-300 mb-3 flex items-center">
                <i class="fas fa-tools mr-2"></i>Aksi Massal
            </h3>
            <div class="flex flex-wrap gap-2">
                <button onclick="confirmBulkRestore()" 
                        class="bg-robot-green hover:bg-green-400 text-white px-4 py-2 rounded-lg transition-colors text-sm">
                    <i class="fas fa-undo mr-2"></i>Pulihkan Semua
                </button>
                <button onclick="confirmBulkDelete()" 
                        class="bg-red-500 hover:bg-red-400 text-white px-4 py-2 rounded-lg transition-colors text-sm">
                    <i class="fas fa-trash-alt mr-2"></i>Hapus Permanen Semua
                </button>
            </div>
        </div>
    @endif
</div>

<script>
function confirmBulkRestore() {
    if (confirm('Yakin ingin memulihkan semua kategori di trash?')) {
        // Implementasi bulk restore
        alert('Fitur ini akan diimplementasikan sesuai kebutuhan');
    }
}

function confirmBulkDelete() {
    if (confirm('PERINGATAN: Semua data di trash akan dihapus permanen dan tidak dapat dipulihkan. Yakin ingin melanjutkan?')) {
        // Implementasi bulk delete
        alert('Fitur ini akan diimplementasikan sesuai kebutuhan');
    }
}
</script>
@endsection<i class="fas fa-hashtag mr-2"></i>ID
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                            <i class="fas fa-tag mr-2"></i>Nama Kategori
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                            <i class="fas fa-calendar-times mr-2"></i>Dihapus Pada
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">