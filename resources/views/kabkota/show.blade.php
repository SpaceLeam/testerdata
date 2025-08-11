<!DOCTYPE html>
<html lang="id" class="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Kabupaten/Kota - Tendako</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.1/dist/flowbite.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.1/dist/flowbite.min.css" rel="stylesheet" />
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'soft-orange': '#f97316',
                        'soft-blue': '#3b82f6',
                        'soft-gray': '#6b7280',
                        'soft-green': '#10b981',
                        'soft-red': '#ef4444',
                        'soft-yellow': '#f59e0b'
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gray-50 text-gray-900 min-h-screen">
    <!-- Header -->
    <header class="bg-white border-b border-gray-200 sticky top-0 z-50 shadow-sm">
        <div class="container mx-auto px-6 py-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div class="w-8 h-8 bg-soft-orange rounded-lg flex items-center justify-center">
                        <span class="text-white font-bold text-sm">T</span>
                    </div>
                    <h1 class="text-xl font-semibold text-gray-800">Tendako</h1>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="hidden md:flex items-center space-x-2 text-sm text-gray-500">
                        <div class="w-2 h-2 bg-soft-green rounded-full"></div>
                        <span>Online</span>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="container mx-auto px-6 py-8 max-w-4xl">
        <!-- Page Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-2xl font-semibold text-gray-800 mb-2">Detail Kabupaten/Kota</h2>
                    <p class="text-gray-600">Informasi lengkap data kabupaten/kota</p>
                </div>
                <div class="flex items-center space-x-3">
                    <a href="{{ route('kabkota.index') }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:ring-4 focus:ring-gray-100 transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Kembali
                    </a>
                    <a href="{{ route('kabkota.edit', $kabkota->kodedagri_kbk) }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-soft-yellow border border-transparent rounded-lg hover:bg-yellow-600 focus:ring-4 focus:ring-yellow-200 transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"></path>
                        </svg>
                        Edit
                    </a>
                </div>
            </div>
        </div>

        <!-- Alert -->
        @if(session('success'))
        <div class="mb-6 p-4 text-sm text-soft-green bg-green-50 border border-green-200 rounded-lg">
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                </svg>
                {{ session('success') }}
            </div>
        </div>
        @endif

        <!-- Detail Card -->
        <div class="bg-white shadow-sm border border-gray-200 rounded-xl overflow-hidden mb-6">
            <div class="bg-blue-50 border-b border-blue-200 px-6 py-4">
                <h3 class="text-lg font-semibold text-soft-blue">Informasi Kabupaten/Kota</h3>
            </div>
            
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Kode Dagri -->
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-700">Kode Dagri</label>
                        <div class="bg-gray-50 border border-gray-200 rounded-lg px-4 py-3">
                            <span class="text-soft-blue font-semibold text-lg">{{ $kabkota->kodedagri_kbk }}</span>
                        </div>
                    </div>

                    <!-- Kode BPS -->
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-700">Kode BPS</label>
                        <div class="bg-gray-50 border border-gray-200 rounded-lg px-4 py-3">
                            <span class="text-gray-800 font-semibold text-lg">{{ $kabkota->kodebps_kbk }}</span>
                        </div>
                    </div>

                    <!-- Nama Dagri -->
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-700">Nama Dagri</label>
                        <div class="bg-gray-50 border border-gray-200 rounded-lg px-4 py-3">
                            <span class="text-gray-800 text-lg">{{ $kabkota->namadagri_kbk }}</span>
                        </div>
                    </div>

                    <!-- Nama BPS -->
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-700">Nama BPS</label>
                        <div class="bg-gray-50 border border-gray-200 rounded-lg px-4 py-3">
                            <span class="text-gray-800 text-lg">{{ $kabkota->namabps_kbk }}</span>
                        </div>
                    </div>

                    <!-- Provinsi -->
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-700">Provinsi</label>
                        <div class="bg-gray-50 border border-gray-200 rounded-lg px-4 py-3">
                            <span class="text-gray-800 text-lg">{{ $kabkota->namadagri_prv }}</span>
                        </div>
                    </div>

                    <!-- Status -->
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-700">Status</label>
                        <div class="bg-gray-50 border border-gray-200 rounded-lg px-4 py-3">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-soft-green">
                                <div class="w-2 h-2 bg-soft-green rounded-full mr-2"></div>
                                Aktif
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Metadata Card -->
        <div class="bg-white shadow-sm border border-gray-200 rounded-xl overflow-hidden mb-8">
            <div class="bg-gray-50 border-b border-gray-200 px-6 py-4">
                <h3 class="text-lg font-semibold text-gray-800">Metadata</h3>
            </div>
            
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                  

                    <!-- Created At -->
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-700">Created At</label>
                        <div class="bg-gray-50 border border-gray-200 rounded-lg px-4 py-3">
                            <div class="flex items-center space-x-2">
                                <svg class="w-4 h-4 text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="text-gray-800">{{ $kabkota->created_at ? \Carbon\Carbon::parse($kabkota->created_at)->format('d F Y, H:i') : '-' }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Updated At -->
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-700">Updated At</label>
                        <div class="bg-gray-50 border border-gray-200 rounded-lg px-4 py-3">
                            <div class="flex items-center space-x-2">
                                <svg class="w-4 h-4 text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M4 2a1 1 0 011 1v2.101a7.002 7.002 0 0111.601 2.566 1 1 0 11-1.885.666A5.002 5.002 0 005.999 7H9a1 1 0 010 2H4a1 1 0 01-1-1V3a1 1 0 011-1zm.008 9.057a1 1 0 011.276.61A5.002 5.002 0 0014.001 13H11a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0v-2.101a7.002 7.002 0 01-11.601-2.566 1 1 0 01.61-1.276z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="text-gray-800">{{ $kabkota->updated_at ? \Carbon\Carbon::parse($kabkota->updated_at)->format('d F Y, H:i') : '-' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <a href="{{ route('kabkota.index') }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:ring-4 focus:ring-gray-100 transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Kembali ke Daftar
                </a>
            </div>
            
            <div class="flex items-center space-x-3">
                <a href="{{ route('kabkota.edit', $kabkota->kodedagri_kbk) }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-soft-yellow border border-transparent rounded-lg hover:bg-yellow-600 focus:ring-4 focus:ring-yellow-200 transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"></path>
                    </svg>
                    Edit Data
                </a>
                
                <form method="POST" action="{{ route('kabkota.destroy', $kabkota->kodedagri_kbk) }}" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kabupaten/kota ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-soft-red border border-transparent rounded-lg hover:bg-red-600 focus:ring-4 focus:ring-red-200 transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z" clip-rule="evenodd"></path>
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        Hapus
                    </button>
                </form>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-200 mt-12">
        <div class="container mx-auto px-6 py-4">
            <div class="flex items-center justify-between">
                <div class="text-sm text-gray-600">
                    © 2024 Tendako System. Semua hak dilindungi.
                </div>
                <div class="flex items-center space-x-2 text-sm text-gray-500">
                    <span>Status:</span>
                    <div class="flex items-center">
                        <div class="w-2 h-2 bg-soft-green rounded-full mr-1"></div>
                        <span>Operasional</span>
                    </div>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>