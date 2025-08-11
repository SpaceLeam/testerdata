<!DOCTYPE html>
<html lang="id" class="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Kabupaten/Kota - Tendako</title>
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
                        'warm-gray': '#f9fafb'
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
                    <h2 class="text-2xl font-semibold text-gray-800 mb-2">Edit Kabupaten/Kota</h2>
                    <p class="text-gray-600">Ubah data kabupaten/kota yang ada dalam sistem</p>
                </div>
                <div class="flex items-center space-x-3">
                    <a href="{{ route('kabkota.index') }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:ring-4 focus:ring-gray-100 transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Kembali
                    </a>
                </div>
            </div>
        </div>

        <!-- Alerts -->
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

        @if(session('error'))
        <div class="mb-6 p-4 text-sm text-soft-red bg-red-50 border border-red-200 rounded-lg">
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                </svg>
                {{ session('error') }}
            </div>
        </div>
        @endif

        @if ($errors->any())
        <div class="mb-6 p-4 text-sm text-soft-red bg-red-50 border border-red-200 rounded-lg">
            <div class="flex items-start">
                <svg class="w-5 h-5 mr-2 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                </svg>
                <div>
                    <div class="font-medium mb-2">Terdapat kesalahan validasi:</div>
                    <ul class="list-disc list-inside space-y-1">
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        @endif

        <!-- Edit Form -->
        <div class="bg-white shadow-sm border border-gray-200 rounded-xl p-6">
            <form method="POST" action="{{ route('kabkota.update', $kabkota->kodedagri_kbk) }}" class="space-y-6">
                @csrf
                @method('PUT')
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Kode Dagri Kabkota -->
                    <div>
                        <label for="kodedagri_kbk" class="block mb-2 text-sm font-medium text-gray-700">
                            Kode Dagri Kabupaten/Kota <span class="text-soft-red">*</span>
                        </label>
                        <input type="number" 
                               id="kodedagri_kbk" 
                               name="kodedagri_kbk" 
                               value="{{ old('kodedagri_kbk', $kabkota->kodedagri_kbk) }}"
                               class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-soft-blue focus:border-soft-blue block w-full p-3 @error('kodedagri_kbk') border-soft-red @enderror"
                               placeholder="Masukkan kode dagri..."
                               required>
                        @error('kodedagri_kbk')
                        <p class="mt-2 text-sm text-soft-red">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Provinsi -->
                    <div>
                        <label for="kodedagri_prv" class="block mb-2 text-sm font-medium text-gray-700">
                            Provinsi <span class="text-soft-red">*</span>
                        </label>
                        <select id="kodedagri_prv" 
                                name="kodedagri_prv" 
                                class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-soft-blue focus:border-soft-blue block w-full p-3 @error('kodedagri_prv') border-soft-red @enderror"
                                required>
                            <option value="">Pilih Provinsi...</option>
                            @foreach($provinsi as $prov)
                            <option value="{{ $prov->kodedagri_prv }}" 
                                    {{ old('kodedagri_prv', $kabkota->kodedagri_prv) == $prov->kodedagri_prv ? 'selected' : '' }}>
                                {{ $prov->namadagri_prv }}
                            </option>
                            @endforeach
                        </select>
                        @error('kodedagri_prv')
                        <p class="mt-2 text-sm text-soft-red">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Nama Dagri -->
                    <div>
                        <label for="namadagri_kbk" class="block mb-2 text-sm font-medium text-gray-700">
                            Nama Dagri <span class="text-soft-red">*</span>
                        </label>
                        <input type="text" 
                               id="namadagri_kbk" 
                               name="namadagri_kbk" 
                               value="{{ old('namadagri_kbk', $kabkota->namadagri_kbk) }}"
                               class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-soft-blue focus:border-soft-blue block w-full p-3 @error('namadagri_kbk') border-soft-red @enderror"
                               placeholder="Masukkan nama dagri..."
                               maxlength="100"
                               required>
                        @error('namadagri_kbk')
                        <p class="mt-2 text-sm text-soft-red">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Kode BPS -->
                    <div>
                        <label for="kodebps_kbk" class="block mb-2 text-sm font-medium text-gray-700">
                            Kode BPS <span class="text-soft-red">*</span>
                        </label>
                        <input type="number" 
                               id="kodebps_kbk" 
                               name="kodebps_kbk" 
                               value="{{ old('kodebps_kbk', $kabkota->kodebps_kbk) }}"
                               class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-soft-blue focus:border-soft-blue block w-full p-3 @error('kodebps_kbk') border-soft-red @enderror"
                               placeholder="Masukkan kode BPS..."
                               required>
                        @error('kodebps_kbk')
                        <p class="mt-2 text-sm text-soft-red">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Nama BPS -->
                    <div class="md:col-span-2">
                        <label for="namabps_kbk" class="block mb-2 text-sm font-medium text-gray-700">
                            Nama BPS <span class="text-soft-red">*</span>
                        </label>
                        <input type="text" 
                               id="namabps_kbk" 
                               name="namabps_kbk" 
                               value="{{ old('namabps_kbk', $kabkota->namabps_kbk) }}"
                               class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-soft-blue focus:border-soft-blue block w-full p-3 @error('namabps_kbk') border-soft-red @enderror"
                               placeholder="Masukkan nama BPS..."
                               maxlength="100"
                               required>
                        @error('namabps_kbk')
                        <p class="mt-2 text-sm text-soft-red">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Current Data Info -->
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                    <h3 class="text-sm font-medium text-soft-blue mb-3">Informasi Data Saat Ini</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm text-gray-600">
                        <div class="flex items-center">
                            <svg class="w-4 h-4 mr-2 text-soft-blue" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="text-soft-blue font-medium">Dibuat:</span>
                            <span class="ml-1">{{ $kabkota->created_at ? \Carbon\Carbon::parse($kabkota->created_at)->format('d/m/Y H:i') : '-' }}</span>
                        </div>
                        <div class="flex items-center">
                            <svg class="w-4 h-4 mr-2 text-soft-blue" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M4 2a1 1 0 011 1v2.101a7.002 7.002 0 0111.601 2.566 1 1 0 11-1.885.666A5.002 5.002 0 005.999 7H9a1 1 0 010 2H4a1 1 0 01-1-1V3a1 1 0 011-1zm.008 9.057a1 1 0 011.276.61A5.002 5.002 0 0014.001 13H11a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0v-2.101a7.002 7.002 0 01-11.601-2.566 1 1 0 01.61-1.276z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="text-soft-blue font-medium">Diperbarui:</span>
                            <span class="ml-1">{{ $kabkota->updated_at ? \Carbon\Carbon::parse($kabkota->updated_at)->format('d/m/Y H:i') : '-' }}</span>
                        </div>
                        <div class="flex items-center">
                            <div class="w-2 h-2 bg-soft-green rounded-full mr-2"></div>
                            <span class="text-soft-blue font-medium">Status:</span>
                            <span class="ml-1 text-soft-green">Aktif</span>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="flex items-center justify-between pt-6 border-t border-gray-200">
                    <a href="{{ route('kabkota.index') }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:ring-4 focus:ring-gray-100 transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        Batal
                    </a>
                    <button type="submit" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-soft-blue border border-transparent rounded-lg hover:bg-blue-700 focus:ring-4 focus:ring-blue-200 transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                        Simpan Perubahan
                    </button>
                </div>
            </form>
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