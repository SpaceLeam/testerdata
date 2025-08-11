<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data PSR - Damkar Indonesia</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
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
                            <i class="fas fa-fire text-white text-xl"></i>
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
                           class="bg-orange-100 text-orange-600 px-3 py-2 rounded-md text-sm font-medium flex items-center">
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
                   class="bg-orange-100 text-orange-600 block px-3 py-2 rounded-md text-base font-medium">
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
                   class="text-gray-600 hover:text-orange-600 block px-3 py-2 rounded-md text-base font-medium transition-colors duration-200">
                    <i class="fas fa-mail-bulk mr-2"></i>
                    Kodepos
                </a>
            </div>
        </div>
    </nav>

    <div class="min-h-screen">
        <!-- Header Section -->
        <div class="bg-white shadow-sm border-b">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
                <div class="flex justify-between items-center">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900 flex items-center">
                            <i class="fas fa-building text-orange-500 mr-3"></i>
                            Data PSR
                        </h1>
                        <p class="text-gray-600 mt-1">Kelola data lokasi pemetaan Damkar se Indonesia</p>
                    </div>
                    <div class="flex space-x-3">
                        <a href="{{ route('psr.trash') }}" class="inline-flex items-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg transition-colors duration-200">
                            <i class="fas fa-trash mr-2"></i>
                            Trash
                        </a>
                        <a href="{{ route('psr.create') }}" class="inline-flex items-center px-4 py-2 bg-orange-500 hover:bg-orange-600 text-white rounded-lg transition-colors duration-200">
                            <i class="fas fa-plus mr-2"></i>
                            Tambah Baru
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <!-- Alert Messages -->
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6 flex items-center">
                    <i class="fas fa-check-circle mr-2"></i>
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-6 flex items-center">
                    <i class="fas fa-exclamation-circle mr-2"></i>
                    {{ session('error') }}
                </div>
            @endif

            <!-- Search & Filter Section -->
            <div class="bg-gradient-to-r from-purple-500 to-pink-500 rounded-xl p-6 mb-8 text-white">
                <h3 class="text-lg font-semibold mb-4 flex items-center">
                    <i class="fas fa-search mr-2"></i>
                    Pencarian & Filter
                </h3>
                
                <form method="GET" action="{{ route('psr.index') }}" class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div>
                            <label class="block text-sm font-medium mb-2">Pencarian</label>
                            <input type="text" 
                                   name="search" 
                                   value="{{ request('search') }}"
                                   placeholder="Cari cabang PSR, alamat..."
                                   class="w-full px-3 py-2 rounded-lg text-gray-900 placeholder-gray-500 focus:ring-2 focus:ring-white focus:ring-opacity-50">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium mb-2">Provinsi</label>
                            <select name="provinsi" class="w-full px-3 py-2 rounded-lg text-gray-900 focus:ring-2 focus:ring-white focus:ring-opacity-50">
                                <option value="">Semua Provinsi</option>
                                @foreach($provinsi as $prov)
                                    <option value="{{ $prov->kodedagri_prv }}" {{ request('provinsi') == $prov->kodedagri_prv ? 'selected' : '' }}>
                                        {{ $prov->namadagri_prv }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium mb-2">Kab/Kota</label>
                            <select name="kabkota" id="kabkota" class="w-full px-3 py-2 rounded-lg text-gray-900 focus:ring-2 focus:ring-white focus:ring-opacity-50">
                                <option value="">Semua Kab/Kota</option>
                                @foreach($kabkota as $kab)
                                    <option value="{{ $kab->kodedagri_kbk }}" 
                                            data-provinsi="{{ $kab->kodedagri_prv }}"
                                            {{ request('kabkota') == $kab->kodedagri_kbk ? 'selected' : '' }}>
                                        {{ $kab->namadagri_kbk }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="flex items-end">
                            <button type="submit" class="w-full bg-white text-purple-600 px-4 py-2 rounded-lg hover:bg-gray-100 transition-colors duration-200 font-medium">
                                <i class="fas fa-search mr-2"></i>
                                Cari
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Actions Section -->
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
                <div class="flex items-center space-x-2">
                    <span class="text-gray-600">Total: {{ $psr->total() }} data</span>
                </div>
                
                <div class="flex space-x-3">
                    <a href="{{ route('psr.export.csv', request()->query()) }}" 
                       class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg transition-colors duration-200">
                        <i class="fas fa-download mr-2"></i>
                        Export CSV
                    </a>
                    
                    <button id="bulkDeleteBtn" 
                            class="inline-flex items-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg transition-colors duration-200 disabled:opacity-50 disabled:cursor-not-allowed" 
                            disabled>
                        <i class="fas fa-trash mr-2"></i>
                        Hapus Terpilih (<span id="selectedCount">0</span>)
                    </button>
                </div>
            </div>

            <!-- Table Section -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50 border-b">
                            <tr>
                                <th class="px-6 py-4 text-left">
                                    <input type="checkbox" id="selectAll" class="rounded border-gray-300 text-orange-600 focus:ring-orange-500">
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID PSR</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cabang PSR</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Alamat</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kodepos</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kelurahan</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kecamatan</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Provinsi</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">GPS</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse($psr as $item)
                                <tr class="hover:bg-gray-50 transition-colors duration-200">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <input type="checkbox" name="selected_ids[]" value="{{ $item->id_psr }}" class="rounded border-gray-300 text-orange-600 focus:ring-orange-500">
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        {{ $item->id_psr }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-900">
                                        <div class="font-medium">{{ $item->cbg_psr }}</div>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-600">
                                        {{ Str::limit($item->alamat_psr, 50) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded-full text-xs font-medium">
                                            {{ $item->kodepos_kdp }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                        {{ $item->kel_kdp }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                        {{ $item->kec_kdp }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-600">
                                        {{ $item->namadagri_prv }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        @if($item->latitude_psr && $item->longitude_psr)
                                            <span class="inline-flex items-center bg-green-100 text-green-800 px-2 py-1 rounded-full text-xs font-medium">
                                                <i class="fas fa-map-marker-alt mr-1"></i>
                                                Ada
                                            </span>
                                        @else
                                            <span class="inline-flex items-center bg-gray-100 text-gray-800 px-2 py-1 rounded-full text-xs font-medium">
                                                <i class="fas fa-map-marker-alt mr-1"></i>
                                                Tidak
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex space-x-2">
                                            <a href="{{ route('psr.show', $item->id_psr) }}" 
                                               class="text-blue-600 hover:text-blue-800 transition-colors duration-200">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('psr.edit', $item->id_psr) }}" 
                                               class="text-orange-600 hover:text-orange-800 transition-colors duration-200">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('psr.destroy', $item->id_psr) }}" 
                                                  method="POST" 
                                                  class="inline"
                                                  onsubmit="return confirm('Apakah Anda yakin ingin menghapus data PSR {{ $item->cbg_psr }}?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-800 transition-colors duration-200">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="10" class="px-6 py-12 text-center">
                                        <div class="flex flex-col items-center">
                                            <i class="fas fa-building text-gray-400 text-4xl mb-4"></i>
                                            <h3 class="text-lg font-medium text-gray-900 mb-1">Tidak ada data PSR</h3>
                                            <p class="text-gray-600">Silakan tambah data PSR baru</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination -->
                @if($psr->hasPages())
                    <div class="px-6 py-4 border-t bg-gray-50">
                        {{ $psr->appends(request()->query())->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- JavaScript -->
    <script>
        // Select All functionality
        document.getElementById('selectAll').addEventListener('change', function() {
            const checkboxes = document.querySelectorAll('input[name="selected_ids[]"]');
            checkboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
            updateBulkDeleteButton();
        });

        // Individual checkbox change
        document.querySelectorAll('input[name="selected_ids[]"]').forEach(checkbox => {
            checkbox.addEventListener('change', updateBulkDeleteButton);
        });

        function updateBulkDeleteButton() {
            const selected = document.querySelectorAll('input[name="selected_ids[]"]:checked');
            const bulkDeleteBtn = document.getElementById('bulkDeleteBtn');
            const selectedCount = document.getElementById('selectedCount');
            
            selectedCount.textContent = selected.length;
            bulkDeleteBtn.disabled = selected.length === 0;
        }

        // Bulk delete functionality
        document.getElementById('bulkDeleteBtn').addEventListener('click', function() {
            const selected = document.querySelectorAll('input[name="selected_ids[]"]:checked');
            if (selected.length === 0) return;

            if (confirm(`Apakah Anda yakin ingin menghapus ${selected.length} data PSR yang dipilih?`)) {
                const ids = Array.from(selected).map(cb => cb.value);
                
                // Create form and submit
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = '{{ route("psr.bulk-delete") }}';
                
                const csrfToken = document.createElement('input');
                csrfToken.type = 'hidden';
                csrfToken.name = '_token';
                csrfToken.value = '{{ csrf_token() }}';
                form.appendChild(csrfToken);
                
                const methodField = document.createElement('input');
                methodField.type = 'hidden';
                methodField.name = '_method';
                methodField.value = 'DELETE';
                form.appendChild(methodField);
                
                ids.forEach(id => {
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'ids[]';
                    input.value = id;
                    form.appendChild(input);
                });
                
                document.body.appendChild(form);
                form.submit();
            }
        });

        // Filter kabkota based on provinsi
        document.querySelector('select[name="provinsi"]').addEventListener('change', function() {
            const selectedProvinsi = this.value;
            const kabkotaSelect = document.getElementById('kabkota');
            const kabkotaOptions = kabkotaSelect.querySelectorAll('option');
            
            kabkotaOptions.forEach(option => {
                if (option.value === '') {
                    option.style.display = 'block';
                } else {
                    const provinsiData = option.getAttribute('data-provinsi');
                    option.style.display = (selectedProvinsi === '' || provinsiData === selectedProvinsi) ? 'block' : 'none';
                }
            });
            
            // Reset kabkota selection
            kabkotaSelect.value = '';
        });


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