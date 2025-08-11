<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trash PSR - Data Damkar Pendataan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#ff6b35',
                        secondary: '#f7931e'
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gray-50">
    <div class="min-h-screen">
        <!-- Header -->
        <div class="bg-white shadow-sm border-b">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between h-16">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-red-500 text-white p-2 rounded-lg">
                            <i class="fas fa-trash text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <h1 class="text-xl font-semibold text-gray-900">Trash PSR</h1>
                            <p class="text-sm text-gray-500">Data Damkar Pendataan - Data yang Dihapus</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-4">
                        <a href="{{ route('psr.index') }}" 
                           class="inline-flex items-center px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-800 text-sm font-medium rounded-lg transition-colors">
                            <i class="fas fa-arrow-left mr-2"></i>
                            Kembali ke Daftar PSR
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
            <!-- Success Message -->
            @if(session('success'))
            <div class="mb-6 bg-green-50 border border-green-200 rounded-lg p-4">
                <div class="flex items-center">
                    <i class="fas fa-check-circle text-green-400 mr-3"></i>
                    <span class="text-green-800">{{ session('success') }}</span>
                </div>
            </div>
            @endif

            <!-- Error Messages -->
            @if(session('error'))
            <div class="mb-6 bg-red-50 border border-red-200 rounded-lg p-4">
                <div class="flex items-center">
                    <i class="fas fa-exclamation-circle text-red-400 mr-3"></i>
                    <span class="text-red-800">{{ session('error') }}</span>
                </div>
            </div>
            @endif

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-red-100 text-red-600">
                            <i class="fas fa-trash text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Data di Trash</p>
                            <p class="text-2xl font-semibold text-gray-900">{{ $psr->total() }}</p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-yellow-100 text-yellow-600">
                            <i class="fas fa-exclamation-triangle text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Perlu Perhatian</p>
                            <p class="text-2xl font-semibold text-gray-900">{{ $psr->count() }}</p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                            <i class="fas fa-undo text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Dapat Dipulihkan</p>
                            <p class="text-2xl font-semibold text-gray-900">{{ $psr->count() }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filter and Actions -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 mb-8">
                <div class="px-6 py-4 border-b border-gray-200">
                    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                        <!-- Search -->
                        <div class="flex-1 max-w-md">
                            <form method="GET" class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-search text-gray-400"></i>
                                </div>
                                <input type="text" 
                                       name="search" 
                                       value="{{ request('search') }}"
                                       placeholder="Cari nama PSR, alamat, atau kodepos..."
                                       class="block w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
                                <button type="submit" class="sr-only">Search</button>
                            </form>
                        </div>

                        <!-- Bulk Actions -->
                        <div class="flex items-center space-x-3">
                            <button onclick="bulkRestore()" 
                                    class="inline-flex items-center px-4 py-2 bg-green-100 hover:bg-green-200 text-green-800 text-sm font-medium rounded-lg transition-colors">
                                <i class="fas fa-undo mr-2"></i>
                                Pulihkan Terpilih
                            </button>
                            
                            <button onclick="bulkPermanentDelete()" 
                                    class="inline-flex items-center px-4 py-2 bg-red-100 hover:bg-red-200 text-red-800 text-sm font-medium rounded-lg transition-colors">
                                <i class="fas fa-trash mr-2"></i>
                                Hapus Permanen
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Table -->
                @if($psr->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left">
                                    <input type="checkbox" 
                                           id="select-all" 
                                           class="rounded border-gray-300 text-primary focus:ring-primary"
                                           onchange="toggleAll()">
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($psr as $item)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <input type="checkbox" 
                                           name="selected_items" 
                                           value="{{ $item->id_psr }}" 
                                           class="item-checkbox rounded border-gray-300 text-primary focus:ring-primary">
                                </td>
                                
                                <td class="px-6 py-4">
                                    <div class="flex items-start">
                                        <div class="p-2 bg-red-100 text-red-600 rounded-lg mr-3">
                                            <i class="fas fa-fire-extinguisher"></i>
                                        </div>
                                        <div>
                                            <div class="text-sm font-medium text-gray-900">{{ $item->cbg_psr }}</div>
                                            <div class="text-sm text-gray-500 max-w-xs truncate">{{ $item->alamat_psr }}</div>
                                            @if($item->latitude_psr && $item->longitude_psr)
                                            <div class="text-xs text-blue-600 mt-1">
                                                <i class="fas fa-map-marker-alt mr-1"></i>
                                                {{ $item->latitude_psr }}, {{ $item->longitude_psr }}
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-900">
                                        <div class="flex items-center mb-1">
                                            <i class="fas fa-map-pin text-gray-400 mr-2 text-xs"></i>
                                            <span class="font-medium">{{ $item->kodepos_kdp ?? 'N/A' }}</span>
                                        </div>
                                        <div class="text-xs text-gray-500">
                                            {{ $item->kel_kdp ?? 'N/A' }}, {{ $item->kec_kdp ?? 'N/A' }}
                                        </div>
                                        <div class="text-xs text-gray-500">
                                            {{ $item->namadagri_kbk ?? 'N/A' }}
                                        </div>
                                        <div class="text-xs text-gray-400">
                                            {{ $item->namadagri_prv ?? 'N/A' }}
                                        </div>
                                    </div>
                                </td>
                                
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">
                                        {{ \Carbon\Carbon::parse($item->updated_at)->format('d/m/Y H:i') }}
                                    </div>
                                    <div class="text-xs text-gray-500">
                                        {{ \Carbon\Carbon::parse($item->updated_at)->diffForHumans() }}
                                    </div>
                                </td>
                                
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                    <!-- Restore Button -->
                                    <form action="{{ route('psr.restore', $item->id_psr) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" 
                                                onclick="return confirm('Yakin ingin memulihkan data PSR {{ $item->cbg_psr }}?')"
                                                class="inline-flex items-center px-3 py-1.5 bg-green-100 hover:bg-green-200 text-green-800 text-xs font-medium rounded-md transition-colors">
                                            <i class="fas fa-undo mr-1"></i>
                                            Pulihkan
                                        </button>
                                    </form>
                                    
                                    <!-- Permanent Delete Button -->
                                    <form action="{{ route('psr.permanent-delete', $item->id_psr) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                onclick="return confirm('PERHATIAN: Data akan dihapus PERMANEN dan tidak dapat dipulihkan lagi. Yakin ingin melanjutkan?')"
                                                class="inline-flex items-center px-3 py-1.5 bg-red-100 hover:bg-red-200 text-red-800 text-xs font-medium rounded-md transition-colors">
                                            <i class="fas fa-trash mr-1"></i>
                                            Hapus Permanen
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($psr->hasPages())
                <div class="px-6 py-4 border-t border-gray-200">
                    <div class="flex items-center justify-between">
                        <div class="flex-1 flex justify-between sm:hidden">
                            @if($psr->onFirstPage())
                                <span class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default leading-5 rounded-md">
                                    Previous
                                </span>
                            @else
                                <a href="{{ $psr->previousPageUrl() }}" class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 rounded-md hover:text-gray-500 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150">
                                    Previous
                                </a>
                            @endif

                            @if($psr->hasMorePages())
                                <a href="{{ $psr->nextPageUrl() }}" class="relative inline-flex items-center px-4 py-2 ml-3 text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 rounded-md hover:text-gray-500 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150">
                                    Next
                                </a>
                            @else
                                <span class="relative inline-flex items-center px-4 py-2 ml-3 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default leading-5 rounded-md">
                                    Next
                                </span>
                            @endif
                        </div>

                        <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                            <div>
                                <p class="text-sm text-gray-700 leading-5">
                                    Showing
                                    <span class="font-medium">{{ $psr->firstItem() ?? 0 }}</span>
                                    to
                                    <span class="font-medium">{{ $psr->lastItem() ?? 0 }}</span>
                                    of
                                    <span class="font-medium">{{ $psr->total() }}</span>
                                    results
                                </p>
                            </div>

                            <div>
                                {{ $psr->links() }}
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                @else
                <!-- Empty State -->
                <div class="text-center py-12">
                    <div class="mx-auto w-24 h-24 bg-green-100 rounded-full flex items-center justify-center mb-4">
                        <i class="fas fa-smile text-green-600 text-3xl"></i>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Tidak Ada Data di Trash</h3>
                    <p class="text-gray-500 mb-6">Semua data PSR dalam kondisi aktif. Tidak ada data yang dihapus.</p>
                    <a href="{{ route('psr.index') }}" 
                       class="inline-flex items-center px-4 py-2 bg-primary hover:bg-primary-600 text-white text-sm font-medium rounded-lg transition-colors">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Kembali ke Daftar PSR
                    </a>
                </div>
                @endif
            </div>

            <!-- Help Text -->
            @if($psr->count() > 0)
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                <div class="flex items-start">
                    <i class="fas fa-info-circle text-blue-500 mr-3 mt-0.5"></i>
                    <div class="text-blue-800 text-sm">
                        <h4 class="font-medium mb-2">Informasi Penting:</h4>
                        <ul class="space-y-1 text-blue-700">
                            <li>• <strong>Pulihkan:</strong> Mengembalikan data ke daftar aktif PSR</li>
                            <li>• <strong>Hapus Permanen:</strong> Menghapus data secara permanen dan tidak dapat dipulihkan</li>
                            <li>• Data di trash tidak akan muncul di pencarian atau laporan</li>
                            <li>• Gunakan fitur bulk action untuk memproses beberapa data sekaligus</li>
                        </ul>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>

    <script>
        // Select all functionality
        function toggleAll() {
            const selectAll = document.getElementById('select-all');
            const checkboxes = document.querySelectorAll('.item-checkbox');
            
            checkboxes.forEach(checkbox => {
                checkbox.checked = selectAll.checked;
            });
        }

        // Update select all when individual checkboxes change
        document.querySelectorAll('.item-checkbox').forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                const total = document.querySelectorAll('.item-checkbox').length;
                const checked = document.querySelectorAll('.item-checkbox:checked').length;
                const selectAll = document.getElementById('select-all');
                
                selectAll.indeterminate = checked > 0 && checked < total;
                selectAll.checked = checked === total;
            });
        });

        // Bulk restore function
        function bulkRestore() {
            const selectedItems = Array.from(document.querySelectorAll('.item-checkbox:checked'))
                .map(cb => cb.value);
            
            if (selectedItems.length === 0) {
                alert('Pilih minimal satu data untuk dipulihkan');
                return;
            }

            if (confirm(`Yakin ingin memulihkan ${selectedItems.length} data PSR?`)) {
                // Create form and submit
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = '{{ route("psr.bulk-restore") }}';
                
                // Add CSRF token
                const csrfInput = document.createElement('input');
                csrfInput.type = 'hidden';
                csrfInput.name = '_token';
                csrfInput.value = '{{ csrf_token() }}';
                form.appendChild(csrfInput);
                
                // Add selected items
                selectedItems.forEach(id => {
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'ids[]';
                    input.value = id;
                    form.appendChild(input);
                });
                
                document.body.appendChild(form);
                form.submit();
            }
        }

        // Bulk permanent delete function
        function bulkPermanentDelete() {
            const selectedItems = Array.from(document.querySelectorAll('.item-checkbox:checked'))
                .map(cb => cb.value);
            
            if (selectedItems.length === 0) {
                alert('Pilih minimal satu data untuk dihapus permanen');
                return;
            }

            if (confirm(`PERHATIAN: ${selectedItems.length} data akan dihapus PERMANEN dan tidak dapat dipulihkan lagi.\n\nYakin ingin melanjutkan?`)) {
                // Create form and submit
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = '{{ route("psr.bulk-permanent-delete") }}';
                
                // Add CSRF token
                const csrfInput = document.createElement('input');
                csrfInput.type = 'hidden';
                csrfInput.name = '_token';
                csrfInput.value = '{{ csrf_token() }}';
                form.appendChild(csrfInput);
                
                // Add method override for DELETE
                const methodInput = document.createElement('input');
                methodInput.type = 'hidden';
                methodInput.name = '_method';
                methodInput.value = 'DELETE';
                form.appendChild(methodInput);
                
                // Add selected items
                selectedItems.forEach(id => {
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'ids[]';
                    input.value = id;
                    form.appendChild(input);
                });
                
                document.body.appendChild(form);
                form.submit();
            }
        }

        // Auto-submit search form on input
        const searchInput = document.querySelector('input[name="search"]');
        let searchTimeout;

        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                this.form.submit();
            }, 500);
        });

        // Highlight search terms
        function highlightSearchTerm() {
            const searchTerm = '{{ request("search") }}';
            if (searchTerm && searchTerm.length > 0) {
                const regex = new RegExp(`(${searchTerm})`, 'gi');
                document.querySelectorAll('td').forEach(td => {
                    if (td.textContent.toLowerCase().includes(searchTerm.toLowerCase())) {
                        td.innerHTML = td.innerHTML.replace(regex, '<mark class="bg-yellow-200">$1</mark>');
                    }
                });
            }
        }

        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            highlightSearchTerm();
        });
    </script>
</body>
</html>PSR Info
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Lokasi
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Dihapus Pada
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">