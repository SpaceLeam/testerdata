<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Provinsi - Tendako</title>
    <script src="https://cdn.tailwindcss.com"></script>
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
<body class="bg-gray-50 font-sans antialiased">
    <div class="min-h-screen flex flex-col justify-center py-12 sm:px-6 lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-md">
            <div class="flex justify-center">
                <div class="bg-orange-500 p-3 rounded-lg">
                    <i class="fas fa-map text-white text-2xl"></i>
                </div>
            </div>
            <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                Tambah Provinsi Baru
            </h2>
            <p class="mt-2 text-center text-sm text-gray-600">
                Atau 
                <a href="{{ route('provinsi.index') }}" class="font-medium text-orange-600 hover:text-orange-500">
                    kembali ke daftar provinsi
                </a>
            </p>
        </div>

        <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
            <div class="bg-white py-8 px-4 shadow sm:rounded-lg sm:px-10">
                <!-- Alert Messages -->
                @if ($errors->any())
                    <div class="mb-4 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded relative">
                        <strong class="font-bold">Terdapat kesalahan:</strong>
                        <ul class="mt-2 list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-4 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded relative">
                        <i class="fas fa-exclamation-circle mr-2"></i>
                        {{ session('error') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('provinsi.store') }}" class="space-y-6">
                    @csrf
                    
                    <!-- Kode Dagri -->
                    <div>
                        <label for="kodedagri_prv" class="block text-sm font-medium text-gray-700">
                            Kode Dagri Provinsi *
                        </label>
                        <div class="mt-1 relative">
                            <input type="number" id="kodedagri_prv" name="kodedagri_prv" value="{{ old('kodedagri_prv') }}" required
                                   class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:ring-orange-500 focus:border-orange-500 sm:text-sm">
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <i class="fas fa-hashtag text-gray-400"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Nama Dagri -->
                    <div>
                        <label for="namadagri_prv" class="block text-sm font-medium text-gray-700">
                            Nama Dagri Provinsi *
                        </label>
                        <div class="mt-1 relative">
                            <input type="text" id="namadagri_prv" name="namadagri_prv" value="{{ old('namadagri_prv') }}" required
                                   class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:ring-orange-500 focus:border-orange-500 sm:text-sm"
                                   placeholder="Contoh: Jawa Barat">
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <i class="fas fa-map-marked-alt text-gray-400"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Kode BPS -->
                    <div>
                        <label for="kodebps_prv" class="block text-sm font-medium text-gray-700">
                            Kode BPS Provinsi *
                        </label>
                        <div class="mt-1 relative">
                            <input type="number" id="kodebps_prv" name="kodebps_prv" value="{{ old('kodebps_prv') }}" required
                                   class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:ring-orange-500 focus:border-orange-500 sm:text-sm">
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <i class="fas fa-code text-gray-400"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Nama BPS -->
                    <div>
                        <label for="namabps_prv" class="block text-sm font-medium text-gray-700">
                            Nama BPS Provinsi *
                        </label>
                        <div class="mt-1 relative">
                            <input type="text" id="namabps_prv" name="namabps_prv" value="{{ old('namabps_prv') }}" required
                                   class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:ring-orange-500 focus:border-orange-500 sm:text-sm"
                                   placeholder="Contoh: Jawa Barat">
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <i class="fas fa-building text-gray-400"></i>
                            </div>
                        </div>
                    </div>

                    <!-- ID GeoJSON (Optional) -->
                    <div>
                        <label for="idgeojson_prv" class="block text-sm font-medium text-gray-700">
                            ID GeoJSON Provinsi
                        </label>
                        <div class="mt-1 relative">
                            <input type="text" id="idgeojson_prv" name="idgeojson_prv" value="{{ old('idgeojson_prv') }}"
                                   class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:ring-orange-500 focus:border-orange-500 sm:text-sm"
                                   placeholder="Optional">
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <i class="fas fa-globe text-gray-400"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Kode GeoJSON (Optional) -->
                    <div>
                        <label for="kodegeojson_prv" class="block text-sm font-medium text-gray-700">
                            Kode GeoJSON Provinsi
                        </label>
                        <div class="mt-1 relative">
                            <input type="number" id="kodegeojson_prv" name="kodegeojson_prv" value="{{ old('kodegeojson_prv') }}"
                                   class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:ring-orange-500 focus:border-orange-500 sm:text-sm"
                                   placeholder="Optional">
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <i class="fas fa-map-pin text-gray-400"></i>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-between pt-4">
                        <a href="{{ route('provinsi.index') }}" 
                           class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500">
                            <i class="fas fa-arrow-left mr-2"></i>
                            Kembali
                        </a>
                        <button type="submit" 
                                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-orange-600 hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500">
                            <i class="fas fa-save mr-2"></i>
                            Simpan Provinsi
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>