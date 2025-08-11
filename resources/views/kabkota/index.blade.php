<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Kabupaten/Kota - Tendako</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.1/dist/flowbite.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.1/dist/flowbite.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'soft-orange': '#F97316',
                        'soft-blue': '#3B82F6',
                        'soft-slate': '#64748B',
                        'light-gray': '#F8FAFC',
                        'medium-gray': '#F1F5F9',
                        'warm-gray': '#78716C'
                    },
                    fontFamily: {
                        'sans': ['Inter', 'system-ui', 'sans-serif']
                    }
                }
            }
        }
    </script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body class="bg-gray-50">
    <!-- Navigation Bar -->
    <nav class="bg-white shadow-lg border-b-2 border-orange-500">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo & Brand -->
                <div class="flex items-center">
                    <a href="{{ url('/') }}" class="flex items-center space-x-3 group">
                        <div class="bg-orange-500 p-2 rounded-lg group-hover:bg-orange-600 transition-colors duration-200">
                             <i class="fas fa-home-alt text-white"></i>
                        </div>
                        <div>
                            <h1 class="text-xl font-bold text-gray-900">Tendako</h1>
                            <p class="text-xs text-gray-600">Pusat Data & Informasi</p>
                        </div>
                    </a>
                </div>

                <!-- Main Navigation -->
                <div class="hidden md:block">
                    <div class="ml-10 flex items-baseline space-x-4">
                        <a href="{{ url('/') }}" 
                           class="text-gray-600 hover:text-orange-600 px-3 py-2 rounded-md text-sm font-medium transition-colors duration-200 flex items-center">
                            <i class="fas fa-home mr-2"></i>
                            Home
                        </a>
                        
                        <a href="{{ route('psr.index') }}" 
                           class="text-gray-600 hover:text-orange-600 px-3 py-2 rounded-md text-sm font-medium transition-colors duration-200 flex items-center">
                            <i class="fas fa-building mr-2"></i>
                            Data PSR
                        </a>
                        
                        <a href="{{ route('provinsi.index') }}" 
                           class="text-gray-600 hover:text-orange-600 px-3 py-2 rounded-md text-sm font-medium transition-colors duration-200 flex items-center">
                            <i class="fas fa-map mr-2"></i>
                            Provinsi
                        </a>
                        
                        <a href="{{ route('kabkota.index') }}" 
                           class="bg-orange-100 text-orange-600 px-3 py-2 rounded-md text-sm font-medium flex items-center">
                            <i class="fas fa-city mr-2"></i>
                            Kab/Kota
                        </a>
                        
                        <a href="{{ route('kodepos.index') }}" 
                           class="text-gray-600 hover:text-orange-600 px-3 py-2 rounded-md text-sm font-medium transition-colors duration-200 flex items-center">
                            <i class="fas fa-mail-bulk mr-2"></i>
                            Kodepos
                        </a>
                    </div>
                </div>

                <!-- Mobile menu button -->
                <div class="md:hidden">
                    <button type="button" id="mobile-menu-button" 
                            class="text-gray-600 hover:text-orange-600 inline-flex items-center justify-center p-2 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-500">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Navigation Menu -->
        <div class="md:hidden hidden" id="mobile-menu">
            <div class="px-2 pt-2 pb-3 space-y-1 bg-gray-50 border-t">
                <a href="{{ url('/') }}" 
                   class="text-gray-600 hover:text-orange-600 block px-3 py-2 rounded-md text-base font-medium transition-colors duration-200">
                    <i class="fas fa-home mr-2"></i>
                    Home
                </a>
                
                <a href="{{ route('psr.index') }}" 
                   class="text-gray-600 hover:text-orange-600 block px-3 py-2 rounded-md text-base font-medium transition-colors duration-200">
                    <i class="fas fa-building mr-2"></i>
                    Data PSR
                </a>
                
                <a href="{{ route('provinsi.index') }}" 
                   class="text-gray-600 hover:text-orange-600 block px-3 py-2 rounded-md text-base font-medium transition-colors duration-200">
                    <i class="fas fa-map mr-2"></i>
                    Provinsi
                </a>
                
                <a href="{{ route('kabkota.index') }}" 
                   class="bg-orange-100 text-orange-600 block px-3 py-2 rounded-md text-base font-medium">
                    <i class="fas fa-city mr-2"></i>
                    Kab/Kota
                </a>
                
                <a href="{{ route('kodepos.index') }}" 
                   class="text-gray-600 hover:text-orange-600 block px-3 py-2 rounded-md text-base font-medium transition-colors duration-200">
                    <i class="fas fa-mail-bulk mr-2"></i>
                    Kodepos
                </a>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Page Header -->
        <div class="mb-8">
            <div class="sm:flex sm:items-center sm:justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Data Kabupaten/Kota</h1>
                    <p class="mt-2 text-sm text-soft-slate">Data Kab/Kota, Dagri, BPS</p>
                </div>
                <div class="mt-4 sm:mt-0 flex space-x-3">
                    <a href="{{ route('kabkota.trash') }}" class="inline-flex items-center px-4 py-2 border border-red-300 text-sm font-medium rounded-lg text-red-700 bg-red-50 hover:bg-red-100 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition-colors duration-200">
                        <i class="fas fa-trash mr-2"></i>
                        Trash
                    </a>
                    <a href="{{ route('kabkota.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-lg text-white bg-orange-500 hover:bg-orange-600 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2 transition-colors duration-200">
                        <i class="fas fa-plus mr-2"></i>
                        Tambah Baru
                    </a>
                </div>
            </div>
        </div>

        <!-- Alerts -->
        @if(session('success'))
        <div class="mb-6 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg" role="alert">
            <div class="flex items-center">
                <i class="fas fa-check-circle mr-2"></i>
                {{ session('success') }}
            </div>
        </div>
        @endif

        @if(session('error'))
        <div class="mb-6 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg" role="alert">
            <div class="flex items-center">
                <i class="fas fa-exclamation-circle mr-2"></i>
                {{ session('error') }}
            </div>
        </div>
        @endif

        <!-- Search and Filter Card -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6">
            <div class="px-6 py-4">
                <form method="GET" action="{{ route('kabkota.index') }}" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <!-- Search Input -->
                    <div class="md:col-span-1">
                        <label for="search" class="block text-sm font-medium text-gray-700 mb-2">Pencarian</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-search text-gray-400"></i>
                            </div>
                            <input type="text" name="search" id="search" value="{{ request('search') }}" 
                                   placeholder="Cari kab/kota, kelurahan, kecamatan..." 
                                   class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md focus:ring-orange-500 focus:border-orange-500 sm:text-sm">
                        </div>
                    </div>

                    <!-- Province Filter -->
                    <div>
                        <label for="provinsi" class="block text-sm font-medium text-gray-700 mb-2">Provinsi</label>
                        <select name="provinsi" id="provinsi" class="block w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-orange-500 focus:border-orange-500 sm:text-sm">
                            <option value="">Semua Provinsi</option>
                            @foreach($provinsi as $prov)
                            <option value="{{ $prov->kodedagri_prv }}" {{ request('provinsi') == $prov->kodedagri_prv ? 'selected' : '' }}>
                                {{ $prov->namadagri_prv }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex items-end space-x-2">
                        <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-orange-500 hover:bg-orange-600 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2 transition-colors duration-200">
                            <i class="fas fa-search mr-2"></i>
                            Cari
                        </button>
                        @if(request('search') || request('provinsi'))
                        <a href="{{ route('kabkota.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2 transition-colors duration-200">
                            <i class="fas fa-undo mr-2"></i>
                            Reset
                        </a>
                        @endif
                    </div>
                </form>
            </div>
        </div>

        <!-- Data Table Card -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Kode Dagri
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Nama Dagri
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Nama BPS
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Provinsi
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Dibuat
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($kabkota as $item)
                        <tr class="hover:bg-gray-50 transition-colors duration-150">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-orange-600">
                                {{ $item->kodedagri_kbk }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $item->namadagri_kbk }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $item->namabps_kbk }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $item->namadagri_prv }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $item->created_at ? \Carbon\Carbon::parse($item->created_at)->format('d/m/Y H:i') : '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex items-center space-x-2">
                                    <a href="{{ route('kabkota.show', $item->kodedagri_kbk) }}" class="inline-flex items-center px-2 py-1 text-xs font-medium rounded-full bg-blue-100 text-blue-800 hover:bg-blue-200 transition-colors duration-150">
                                        <i class="fas fa-eye mr-1"></i>
                                        Lihat
                                    </a>
                                    <a href="{{ route('kabkota.edit', $item->kodedagri_kbk) }}" class="inline-flex items-center px-2 py-1 text-xs font-medium rounded-full bg-yellow-100 text-yellow-800 hover:bg-yellow-200 transition-colors duration-150">
                                        <i class="fas fa-edit mr-1"></i>
                                        Edit
                                    </a>
                                    <form method="POST" action="{{ route('kabkota.destroy', $item->kodedagri_kbk) }}" class="inline" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="inline-flex items-center px-2 py-1 text-xs font-medium rounded-full bg-red-100 text-red-800 hover:bg-red-200 transition-colors duration-150">
                                            <i class="fas fa-trash mr-1"></i>
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center space-y-4">
                                    <i class="fas fa-folder-open text-gray-400 text-5xl"></i>
                                    <div>
                                        <p class="text-sm font-medium text-gray-900">Data tidak ditemukan</p>
                                        <p class="text-sm text-gray-500">Tidak ada data kabupaten/kota yang sesuai dengan kriteria pencarian</p>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($kabkota->hasPages())
                <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
                    <div class="flex items-center justify-between">
                        <div class="flex-1 flex justify-between sm:hidden">
                            @if ($kabkota->onFirstPage())
                                <span class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-500 bg-white cursor-default">
                                    Sebelumnya
                                </span>
                            @else
                                <a href="{{ $kabkota->previousPageUrl() }}" class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                    Sebelumnya
                                </a>
                            @endif

                            @if ($kabkota->hasMorePages())
                                <a href="{{ $kabkota->nextPageUrl() }}" class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                    Selanjutnya
                                </a>
                            @else
                                <span class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-500 bg-white cursor-default">
                                    Selanjutnya
                                </span>
                            @endif
                        </div>
                        <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                            <div>
                                <p class="text-sm text-gray-700">
                                    Menampilkan
                                    <span class="font-medium">{{ $kabkota->firstItem() }}</span>
                                    sampai
                                    <span class="font-medium">{{ $kabkota->lastItem() }}</span>
                                    dari
                                    <span class="font-medium">{{ $kabkota->total() }}</span>
                                    hasil
                                </p>
                            </div>
                            <div>
                                {{ $kabkota->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-200 mt-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="flex items-center justify-between">
                <div class="text-sm text-gray-500">
                    © 2024 Tendako System. All rights reserved.
                </div>
                <div class="flex items-center space-x-4 text-sm text-gray-500">
                    <span>Status: Operasional</span>
                    <div class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></div>
                </div>
            </div>
        </div>
    </footer>

    <script>
        // Mobile menu toggle
        document.getElementById('mobile-menu-button').addEventListener('click', function() {
            const mobileMenu = document.getElementById('mobile-menu');
            mobileMenu.classList.toggle('hidden');
        });

        // Close mobile menu when clicking outside
        document.addEventListener('click', function(event) {
            const mobileMenu = document.getElementById('mobile-menu');
            const mobileMenuButton = document.getElementById('mobile-menu-button');
            
            if (!mobileMenuButton.contains(event.target) && !mobileMenu.contains(event.target)) {
                mobileMenu.classList.add('hidden');
            }
        });
    </script>
</body>
</html>