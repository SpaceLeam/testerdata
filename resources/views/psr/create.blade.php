<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah PSR Baru - Tendako</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50 min-h-screen">
    <div class="container mx-auto px-4 py-8">
        <!-- Header -->
        <div class="flex items-center justify-between mb-8">
            <div class="flex items-center">
                <div class="bg-orange-500 rounded-lg p-3 mr-4">
                    <i class="fas fa-shield-alt text-white text-xl"></i>
                </div>
                <div>
                    <h1 class="text-3xl font-bold text-gray-800">Tambah PSR Baru</h1>
                    <p class="text-gray-600">Data Damkar Pendataan - Form Disederhanakan</p>
                </div>
            </div>
            <a href="{{ route('psr.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded-lg transition-colors duration-200">
                <i class="fas fa-arrow-left mr-2"></i>
                Kembali
            </a>
        </div>

        <!-- Success/Error Messages -->
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6">
                <div class="flex items-center">
                    <i class="fas fa-check-circle mr-2"></i>
                    {{ session('success') }}
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-6">
                <div class="flex items-center">
                    <i class="fas fa-exclamation-circle mr-2"></i>
                    {{ session('error') }}
                </div>
            </div>
        @endif

        @if($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-6">
                <div class="font-bold mb-2">
                    <i class="fas fa-exclamation-circle mr-2"></i>
                    Terjadi kesalahan:
                </div>
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Form -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
            <div class="p-6 border-b border-gray-200">
                <h2 class="text-xl font-semibold text-gray-800">
                    <i class="fas fa-plus-circle mr-2 text-orange-500"></i>
                    Form Tambah PSR
                </h2>
                <p class="text-gray-600 mt-1">Pilih kodepos terlebih dahulu, provinsi dan kabkota akan otomatis terisi</p>
            </div>

            <form action="{{ route('psr.store') }}" method="POST" class="p-6">
                @csrf
                
                <div class="space-y-6">
                    <!-- Kodepos Selection -->
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                        <h3 class="text-lg font-medium text-blue-800 mb-3">
                            <i class="fas fa-map-marker-alt mr-2"></i>
                            Pilih Lokasi PSR
                        </h3>
                        
                        <!-- Search Kodepos -->
                        <div class="mb-4">
                            <label for="kodepos_search" class="block text-sm font-medium text-blue-700 mb-2">
                                <i class="fas fa-search mr-1"></i>
                                Cari Kodepos/Kelurahan/Kecamatan
                            </label>
                            <div class="relative">
                                <input type="text" 
                                       id="kodepos_search" 
                                       placeholder="Ketik kodepos, kelurahan, atau kecamatan..."
                                       class="w-full px-4 py-3 pl-10 border border-blue-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-search text-blue-400"></i>
                                </div>
                            </div>
                            <p class="text-xs text-blue-600 mt-1">Mulai ketik minimal 3 karakter untuk mencari</p>
                        </div>

                        <!-- Kodepos Dropdown -->
                        <div>
                            <label for="id_kdp" class="block text-sm font-medium text-blue-700 mb-2">
                                <i class="fas fa-mail-bulk mr-1"></i>
                                Kodepos <span class="text-red-500">*</span>
                            </label>
                            <select id="id_kdp" 
                                    name="id_kdp" 
                                    class="w-full px-4 py-3 border border-blue-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('id_kdp') border-red-500 @enderror"
                                    required>
                                <option value="">-- Pilih Kodepos --</option>
                                @foreach($kodepos as $kdp)
                                    <option value="{{ $kdp->id_kdp }}" 
                                            data-kodepos="{{ $kdp->kodepos_kdp }}"
                                            data-kelurahan="{{ $kdp->kel_kdp }}"
                                            data-kecamatan="{{ $kdp->kec_kdp }}"
                                            data-provinsi="{{ $kdp->namadagri_prv }}"
                                            data-kabkota="{{ $kdp->namadagri_kbk }}"
                                            {{ old('id_kdp') == $kdp->id_kdp ? 'selected' : '' }}>
                                        {{ $kdp->kodepos_kdp }} - {{ $kdp->kel_kdp }}, {{ $kdp->kec_kdp }}, {{ $kdp->namadagri_kbk }}, {{ $kdp->namadagri_prv }}
                                    </option>
                                @endforeach
                            </select>
                            @error('id_kdp')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Location Preview -->
                        <div id="location_preview" class="mt-4 p-3 bg-green-50 border border-green-200 rounded-lg hidden">
                            <h4 class="text-sm font-medium text-green-800 mb-2">
                                <i class="fas fa-check-circle mr-1"></i>
                                Lokasi Terpilih:
                            </h4>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-3 text-sm">
                                <div>
                                    <span class="text-green-600 font-medium">Kodepos:</span>
                                    <span id="preview_kodepos" class="block text-green-800"></span>
                                </div>
                                <div>
                                    <span class="text-green-600 font-medium">Kelurahan:</span>
                                    <span id="preview_kelurahan" class="block text-green-800"></span>
                                </div>
                                <div>
                                    <span class="text-green-600 font-medium">Kecamatan:</span>
                                    <span id="preview_kecamatan" class="block text-green-800"></span>
                                </div>
                                <div>
                                    <span class="text-green-600 font-medium">Kab/Kota:</span>
                                    <span id="preview_kabkota" class="block text-green-800"></span>
                                </div>
                                <div class="md:col-span-4">
                                    <span class="text-green-600 font-medium">Provinsi:</span>
                                    <span id="preview_provinsi" class="block text-green-800"></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Cabang PSR -->
                    <div>
                        <label for="cbg_psr" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-shield-alt mr-1 text-orange-500"></i>
                            Nama Cabang PSR <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               id="cbg_psr" 
                               name="cbg_psr" 
                               value="{{ old('cbg_psr') }}"
                               placeholder="Contoh: PSR Damkar Jakarta Selatan"
                               maxlength="100"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 @error('cbg_psr') border-red-500 @enderror"
                               required>
                        <p class="text-xs text-gray-500 mt-1">Maksimal 100 karakter</p>
                        @error('cbg_psr')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Alamat -->
                    <div>
                        <label for="alamat_psr" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-map-marker-alt mr-1 text-orange-500"></i>
                            Alamat Lengkap PSR <span class="text-red-500">*</span>
                        </label>
                        <textarea id="alamat_psr" 
                                  name="alamat_psr" 
                                  rows="4"
                                  maxlength="500"
                                  placeholder="Contoh: Jl. Raya Kampung Melayu No. 123, RT 01/RW 02, Lantai 2 Gedung Pemadam Kebakaran"
                                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 @error('alamat_psr') border-red-500 @enderror"
                                  required>{{ old('alamat_psr') }}</textarea>
                        <p class="text-xs text-gray-500 mt-1">
                            Maksimal 500 karakter - 
                            <span id="alamat_counter">0/500</span>
                        </p>
                        @error('alamat_psr')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- GPS Coordinates Section -->
                    <div class="border-t border-gray-200 pt-6">
                        <h3 class="text-lg font-medium text-gray-800 mb-4">
                            <i class="fas fa-satellite mr-2 text-orange-500"></i>
                            Koordinat GPS (Opsional)
                        </h3>
                        <p class="text-sm text-gray-600 mb-4">
                            Koordinat GPS akan membantu dalam pemetaan lokasi PSR. Kosongkan jika tidak tersedia.
                        </p>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Latitude -->
                            <div>
                                <label for="latitude_psr" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-compass mr-1 text-orange-500"></i>
                                    Latitude (Lintang)
                                </label>
                                <input type="number" 
                                       step="any" 
                                       id="latitude_psr" 
                                       name="latitude_psr" 
                                       value="{{ old('latitude_psr') }}"
                                       placeholder="Contoh: -6.200000"
                                       min="-90"
                                       max="90"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 @error('latitude_psr') border-red-500 @enderror">
                                <p class="text-xs text-gray-500 mt-1">Range: -90 sampai 90 (Desimal)</p>
                                @error('latitude_psr')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Longitude -->
                            <div>
                                <label for="longitude_psr" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-compass mr-1 text-orange-500"></i>
                                    Longitude (Bujur)
                                </label>
                                <input type="number" 
                                       step="any" 
                                       id="longitude_psr" 
                                       name="longitude_psr" 
                                       value="{{ old('longitude_psr') }}"
                                       placeholder="Contoh: 106.816666"
                                       min="-180"
                                       max="180"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 @error('longitude_psr') border-red-500 @enderror">
                                <p class="text-xs text-gray-500 mt-1">Range: -180 sampai 180 (Desimal)</p>
                                @error('longitude_psr')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- GPS Help -->
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mt-4">
                            <h4 class="text-sm font-medium text-blue-800 mb-2">
                                <i class="fas fa-info-circle mr-1"></i>
                                Cara Mendapatkan Koordinat GPS:
                            </h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-blue-700">
                                <ul class="space-y-1">
                                    <li>• <strong>Google Maps:</strong> Klik kanan pada lokasi, pilih koordinat yang muncul</li>
                                    <li>• <strong>Smartphone:</strong> Gunakan aplikasi GPS atau Maps bawaan</li>
                                    <li>• <strong>GPS Device:</strong> Gunakan alat GPS receiver manual</li>
                                </ul>
                                <ul class="space-y-1">
                                    <li>• <strong>Survey Lapangan:</strong> Datang langsung ke lokasi PSR</li>
                                    <li>• <strong>Format:</strong> Gunakan format desimal (contoh: -6.200000)</li>
                                    <li>• <strong>Akurasi:</strong> Semakin detail koordinat, semakin akurat pemetaan</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="flex items-center justify-between pt-6 border-t border-gray-200 mt-8">
                    <div class="text-sm text-gray-500">
                        <i class="fas fa-info-circle mr-1"></i>
                        <span class="text-red-500">*</span> Field wajib diisi
                    </div>
                    <div class="flex space-x-3">
                        <a href="{{ route('psr.index') }}" 
                           class="inline-flex items-center px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors duration-200">
                            <i class="fas fa-times mr-2"></i>
                            Batal
                        </a>
                        <button type="submit" 
                                class="inline-flex items-center px-6 py-3 bg-orange-500 hover:bg-orange-600 text-white rounded-lg transition-colors duration-200">
                            <i class="fas fa-save mr-2"></i>
                            Simpan PSR
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Quick Stats -->
        <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
                <div class="flex items-center">
                    <div class="bg-blue-100 rounded-lg p-2 mr-3">
                        <i class="fas fa-map-marker-alt text-blue-600"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Total Kodepos Tersedia</p>
                        <p class="text-lg font-semibold text-gray-800">{{ number_format(count($kodepos)) }}</p>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
                <div class="flex items-center">
                    <div class="bg-green-100 rounded-lg p-2 mr-3">
                        <i class="fas fa-shield-alt text-green-600"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Form Disederhanakan</p>
                        <p class="text-lg font-semibold text-gray-800">3 Field Utama</p>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
                <div class="flex items-center">
                    <div class="bg-orange-100 rounded-lg p-2 mr-3">
                        <i class="fas fa-satellite text-orange-600"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">GPS Coordinate</p>
                        <p class="text-lg font-semibold text-gray-800">Optional</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript for Enhanced UX -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const kodeposSearch = document.getElementById('kodepos_search');
            const kodeposSelect = document.getElementById('id_kdp');
            const locationPreview = document.getElementById('location_preview');
            const alamatTextarea = document.getElementById('alamat_psr');
            const alamatCounter = document.getElementById('alamat_counter');
            const form = document.querySelector('form');

            // Store original options for filtering
            const originalOptions = Array.from(kodeposSelect.options).slice(1); // Exclude first empty option

            // Character counter for alamat
            function updateAlamatCounter() {
                const currentLength = alamatTextarea.value.length;
                alamatCounter.textContent = `${currentLength}/500`;
                
                if (currentLength > 450) {
                    alamatCounter.classList.add('text-orange-600');
                } else if (currentLength > 400) {
                    alamatCounter.classList.add('text-yellow-600');
                } else {
                    alamatCounter.classList.remove('text-orange-600', 'text-yellow-600');
                }
            }

            alamatTextarea.addEventListener('input', updateAlamatCounter);
            updateAlamatCounter(); // Initial call

            // Kodepos search functionality
            kodeposSearch.addEventListener('input', function() {
                const searchTerm = this.value.toLowerCase().trim();
                
                // Clear current options except the first empty one
                kodeposSelect.innerHTML = '<option value="">-- Pilih Kodepos --</option>';
                
                if (searchTerm.length < 3) {
                    // Show all options if search term is too short
                    originalOptions.forEach(option => {
                        kodeposSelect.appendChild(option.cloneNode(true));
                    });
                    return;
                }

                // Filter and add matching options
                const filteredOptions = originalOptions.filter(option => {
                    const optionText = option.textContent.toLowerCase();
                    return optionText.includes(searchTerm);
                });

                if (filteredOptions.length === 0) {
                    const noResultOption = document.createElement('option');
                    noResultOption.value = '';
                    noResultOption.textContent = 'Tidak ada hasil yang cocok';
                    noResultOption.disabled = true;
                    kodeposSelect.appendChild(noResultOption);
                } else {
                    filteredOptions.forEach(option => {
                        kodeposSelect.appendChild(option.cloneNode(true));
                    });
                }
            });

            // Location preview functionality
            kodeposSelect.addEventListener('change', function() {
                if (this.value) {
                    const selectedOption = this.options[this.selectedIndex];
                    
                    document.getElementById('preview_kodepos').textContent = selectedOption.dataset.kodepos || '';
                    document.getElementById('preview_kelurahan').textContent = selectedOption.dataset.kelurahan || '';
                    document.getElementById('preview_kecamatan').textContent = selectedOption.dataset.kecamatan || '';
                    document.getElementById('preview_kabkota').textContent = selectedOption.dataset.kabkota || '';
                    document.getElementById('preview_provinsi').textContent = selectedOption.dataset.provinsi || '';
                    
                    locationPreview.classList.remove('hidden');
                    
                    // Auto-fill cabang PSR if empty
                    const cbgPsrInput = document.getElementById('cbg_psr');
                    if (!cbgPsrInput.value.trim()) {
                        const kelurahan = selectedOption.dataset.kelurahan || '';
                        const kecamatan = selectedOption.dataset.kecamatan || '';
                        if (kelurahan && kecamatan) {
                            cbgPsrInput.value = `PSR Damkar ${kelurahan} - ${kecamatan}`;
                        }
                    }
                } else {
                    locationPreview.classList.add('hidden');
                }
            });

            // Form validation enhancement
            form.addEventListener('submit', function(e) {
                let isValid = true;
                const requiredFields = form.querySelectorAll('[required]');
                
                // Remove previous error styling
                document.querySelectorAll('.border-red-500').forEach(el => {
                    el.classList.remove('border-red-500');
                });

                // Validate required fields
                requiredFields.forEach(field => {
                    if (!field.value.trim()) {
                        isValid = false;
                        field.classList.add('border-red-500');
                        
                        // Focus first invalid field
                        if (isValid === false) {
                            field.focus();
                        }
                    }
                });

                // Validate GPS coordinates if provided
                const latitude = document.getElementById('latitude_psr');
                const longitude = document.getElementById('longitude_psr');
                
                if (latitude.value && (parseFloat(latitude.value) < -90 || parseFloat(latitude.value) > 90)) {
                    isValid = false;
                    latitude.classList.add('border-red-500');
                    if (!document.querySelector('.border-red-500:focus')) {
                        latitude.focus();
                    }
                }
                
                if (longitude.value && (parseFloat(longitude.value) < -180 || parseFloat(longitude.value) > 180)) {
                    isValid = false;
                    longitude.classList.add('border-red-500');
                    if (!document.querySelector('.border-red-500:focus')) {
                        longitude.focus();
                    }
                }

                // Validate cabang PSR length
                const cbgPsr = document.getElementById('cbg_psr');
                if (cbgPsr.value.trim().length > 100) {
                    isValid = false;
                    cbgPsr.classList.add('border-red-500');
                    if (!document.querySelector('.border-red-500:focus')) {
                        cbgPsr.focus();
                    }
                }

                // Validate alamat length
                if (alamatTextarea.value.trim().length > 500) {
                    isValid = false;
                    alamatTextarea.classList.add('border-red-500');
                    if (!document.querySelector('.border-red-500:focus')) {
                        alamatTextarea.focus();
                    }
                }

                if (!isValid) {
                    e.preventDefault();
                    
                    // Show error message
                    const errorDiv = document.createElement('div');
                    errorDiv.className = 'bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-6';
                    errorDiv.innerHTML = `
                        <div class="flex items-center">
                            <i class="fas fa-exclamation-circle mr-2"></i>
                            Mohon periksa kembali form yang telah diisi. Ada beberapa field yang belum valid.
                        </div>
                    `;
                    
                    // Remove existing error messages
                    const existingError = document.querySelector('.bg-red-100');
                    if (existingError && existingError.textContent.includes('Mohon periksa kembali')) {
                        existingError.remove();
                    }
                    
                    // Insert error message before form
                    form.parentNode.insertBefore(errorDiv, form);
                    
                    // Auto remove error after 5 seconds
                    setTimeout(() => {
                        if (errorDiv.parentNode) {
                            errorDiv.remove();
                        }
                    }, 5000);
                    
                    // Scroll to first error
                    const firstError = document.querySelector('.border-red-500');
                    if (firstError) {
                        firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    }
                }
            });

            // Real-time validation for GPS coordinates
            const latitudeInput = document.getElementById('latitude_psr');
            const longitudeInput = document.getElementById('longitude_psr');

            latitudeInput.addEventListener('input', function() {
                const value = parseFloat(this.value);
                if (this.value && (value < -90 || value > 90)) {
                    this.classList.add('border-red-500');
                } else {
                    this.classList.remove('border-red-500');
                }
            });

            longitudeInput.addEventListener('input', function() {
                const value = parseFloat(this.value);
                if (this.value && (value < -180 || value > 180)) {
                    this.classList.add('border-red-500');
                } else {
                    this.classList.remove('border-red-500');
                }
            });

            // Initialize form if there are old values (after validation error)
            if (kodeposSelect.value) {
                kodeposSelect.dispatchEvent(new Event('change'));
            }

            // Auto-save draft functionality (optional enhancement)
            let draftTimer;
            const draftableFields = [kodeposSelect, document.getElementById('cbg_psr'), alamatTextarea];
            
            draftableFields.forEach(field => {
                field.addEventListener('input', function() {
                    clearTimeout(draftTimer);
                    draftTimer = setTimeout(() => {
                        // Save draft to localStorage (if needed)
                        const draftData = {
                            id_kdp: kodeposSelect.value,
                            cbg_psr: document.getElementById('cbg_psr').value,
                            alamat_psr: alamatTextarea.value,
                            timestamp: new Date().toISOString()
                        };
                        // localStorage.setItem('psr_draft', JSON.stringify(draftData));
                    }, 2000);
                });
            });
        });
    </script>
</body>
</html>