<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Kabupaten/Kota - Tendako</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.js"></script>
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
<body class="bg-light-gray font-sans antialiased">
    <!-- Header -->
    <nav class="bg-white border-b border-gray-200 shadow-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <div class="flex-shrink-0 flex items-center">
                        <div class="w-8 h-8 bg-gradient-to-r from-soft-orange to-amber-400 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"/>
                            </svg>
                        </div>
                        <span class="ml-3 text-xl font-semibold text-gray-900">Tendako</span>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="hidden md:flex items-center">
                        <div class="flex items-center space-x-2 text-sm text-gray-500">
                            <div class="w-2 h-2 bg-green-400 rounded-full"></div>
                            <span>Online</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Page Header -->
        <div class="mb-8">
            <div class="sm:flex sm:items-center sm:justify-between">
                <div>
                    <nav class="flex mb-4" aria-label="Breadcrumb">
                        <ol class="inline-flex items-center space-x-1 md:space-x-3">
                            <li class="inline-flex items-center">
                                <a href="{{ route('kabkota.index') }}" class="text-sm font-medium text-gray-500 hover:text-gray-700">
                                    Kabupaten/Kota
                                </a>
                            </li>
                            <li>
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                    <span class="ml-1 text-sm font-medium text-gray-900 md:ml-2">Tambah Baru</span>
                                </div>
                            </li>
                        </ol>
                    </nav>
                    <h1 class="text-3xl font-bold text-gray-900">Tambah Kabupaten/Kota</h1>
                    <p class="mt-2 text-sm text-soft-slate">Menambah data kabupaten/kota baru ke sistem</p>
                </div>
                <div class="mt-4 sm:mt-0">
                    <a href="{{ route('kabkota.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-soft-orange focus:ring-offset-2 transition-colors duration-200">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd"/>
                        </svg>
                        Kembali
                    </a>
                </div>
            </div>
        </div>

        <!-- Alerts -->
        @if(session('success'))
        <div class="mb-6 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg" role="alert">
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                {{ session('success') }}
            </div>
        </div>
        @endif

        @if(session('error'))
        <div class="mb-6 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg" role="alert">
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                </svg>
                {{ session('error') }}
            </div>
        </div>
        @endif

        @if($errors->any())
        <div class="mb-6 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg" role="alert">
            <div class="flex items-start">
                <svg class="w-5 h-5 mr-2 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                </svg>
                <div>
                    <div class="font-medium mb-2">Terdapat kesalahan validasi:</div>
                    <ul class="list-disc list-inside space-y-1 text-sm">
                        @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        @endif

        <!-- Create Form -->
        <div class="bg-white shadow-sm border border-gray-200 rounded-lg">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-soft-orange" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Form Data Kabupaten/Kota
                </h3>
                <p class="mt-1 text-sm text-gray-500">Lengkapi informasi berikut untuk menambah data kabupaten/kota baru</p>
            </div>
            
            <div class="px-6 py-6">
                <form method="POST" action="{{ route('kabkota.store') }}" class="space-y-6">
                    @csrf
                    
                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                        <!-- Kode Dagri KBK -->
                        <div>
                            <label for="kodedagri_kbk" class="block text-sm font-medium text-gray-700 mb-2">
                                Kode Dagri KBK
                                <span class="text-red-500">*</span>
                            </label>
                            <input type="number" 
                                   id="kodedagri_kbk" 
                                   name="kodedagri_kbk" 
                                   value="{{ old('kodedagri_kbk') }}" 
                                   class="block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-soft-orange focus:border-soft-orange sm:text-sm @error('kodedagri_kbk') border-red-300 focus:ring-red-500 focus:border-red-500 @enderror"
                                   placeholder="Contoh: 1101">
                            @error('kodedagri_kbk')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Kode BPS KBK -->
                        <div>
                            <label for="kodebps_kbk" class="block text-sm font-medium text-gray-700 mb-2">
                                Kode BPS KBK
                                <span class="text-red-500">*</span>
                            </label>
                            <input type="number" 
                                   id="kodebps_kbk" 
                                   name="kodebps_kbk" 
                                   value="{{ old('kodebps_kbk') }}" 
                                   class="block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-soft-orange focus:border-soft-orange sm:text-sm @error('kodebps_kbk') border-red-300 focus:ring-red-500 focus:border-red-500 @enderror"
                                   placeholder="Contoh: 1101">
                            @error('kodebps_kbk')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Provinsi -->
                    <div>
                        <label for="kodedagri_prv" class="block text-sm font-medium text-gray-700 mb-2">
                            Provinsi
                            <span class="text-red-500">*</span>
                        </label>
                        <select id="kodedagri_prv" 
                                name="kodedagri_prv" 
                                class="block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-soft-orange focus:border-soft-orange sm:text-sm @error('kodedagri_prv') border-red-300 focus:ring-red-500 focus:border-red-500 @enderror">
                            <option value="">Pilih Provinsi</option>
                            @foreach($provinsi as $prov)
                            <option value="{{ $prov->kodedagri_prv }}" {{ old('kodedagri_prv') == $prov->kodedagri_prv ? 'selected' : '' }}>
                                {{ $prov->namadagri_prv }}
                            </option>
                            @endforeach
                        </select>
                        @error('kodedagri_prv')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Nama Dagri KBK -->
                    <div>
                        <label for="namadagri_kbk" class="block text-sm font-medium text-gray-700 mb-2">
                            Nama Dagri KBK
                            <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               id="namadagri_kbk" 
                               name="namadagri_kbk" 
                               value="{{ old('namadagri_kbk') }}" 
                               class="block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-soft-orange focus:border-soft-orange sm:text-sm @error('namadagri_kbk') border-red-300 focus:ring-red-500 focus:border-red-500 @enderror"
                               placeholder="Contoh: Kabupaten Aceh Selatan"
                               maxlength="100">
                        @error('namadagri_kbk')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Nama BPS KBK -->
                    <div>
                        <label for="namabps_kbk" class="block text-sm font-medium text-gray-700 mb-2">
                            Nama BPS KBK
                            <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               id="namabps_kbk" 
                               name="namabps_kbk" 
                               value="{{ old('namabps_kbk') }}" 
                               class="block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-soft-orange focus:border-soft-orange sm:text-sm @error('namabps_kbk') border-red-300 focus:ring-red-500 focus:border-red-500 @enderror"
                               placeholder="Contoh: Kab. Aceh Selatan"
                               maxlength="100">
                        @error('namabps_kbk')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Form Actions -->
                    <div class="flex items-center justify-between pt-6 border-t border-gray-200">
                        <p class="text-sm text-gray-500">
                            <span class="text-red-500">*</span> Field wajib diisi
                        </p>
                        <div class="flex space-x-3">
                            <a href="{{ route('kabkota.index') }}" 
                               class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-soft-orange focus:ring-offset-2 transition-colors duration-200">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                </svg>
                                Batal
                            </a>
                            <button type="submit" 
                                    class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-lg text-white bg-soft-orange hover:bg-orange-600 focus:outline-none focus:ring-2 focus:ring-soft-orange focus:ring-offset-2 transition-colors duration-200">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                                Simpan Data
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Information Panel -->
        <div class="mt-8 bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-200 rounded-lg p-6">
            <h4 class="text-lg font-medium text-blue-900 mb-4 flex items-center">
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                </svg>
                Informasi
            </h4>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-blue-800">
                <div class="space-y-2">
                    <div><strong>Kode Dagri:</strong> Kode unik dari Kementerian Dalam Negeri</div>
                    <div><strong>Kode BPS:</strong> Kode unik dari Badan Pusat Statistik</div>
                </div>
                <div class="space-y-2">
                    <div><strong>Nama Dagri:</strong> Nama resmi dari Kemendagri</div>
                    <div><strong>Nama BPS:</strong> Nama yang digunakan oleh BPS</div>
                </div>
            </div>
        </div>
    </main>

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
        // Form validation enhancements
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('form');
            const inputs = form.querySelectorAll('input[required], select[required]');
            
            // Add real-time validation feedback
            inputs.forEach(input => {
                input.addEventListener('blur', function() {
                    if (this.hasAttribute('required') && !this.value.trim()) {
                        this.classList.add('border-red-300', 'focus:border-red-500', 'focus:ring-red-500');
                        this.classList.remove('border-gray-300', 'focus:border-soft-orange', 'focus:ring-soft-orange');
                    } else {
                        this.classList.remove('border-red-300', 'focus:border-red-500', 'focus:ring-red-500');
                        this.classList.add('border-gray-300', 'focus:border-soft-orange', 'focus:ring-soft-orange');
                    }
                });
            });
            
            // Form submission validation
            form.addEventListener('submit', function(e) {
                let isValid = true;
                inputs.forEach(input => {
                    if (input.hasAttribute('required') && !input.value.trim()) {
                        input.classList.add('border-red-300', 'focus:border-red-500', 'focus:ring-red-500');
                        input.classList.remove('border-gray-300', 'focus:border-soft-orange', 'focus:ring-soft-orange');
                        isValid = false;
                    }
                });
                
                if (!isValid) {
                    e.preventDefault();
                    // Show toast notification
                    const toast = document.createElement('div');
                    toast.className = 'fixed top-4 right-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg shadow-lg z-50';
                    toast.innerHTML = `
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                            Harap lengkapi semua field yang wajib diisi.
                        </div>
                    `;
                    document.body.appendChild(toast);
                    setTimeout(() => toast.remove(), 3000);
                }
            });
        });
    </script>
</body>
</html>