<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Kode Pos - Tendako</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.1/dist/flowbite.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.1/dist/flowbite.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
                             <i class="fas fa-map-marker-alt"></i>
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
                           class="text-gray-600 hover:text-orange-600 px-3 py-2 rounded-md text-sm font-medium transition-colors duration-200 flex items-center">
                            <i class="fas fa-city mr-2"></i>
                            Kab/Kota
                        </a>
                        
                        <a href="{{ route('kodepos.index') }}" 
                           class="bg-orange-100 text-orange-600 px-3 py-2 rounded-md text-sm font-medium flex items-center">
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
                   class="text-gray-600 hover:text-orange-600 block px-3 py-2 rounded-md text-base font-medium transition-colors duration-200">
                    <i class="fas fa-city mr-2"></i>
                    Kab/Kota
                </a>
                
                <a href="{{ route('kodepos.index') }}" 
                   class="bg-orange-100 text-orange-600 block px-3 py-2 rounded-md text-base font-medium">
                    <i class="fas fa-mail-bulk mr-2"></i>
                    Kodepos
                </a>
            </div>
        </div>
    </nav>



        <!-- Content -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <!-- Page Header -->
            <div class="mb-8">
                <div class="flex justify-between items-start">
                    <div>
                        <h2 class="text-3xl font-bold text-gray-900 mb-2">Data Kode Pos</h2>
                        <p class="text-gray-600">Data Pos kode  , Postal Zip</p>
                    </div>
                    <div class="flex space-x-3">
                        <a href="{{ route('kodepos.trash') }}" class="inline-flex items-center px-4 py-2 border border-red-300 text-red-600 bg-white hover:bg-red-50 rounded-lg font-medium transition-colors">
                            <i class="fas fa-trash mr-2"></i>
                            Trash
                        </a>
                        <a href="{{ route('kodepos.create') }}" class="inline-flex items-center px-4 py-2 bg-orange-500 text-white hover:bg-orange-600 rounded-lg font-medium transition-colors">
                            <i class="fas fa-plus mr-2"></i>
                            Tambah Baru
                        </a>
                    </div>
                </div>
            </div>

            <!-- Filters -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
                <form method="GET" action="{{ route('kodepos.index') }}" class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <!-- Search -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Pencarian</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-search text-gray-400"></i>
                                </div>
                                <input type="text" name="search" value="{{ request('search') }}" 
                                       placeholder="Cari kode pos, kelurahan, kecamatan..." 
                                       class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg focus:ring-orange-500 focus:border-orange-500">
                            </div>
                        </div>

                        <!-- Province Filter -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Provinsi</label>
                            <select name="provinsi" class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-orange-500 focus:border-orange-500">
                                <option value="">Semua Provinsi</option>
                                @foreach($provinsi as $prov)
                                    <option value="{{ $prov->kodedagri_prv }}" {{ request('provinsi') == $prov->kodedagri_prv ? 'selected' : '' }}>
                                        {{ $prov->namadagri_prv }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Kabkota Filter -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Kab/Kota</label>
                            <select name="kabkota" class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-orange-500 focus:border-orange-500">
                                <option value="">Semua Kab/Kota</option>
                                @foreach($kabkota as $kab)
                                    <option value="{{ $kab->kodedagri_kbk }}" {{ request('kabkota') == $kab->kodedagri_kbk ? 'selected' : '' }}>
                                        {{ $kab->namadagri_kbk }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-orange-500 text-white hover:bg-orange-600 rounded-lg font-medium transition-colors">
                            <i class="fas fa-search mr-2"></i>
                            Cari
                        </button>
                    </div>
                </form>
            </div>

            <!-- Success/Error Messages -->
            @if(session('success'))
                <div class="mb-4 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg" role="alert">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-check-circle text-green-500"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium">{{ session('success') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-4 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg" role="alert">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-exclamation-circle text-red-500"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium">{{ session('error') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Data Table -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kode Pos</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kelurahan</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kecamatan</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kab/Kota</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Provinsi</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($kodepos as $item)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="text-orange-600 font-semibold">{{ $item->kodepos_kdp }}</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="text-gray-900 font-medium">{{ $item->kel_kdp }}</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-600">{{ $item->kec_kdp }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-600">{{ $item->namadagri_kbk }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-600">{{ $item->namadagri_prv }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex items-center space-x-2">
                                            <a href="{{ route('kodepos.show', $item->id_kdp) }}" 
                                               class="inline-flex items-center px-2 py-1 text-xs bg-blue-100 text-blue-700 hover:bg-blue-200 rounded transition-colors">
                                                <i class="fas fa-eye mr-1"></i>
                                                Lihat
                                            </a>
                                            <a href="{{ route('kodepos.edit', $item->id_kdp) }}" 
                                               class="inline-flex items-center px-2 py-1 text-xs bg-yellow-100 text-yellow-700 hover:bg-yellow-200 rounded transition-colors">
                                                <i class="fas fa-edit mr-1"></i>
                                                Edit
                                            </a>
                                            <form action="{{ route('kodepos.destroy', $item->id_kdp) }}" method="POST" class="inline-block" 
                                                  onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="inline-flex items-center px-2 py-1 text-xs bg-red-100 text-red-700 hover:bg-red-200 rounded transition-colors">
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
                                        <div class="flex flex-col items-center">
                                            <i class="fas fa-search text-gray-400 text-4xl mb-4"></i>
                                            <p class="text-gray-500 text-lg font-medium">Tidak ada data ditemukan</p>
                                            <p class="text-gray-400 text-sm">Coba ubah filter pencarian Anda</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($kodepos->hasPages())
                    <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
                        <div class="flex items-center justify-between">
                            <div class="flex-1 flex justify-between sm:hidden">
                                @if ($kodepos->onFirstPage())
                                    <span class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-500 bg-white cursor-default">
                                        Previous
                                    </span>
                                @else
                                    <a href="{{ $kodepos->previousPageUrl() }}" class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                        Previous
                                    </a>
                                @endif

                                @if ($kodepos->hasMorePages())
                                    <a href="{{ $kodepos->nextPageUrl() }}" class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                        Next
                                    </a>
                                @else
                                    <span class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-500 bg-white cursor-default">
                                        Next
                                    </span>
                                @endif
                            </div>
                            <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                                <div>
                                    <p class="text-sm text-gray-700">
                                        Menampilkan
                                        <span class="font-medium">{{ $kodepos->firstItem() }}</span>
                                        sampai
                                        <span class="font-medium">{{ $kodepos->lastItem() }}</span>
                                        dari
                                        <span class="font-medium">{{ $kodepos->total() }}</span>
                                        hasil
                                    </p>
                                </div>
                                <div>
                                    {{ $kodepos->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- JavaScript for mobile menu -->
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