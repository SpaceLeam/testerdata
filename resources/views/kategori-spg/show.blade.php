<!DOCTYPE html>
<html lang="id" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Kategori SPG</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .btn-gradient {
            background: linear-gradient(135deg, #3b82f6 0%, #06b6d4 100%);
        }
        .btn-gradient:hover {
            background: linear-gradient(135deg, #2563eb 0%, #0891b2 100%);
        }
    </style>
</head>
<body class="bg-slate-900 text-gray-100 min-h-screen">
    <div class="container mx-auto px-6 py-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center gap-4 mb-4">
                <a href="{{ route('kategori-spg.index') }}" 
                   class="text-slate-400 hover:text-white transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </a>
                <h1 class="text-3xl font-bold text-white">Detail Kategori SPG</h1>
            </div>
            <p class="text-slate-400">Informasi lengkap kategori Sales Promotion Girl</p>
        </div>

        <!-- Content -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Info -->
            <div class="lg:col-span-2">
                <div class="bg-slate-800 rounded-lg border border-slate-700 p-6">
                    <h2 class="text-xl font-semibold text-white mb-6">Informasi Kategori</h2>
                    
                    <dl class="space-y-4">
                        <div class="border-b border-slate-600 pb-4">
                            <dt class="text-sm font-medium text-slate-400">ID Kategori</dt>
                            <dd class="mt-1 text-lg font-semibold text-white">{{ $kategoriSpg->id_ksp }}</dd>
                        </div>
                        
                        <div class="border-b border-slate-600 pb-4">
                            <dt class="text-sm font-medium text-slate-400">Nama Kategori</dt>
                            <dd class="mt-1 text-lg text-white">{{ $kategoriSpg->nama_ksp }}</dd>
                        </div>
                        
                        <div class="border-b border-slate-600 pb-4">
                            <dt class="text-sm font-medium text-slate-400">Status</dt>
                            <dd class="mt-1">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-800 text-green-200">
                                    <svg class="w-2 h-2 mr-1" fill="currentColor" viewBox="0 0 8 8">
                                        <circle cx="4" cy="4" r="3"/>
                                    </svg>
                                    Aktif
                                </span>
                            </dd>
                        </div>
                        
                        <div class="border-b border-slate-600 pb-4">
                            <dt class="text-sm font-medium text-slate-400">Tanggal Dibuat</dt>
                            <dd class="mt-1 text-white">
                                {{ \Carbon\Carbon::parse($kategoriSpg->created_at)->format('l, d F Y') }}
                                <span class="text-slate-400 text-sm">
                                    ({{ \Carbon\Carbon::parse($kategoriSpg->created_at)->format('H:i') }} WIB)
                                </span>
                            </dd>
                        </div>
                        
                        <div>
                            <dt class="text-sm font-medium text-slate-400">Terakhir Diperbarui</dt>
                            <dd class="mt-1 text-white">
                                {{ \Carbon\Carbon::parse($kategoriSpg->updated_at)->format('l, d F Y') }}
                                <span class="text-slate-400 text-sm">
                                    ({{ \Carbon\Carbon::parse($kategoriSpg->updated_at)->format('H:i') }} WIB)
                                </span>
                            </dd>
                        </div>
                    </dl>
                </div>
            </div>

            <!-- Actions -->
            <div>
                <div class="bg-slate-800 rounded-lg border border-slate-700 p-6">
                    <h3 class="text-lg font-semibold text-white mb-4">Aksi</h3>
                    
                    <div class="space-y-3">
                        <a href="{{ route('kategori-spg.edit', $kategoriSpg->id_ksp) }}" 
                           class="btn-gradient text-white px-4 py-2 rounded-lg font-medium hover:shadow-lg transition-all duration-200 flex items-center gap-2 w-full justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                            Edit Kategori
                        </a>
                        
                        <form method="POST" action="{{ route('kategori-spg.destroy', $kategoriSpg->id_ksp) }}" 
                              onsubmit="return confirm('Yakin ingin menghapus kategori ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="bg-red-600 hover:bg-red-500 text-white px-4 py-2 rounded-lg font-medium transition-colors flex items-center gap-2 w-full justify-center">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                                Hapus Kategori
                            </button>
                        </form>
                        
                        <a href="{{ route('kategori-spg.index') }}" 
                           class="bg-slate-600 hover:bg-slate-500 text-white px-4 py-2 rounded-lg font-medium transition-colors flex items-center gap-2 w-full justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                            Kembali ke Daftar
                        </a>
                    </div>
                </div>

                <!-- Statistics -->
                <div class="bg-slate-800 rounded-lg border border-slate-700 p-6 mt-6">
                    <h3 class="text-lg font-semibold text-white mb-4">Statistik</h3>
                    
                    <div class="space-y-4">
                        <div class="text-center">
                            <div class="text-2xl font-bold text-blue-400">
                                {{ \Carbon\Carbon::parse($kategoriSpg->created_at)->diffInDays(\Carbon\Carbon::now()) }}
                            </div>
                            <div class="text-sm text-slate-400">Hari sejak dibuat</div>
                        </div>
                        
                        <div class="border-t border-slate-600 pt-4">
                            <div class="text-center">
                                <div class="text-lg font-semibold text-green-400">
                                    {{ \Carbon\Carbon::parse($kategoriSpg->updated_at)->diffForHumans() }}
                                </div>
                                <div class="text-sm text-slate-400">Terakhir diperbarui</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>