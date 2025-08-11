<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit PSR - Data Damkar Pendataan</title>
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
                        <div class="flex-shrink-0 bg-primary text-white p-2 rounded-lg">
                            <i class="fas fa-shield-alt text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <h1 class="text-xl font-semibold text-gray-900">Edit PSR</h1>
                            <p class="text-sm text-gray-500">Data Damkar Pendataan - Form Disederhanakan</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-4">
                        <a href="{{ route('psr.index') }}" 
                           class="inline-flex items-center px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-800 text-sm font-medium rounded-lg transition-colors">
                            <i class="fas fa-arrow-left mr-2"></i>
                            Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="max-w-4xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
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
            @if($errors->any())
            <div class="mb-6 bg-red-50 border border-red-200 rounded-lg p-4">
                <div class="flex items-start">
                    <i class="fas fa-exclamation-circle text-red-400 mr-3 mt-0.5"></i>
                    <div>
                        <h3 class="text-red-800 font-medium mb-2">Terjadi kesalahan:</h3>
                        <ul class="text-red-700 text-sm space-y-1">
                            @foreach($errors->all() as $error)
                            <li>• {{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            @endif

            <!-- Form Card -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                <!-- Form Header -->
                <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-primary to-secondary rounded-t-xl">
                    <div class="flex items-center text-white">
                        <i class="fas fa-edit text-xl mr-3"></i>
                        <h2 class="text-lg font-semibold">Form Edit PSR</h2>
                    </div>
                    <p class="text-orange-100 text-sm mt-1">Pilih kodepos terlebih dahulu, provinsi dan kabkota akan otomatis terisi</p>
                </div>

                <form action="{{ route('psr.update', $psr->id_psr) }}" method="POST" class="p-6">
                    @csrf
                    @method('PUT')

                    <!-- Location Selection -->
                    <div class="mb-8">
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                            <div class="flex items-start">
                                <i class="fas fa-map-marker-alt text-blue-500 mr-3 mt-1"></i>
                                <div>
                                    <h3 class="text-blue-800 font-medium mb-1">Pilih Lokasi PSR</h3>
                                    <p class="text-blue-600 text-sm">Cari Kodepos/Kelurahan/Kecamatan</p>
                                </div>
                            </div>
                        </div>

                        <!-- Search Input -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-search mr-1"></i>
                                Cari Kodepos/Kelurahan/Kecamatan
                            </label>
                            <input type="text" 
                                   id="search-location" 
                                   placeholder="Ketik kodepos, kelurahan, atau kecamatan..."
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent transition-all">
                            <p class="text-xs text-gray-500 mt-1">Mulai ketik minimal 3 karakter untuk mencari</p>
                        </div>

                        <!-- Kodepos Dropdown -->
                        <div class="mb-4">
                            <label for="id_kdp" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-building mr-1"></i>
                                Kodepos <span class="text-red-500">*</span>
                            </label>
                            <select name="id_kdp" 
                                    id="id_kdp" 
                                    required 
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent transition-all @error('id_kdp') border-red-500 @enderror">
                                <option value="">-- Pilih Kodepos --</option>
                                @foreach($kodepos as $item)
                                <option value="{{ $item->id_kdp }}" 
                                        data-kodepos="{{ $item->kodepos_kdp }}"
                                        data-kelurahan="{{ $item->kel_kdp }}"
                                        data-kecamatan="{{ $item->kec_kdp }}"
                                        data-provinsi="{{ $item->namadagri_prv }}"
                                        data-kabkota="{{ $item->namadagri_kbk }}"
                                        {{ $psr->id_kdp == $item->id_kdp ? 'selected' : '' }}>
                                    {{ $item->kodepos_kdp }} - {{ $item->kel_kdp }}, {{ $item->kec_kdp }}, {{ $item->namadagri_kbk }}, {{ $item->namadagri_prv }}
                                </option>
                                @endforeach
                            </select>
                            @error('id_kdp')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Location Info Display -->
                        <div id="location-info" class="bg-gray-50 border border-gray-200 rounded-lg p-4 {{ $psr->id_kdp ? '' : 'hidden' }}">
                            <h4 class="text-sm font-medium text-gray-700 mb-3">
                                <i class="fas fa-check-circle text-green-500 mr-2"></i>
                                Lokasi Terpilih:
                            </h4>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                                <div>
                                    <span class="text-gray-500">Kodepos:</span>
                                    <div id="display-kodepos" class="font-medium text-gray-900">{{ $psr->kodepos_kdp ?? '-' }}</div>
                                </div>
                                <div>
                                    <span class="text-gray-500">Kelurahan:</span>
                                    <div id="display-kelurahan" class="font-medium text-gray-900">{{ $psr->kel_kdp ?? '-' }}</div>
                                </div>
                                <div>
                                    <span class="text-gray-500">Kecamatan:</span>
                                    <div id="display-kecamatan" class="font-medium text-gray-900">{{ $psr->kec_kdp ?? '-' }}</div>
                                </div>
                                <div class="md:col-span-1 col-span-2">
                                    <span class="text-gray-500">Kab/Kota:</span>
                                    <div id="display-kabkota" class="font-medium text-gray-900">{{ $psr->namadagri_kbk ?? '-' }}</div>
                                </div>
                                <div class="col-span-2 md:col-span-4">
                                    <span class="text-gray-500">Provinsi:</span>
                                    <div id="display-provinsi" class="font-medium text-gray-900">{{ $psr->namadagri_prv ?? '-' }}</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- PSR Information -->
                    <div class="space-y-6">
                        <!-- Nama Cabang PSR -->
                        <div>
                            <label for="cbg_psr" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-fire-extinguisher text-primary mr-1"></i>
                                Nama Cabang PSR <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   name="cbg_psr" 
                                   id="cbg_psr" 
                                   value="{{ old('cbg_psr', $psr->cbg_psr) }}"
                                   maxlength="100"
                                   required 
                                   placeholder="Contoh: PSR Damkar Jakarta Selatan"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent transition-all @error('cbg_psr') border-red-500 @enderror">
                            <p class="text-xs text-gray-500 mt-1">Maksimal 100 karakter</p>
                            @error('cbg_psr')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Alamat Lengkap PSR -->
                        <div>
                            <label for="alamat_psr" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-map-marked-alt text-primary mr-1"></i>
                                Alamat Lengkap PSR <span class="text-red-500">*</span>
                            </label>
                            <textarea name="alamat_psr" 
                                      id="alamat_psr" 
                                      rows="4" 
                                      required 
                                      placeholder="Contoh: Jl. Raya Kampung Melayu No. 123, RT 01/RW 02, Lantai 2 Gedung Pemadam Kebakaran"
                                      class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent transition-all resize-none @error('alamat_psr') border-red-500 @enderror">{{ old('alamat_psr', $psr->alamat_psr) }}</textarea>
                            @error('alamat_psr')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Coordinates (Optional) -->
                        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                            <h3 class="text-yellow-800 font-medium mb-3 flex items-center">
                                <i class="fas fa-map-pin mr-2"></i>
                                Koordinat GPS (Opsional)
                            </h3>
                            <p class="text-yellow-700 text-sm mb-4">Koordinat akan membantu dalam pemetaan lokasi PSR</p>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="latitude_psr" class="block text-sm font-medium text-gray-700 mb-2">
                                        Latitude
                                    </label>
                                    <input type="number" 
                                           name="latitude_psr" 
                                           id="latitude_psr" 
                                           value="{{ old('latitude_psr', $psr->latitude_psr) }}"
                                           step="0.000001" 
                                           min="-90" 
                                           max="90" 
                                           placeholder="-6.175392"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent transition-all @error('latitude_psr') border-red-500 @enderror">
                                    @error('latitude_psr')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="longitude_psr" class="block text-sm font-medium text-gray-700 mb-2">
                                        Longitude
                                    </label>
                                    <input type="number" 
                                           name="longitude_psr" 
                                           id="longitude_psr" 
                                           value="{{ old('longitude_psr', $psr->longitude_psr) }}"
                                           step="0.000001" 
                                           min="-180" 
                                           max="180" 
                                           placeholder="106.827153"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent transition-all @error('longitude_psr') border-red-500 @enderror">
                                    @error('longitude_psr')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="mt-3 flex items-center justify-between">
                                <p class="text-xs text-yellow-700">
                                    <i class="fas fa-info-circle mr-1"></i>
                                    Format: Latitude (-90 sampai 90), Longitude (-180 sampai 180)
                                </p>
                                <button type="button" 
                                        onclick="getCurrentLocation()" 
                                        class="text-xs bg-yellow-100 hover:bg-yellow-200 text-yellow-800 px-3 py-1 rounded-full transition-colors">
                                    <i class="fas fa-location-arrow mr-1"></i>
                                    Ambil Lokasi Saat Ini
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex flex-col sm:flex-row gap-4 pt-8 border-t border-gray-200">
                        <button type="submit" 
                                class="flex-1 sm:flex-none bg-gradient-to-r from-primary to-secondary hover:from-primary-600 hover:to-secondary-600 text-white font-medium py-3 px-8 rounded-lg transition-all duration-200 transform hover:scale-105 shadow-lg hover:shadow-xl">
                            <i class="fas fa-save mr-2"></i>
                            Update Data PSR
                        </button>
                        
                        <a href="{{ route('psr.index') }}" 
                           class="flex-1 sm:flex-none bg-gray-100 hover:bg-gray-200 text-gray-800 font-medium py-3 px-8 rounded-lg transition-colors text-center">
                            <i class="fas fa-times mr-2"></i>
                            Batal
                        </a>
                        
                        <a href="{{ route('psr.show', $psr->id_psr) }}" 
                           class="flex-1 sm:flex-none bg-blue-100 hover:bg-blue-200 text-blue-800 font-medium py-3 px-8 rounded-lg transition-colors text-center">
                            <i class="fas fa-eye mr-2"></i>
                            Lihat Detail
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Search functionality
        document.getElementById('search-location').addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const select = document.getElementById('id_kdp');
            const options = select.querySelectorAll('option');
            
            if (searchTerm.length < 3 && searchTerm.length > 0) {
                return;
            }
            
            options.forEach(option => {
                if (option.value === '') return;
                
                const text = option.textContent.toLowerCase();
                if (searchTerm === '' || text.includes(searchTerm)) {
                    option.style.display = '';
                } else {
                    option.style.display = 'none';
                }
            });
        });

        // Location info update
        document.getElementById('id_kdp').addEventListener('change', function() {
            const selectedOption = this.selectedOptions[0];
            const locationInfo = document.getElementById('location-info');
            
            if (this.value) {
                // Update display
                document.getElementById('display-kodepos').textContent = selectedOption.dataset.kodepos || '-';
                document.getElementById('display-kelurahan').textContent = selectedOption.dataset.kelurahan || '-';
                document.getElementById('display-kecamatan').textContent = selectedOption.dataset.kecamatan || '-';
                document.getElementById('display-kabkota').textContent = selectedOption.dataset.kabkota || '-';
                document.getElementById('display-provinsi').textContent = selectedOption.dataset.provinsi || '-';
                
                // Show location info
                locationInfo.classList.remove('hidden');
            } else {
                // Hide location info
                locationInfo.classList.add('hidden');
            }
        });

        // Get current location
        function getCurrentLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    document.getElementById('latitude_psr').value = position.coords.latitude.toFixed(6);
                    document.getElementById('longitude_psr').value = position.coords.longitude.toFixed(6);
                    
                    // Show success message
                    alert('Koordinat berhasil diambil!');
                }, function(error) {
                    alert('Gagal mengambil lokasi: ' + error.message);
                });
            } else {
                alert('Browser tidak mendukung geolocation');
            }
        }

        // Character counter for cbg_psr
        document.getElementById('cbg_psr').addEventListener('input', function() {
            const maxLength = 100;
            const currentLength = this.value.length;
            const label = this.previousElementSibling.querySelector('span');
            
            if (currentLength > maxLength * 0.8) {
                this.style.borderColor = currentLength >= maxLength ? '#ef4444' : '#f59e0b';
            } else {
                this.style.borderColor = '#d1d5db';
            }
        });

        // Initialize location info on page load
        document.addEventListener('DOMContentLoaded', function() {
            const select = document.getElementById('id_kdp');
            if (select.value) {
                select.dispatchEvent(new Event('change'));
            }
        });
    </script>
</body>
</html>