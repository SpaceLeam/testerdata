<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trash Kode Pos - Tendako</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.1/dist/flowbite.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.1/dist/flowbite.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50">
    <div class="min-h-screen">
        <!-- Header -->
        <div class="bg-white shadow-sm border-b border-gray-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between h-16">
                    <div class="flex items-center">
                        <div class="bg-orange-500 text-white p-2 rounded-lg mr-3">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <h1 class="text-xl font-semibold text-gray-900">Tendako</h1>
                        <div class="ml-4 flex items-center text-sm text-green-600">
                            <div class="w-2 h-2 bg-green-500 rounded-full mr-2"></div>
                            Online
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Content -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <!-- Page Header -->
            <div class="mb-8">
                <div class="flex justify-between items-start">
                    <div>
                        <div class="flex items-center space-x-4 mb-4">
                            <a href="{{ route('kodepos.index') }}" class="inline-flex items-center text-orange-600 hover:text-orange-700 font-medium">
                                <i class="fas fa-arrow-left mr-2"></i>
                                Kembali ke Data Aktif
                            </a>
                        </div>
                        <h2 class="text-3xl font-bold text-gray-900 mb-2">
                            <i class="fas fa-trash text-red-500 mr-3"></i>
                            Trash Kode Pos
                        </h2>
                        <p class="text-gray-600">Data kode pos yang telah dihapus (non-aktif)</p>
                    </div>
                </div>
            </div>

            <!-- Search Filter -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
                <form method="GET" action="{{ route('kodepos.trash') }}" class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <!-- Search -->
                        <div class="md:col-span-3">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Pencarian</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-search text-gray-400"></i>
                                </div>
                                <input type="text" name="search" value="{{ request('search') }}" 
                                       placeholder="Cari kode pos, kelurahan, kecamatan..." 
                                       class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg focus:ring-red-500 focus:border-red-500">
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-500 text-white hover:bg-red-600 rounded-lg font-medium transition-colors">
                            <i class="fas fa-search mr-2"></i>
                            Cari di Trash
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

            <!-- Warning Notice -->
            <div class="mb-6 bg-amber-50 border border-amber-200 text-amber-700 px-4 py-3 rounded-lg">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <i class="fas fa-exclamation-triangle text-amber-500"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium">
                            <strong>Perhatian:</strong> Data di halaman ini telah dihapus dari sistem aktif. 
                            Anda dapat memulihkan atau menghapus permanen data tersebut.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Data Table -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-red-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-red-700 uppercase tracking-wider">Kode Pos</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-red-700 uppercase tracking-wider">Kelurahan</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-red-700 uppercase tracking-wider">Kecamatan</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-red-700 uppercase tracking-wider">Kab/Kota</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-red-700 uppercase tracking-wider">Provinsi</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-red-700 uppercase tracking-wider">Dihapus</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-red-700 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($kodepos as $item)
                                <tr class="hover:bg-gray-50 opacity-75">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="text-red-600 font-semibold line-through">{{ $item->kodepos_kdp }}</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="text-gray-600 line-through">{{ $item->kel_kdp }}</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-500 line-through">{{ $item->kec_kdp }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-500 line-through">{{ $item->namadagri_kbk }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-500 line-through">{{ $item->namadagri_prv }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $item->updated_at ? \Carbon\Carbon::parse($item->updated_at)->format('d/m/Y H:i') : '-' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex items-center space-x-2">
                                            <form action="{{ route('kodepos.restore', $item->id_kdp) }}" method="POST" class="inline-block" 
                                                  onsubmit="return confirm('Yakin ingin memulihkan data ini?')">
                                                @csrf
                                                <button type="submit" 
                                                        class="inline-flex items-center px-2 py-1 text-xs bg-green-100 text-green-700 hover:bg-green-200 rounded transition-colors">
                                                    <i class="fas fa-undo mr-1"></i>
                                                    Pulihkan
                                                </button>
                                            </form>
                                            <form action="{{ route('kodepos.force-delete', $item->id_kdp) }}" method="POST" class="inline-block" 
                                                  onsubmit="return confirm('PERINGATAN: Data akan dihapus permanen dan tidak dapat dipulihkan! Yakin ingin melanjutkan?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="inline-flex items-center px-2 py-1 text-xs bg-red-100 text-red-700 hover:bg-red-200 rounded transition-colors">
                                                    <i class="fas fa-trash-alt mr-1"></i>
                                                    Hapus Permanen
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-12 text-center">
                                        <div class="flex flex-col items-center">
                                            <i class="fas fa-trash text-gray-400 text-4xl mb-4"></i>
                                            <p class="text-gray-500 text-lg font-medium">Trash kosong</p>
                                            <p class="text-gray-400 text-sm">Tidak ada data yang dihapus</p>
                                            <a href="{{ route('kodepos.index') }}" 
                                               class="mt-4 inline-flex items-center px-4 py-2 bg-orange-500 text-white hover:bg-orange-600 rounded-lg font-medium transition-colors">
                                                <i class="fas fa-arrow-left mr-2"></i>
                                                Kembali ke Data Aktif
                                            </a>
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
                                        data di trash
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

            <!-- Bulk Actions Info -->
            @if($kodepos->total() > 0)
            <div class="mt-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <i class="fas fa-info-circle text-blue-500"></i>
                    </div>
                    <div class="ml-3">
                        <h4 class="text-sm font-medium text-blue-800">Informasi Pengelolaan Trash</h4>
                        <div class="mt-2 text-sm text-blue-700">
                            <ul class="list-disc list-inside space-y-1">
                                <li><strong>Pulihkan:</strong> Mengembalikan data ke status aktif</li>
                                <li><strong>Hapus Permanen:</strong> Menghapus data secara permanen dari database (tidak dapat diurungkan)</li>
                                <li>Total {{ $kodepos->total() }} data dalam trash</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</body>
</html>