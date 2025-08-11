<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Kode Pos - Tendako</title>
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
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <!-- Page Header -->
            <div class="mb-8">
                <div class="flex items-center space-x-4 mb-4">
                    <a href="{{ route('kodepos.index') }}" class="inline-flex items-center text-orange-600 hover:text-orange-700 font-medium">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Kembali
                    </a>
                    <span class="text-gray-400">|</span>
                    <a href="{{ route('kodepos.show', $kodepos->id_kdp) }}" class="inline-flex items-center text-blue-600 hover:text-blue-700 font-medium">
                        <i class="fas fa-eye mr-2"></i>
                        Lihat Detail
                    </a>
                </div>
                <div>
                    <h2 class="text-3xl font-bold text-gray-900 mb-2">Edit Kode Pos</h2>
                    <p class="text-gray-600">Perbarui data kode pos yang sudah ada</p>
                </div>
            </div>

            <!-- Error Messages -->
            @if($errors->any())
                <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg" role="alert">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-exclamation-circle text-red-500"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium mb-2">Terdapat kesalahan dalam input:</p>
                            <ul class="list-disc list-inside text-sm space-y-1">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg" role="alert">
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

            <!-- Form -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">Edit Informasi Kode Pos</h3>
                    <p class="text-sm text-gray-600 mt-1">ID: {{ $kodepos->id_kdp }}</p>
                </div>
                
                <form action="{{ route('kodepos.update', $kodepos->id_kdp) }}" method="POST" class="p-6">
                    @csrf
                    @method('PUT')
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Kode Pos -->
                        <div class="md:col-span-1">
                            <label for="kodepos_kdp" class="block text-sm font-medium text-gray-700 mb-2">
                                Kode Pos <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="kodepos_kdp" name="kodepos_kdp" 
                                   value="{{ old('kodepos_kdp', $kodepos->kodepos_kdp) }}" 
                                   placeholder="Contoh: 12345"
                                   class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-orange-500 focus:border-orange-500 @error('kodepos_kdp') border-red-300 @enderror"
                                   maxlength="10" required>
                            @error('kodepos_kdp')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Current Values Display -->
                        <div class="md:col-span-1">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Kode Pos Saat Ini</label>
                            <div class="bg-gray-100 px-3 py-2 rounded-lg border border-gray-200">
                                <span class="text-orange-600 font-semibold">{{ $kodepos->kodepos_kdp }}</span>
                            </div>
                        </div>

                        <!-- Kelurahan -->
                        <div class="md:col-span-1">
                            <label for="kel_kdp" class="block text-sm font-medium text-gray-700 mb-2">
                                Kelurahan/Desa <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="kel_kdp" name="kel_kdp" 
                                   value="{{ old('kel_kdp', $kodepos->kel_kdp) }}" 
                                   placeholder="Contoh: Kebayoran Baru"
                                   class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-orange-500 focus:border-orange-500 @error('kel_kdp') border-red-300 @enderror"
                                   maxlength="100" required>
                            @error('kel_kdp')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Current Kelurahan -->
                        <div class="md:col-span-1">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Kelurahan Saat Ini</label>
                            <div class="bg-gray-100 px-3 py-2 rounded-lg border border-gray-200">
                                <span class="text-gray-900">{{ $kodepos->kel_kdp }}</span>
                            </div>
                        </div>

                        <!-- Kecamatan -->
                        <div class="md:col-span-2">
                            <label for="kec_kdp" class="block text-sm font-medium text-gray-700 mb-2">
                                Kecamatan <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="kec_kdp" name="kec_kdp" 
                                   value="{{ old('kec_kdp', $kodepos->kec_kdp) }}" 
                                   placeholder="Contoh: Kebayoran Baru"
                                   class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-orange-500 focus:border-orange-500 @error('kec_kdp') border-red-300 @enderror"
                                   maxlength="100" required>
                            @error('kec_kdp')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-xs text-gray-500">Kecamatan saat ini: {{ $kodepos->kec_kdp }}</p>
                        </div>

                        <!-- Provinsi -->
                        <div class="md:col-span-1">
                            <label for="kodedagri_prv" class="block text-sm font-medium text-gray-700 mb-2">
                                Provinsi <span class="text-red-500">*</span>
                            </label>
                            <select id="kodedagri_prv" name="kodedagri_prv" 
                                    class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-orange-500 focus:border-orange-500 @error('kodedagri_prv') border-red-300 @enderror"
                                    required onchange="filterKabkota()">
                                <option value="">Pilih Provinsi</option>
                                @foreach($provinsi as $prov)
                                    <option value="{{ $prov->kodedagri_prv }}" 
                                            {{ old('kodedagri_prv', $kodepos->kodedagri_prv) == $prov->kodedagri_prv ? 'selected' : '' }}>
                                        {{ $prov->namadagri_prv }}
                                    </option>
                                @endforeach
                            </select>
                            @error('kodedagri_prv')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Kabupaten/Kota -->
                        <div class="md:col-span-1">
                            <label for="kodedagri_kbk" class="block text-sm font-medium text-gray-700 mb-2">
                                Kabupaten/Kota <span class="text-red-500">*</span>
                            </label>
                            <select id="kodedagri_kbk" name="kodedagri_kbk" 
                                    class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-orange-500 focus:border-orange-500 @error('kodedagri_kbk') border-red-300 @enderror"
                                    required>
                                <option value="">Pilih Kabupaten/Kota</option>
                                @foreach($kabkota as $kab)
                                    <option value="{{ $kab->kodedagri_kbk }}" 
                                            data-provinsi="{{ $kab->kodedagri_prv }}"
                                            {{ old('kodedagri_kbk', $kodepos->kodedagri_kbk) == $kab->kodedagri_kbk ? 'selected' : '' }}>
                                        {{ $kab->namadagri_kbk }}
                                    </option>
                                @endforeach
                            </select>
                            @error('kodedagri_kbk')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Change Summary -->
                    <div class="mt-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                        <h4 class="text-sm font-medium text-blue-800 mb-2">
                            <i class="fas fa-info-circle mr-1"></i>
                            Ringkasan Perubahan
                        </h4>
                        <div class="text-sm text-blue-700">
                            Data yang akan diperbarui akan langsung tersimpan ke database. Pastikan semua informasi sudah benar sebelum menyimpan.
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="flex justify-end space-x-3 mt-8 pt-6 border-t border-gray-200">
                        <a href="{{ route('kodepos.show', $kodepos->id_kdp) }}" 
                           class="inline-flex items-center px-4 py-2 border border-gray-300 text-gray-700 bg-white hover:bg-gray-50 rounded-lg font-medium transition-colors">
                            <i class="fas fa-times mr-2"></i>
                            Batal
                        </a>
                        <button type="submit" 
                                class="inline-flex items-center px-4 py-2 bg-orange-500 text-white hover:bg-orange-600 rounded-lg font-medium transition-colors">
                            <i class="fas fa-save mr-2"></i>
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Filter kabkota berdasarkan provinsi yang dipilih
        function filterKabkota() {
            const provinsiSelect = document.getElementById('kodedagri_prv');
            const kabkotaSelect = document.getElementById('kodedagri_kbk');
            const selectedProvinsi = provinsiSelect.value;
            
            // Simpan current selection
            const currentKabkota = kabkotaSelect.value;
            
            // Hide/show kabkota options based on selected provinsi
            const kabkotaOptions = kabkotaSelect.querySelectorAll('option[data-provinsi]');
            let shouldResetSelection = true;
            
            kabkotaOptions.forEach(option => {
                if (!selectedProvinsi || option.dataset.provinsi === selectedProvinsi) {
                    option.style.display = 'block';
                    // Check if current selection is still valid
                    if (option.value === currentKabkota) {
                        shouldResetSelection = false;
                    }
                } else {
                    option.style.display = 'none';
                }
            });
            
            // Reset kabkota selection only if current selection is not valid for selected provinsi
            if (shouldResetSelection && selectedProvinsi) {
                kabkotaSelect.value = '';
            }
        }

        // Initialize filtering on page load
        document.addEventListener('DOMContentLoaded', function() {
            filterKabkota();
        });
    </script>
</body>
</html>