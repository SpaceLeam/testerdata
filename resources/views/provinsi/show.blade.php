<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Provinsi - Tendako</title>
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
    <div class="min-h-screen py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-3xl mx-auto">
            <!-- Header Section -->
            <div class="bg-white overflow-hidden shadow rounded-lg mb-6">
                <div class="px-4 py-5 sm:px-6">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="bg-orange-500 p-3 rounded-lg mr-4">
                                <i class="fas fa-map text-white text-xl"></i>
                            </div>
                            <div>
                                <h1 class="text-2xl font-bold text-gray-900">Detail Provinsi</h1>
                                <p class="text-sm text-gray-500">Informasi lengkap provinsi</p>
                            </div>
                        </div>
                        <div class="flex space-x-2">
                            <a href="{{ route('provinsi.edit', $provinsi->kodedagri_prv) }}" 
                               class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-orange-600 hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500">
                                <i class="fas fa-edit mr-2"></i>
                                Edit
                            </a>
                            <a href="{{ route('provinsi.index') }}" 
                               class="inline-flex items-center px-3 py-2 border border-gray-300 text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500">
                                <i class="fas fa-arrow-left mr-2"></i>
                                Kembali
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                <div class="px-4 py-5 sm:px-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Informasi Provinsi</h3>
                    <p class="mt-1 max-w-2xl text-sm text-gray-500">Detail dan informasi provinsi</p>
                </div>
                <div class="border-t border-gray-200">
                    <dl>
                        <!-- Kode Dagri -->
                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="flex items-center text-sm font-medium text-gray-500">
                                <i class="fas fa-hashtag mr-2 text-orange-500"></i>
                                Kode Dagri
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-orange-100 text-orange-800">
                                    {{ $provinsi->kodedagri_prv }}
                                </span>
                            </dd>
                        </div>

                        <!-- Nama Dagri -->
                        <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="flex items-center text-sm font-medium text-gray-500">
                                <i class="fas fa-map-marked-alt mr-2 text-orange-500"></i>
                                Nama Dagri
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2 font-semibold">
                                {{ $provinsi->namadagri_prv }}
                            </dd>
                        </div>

                        <!-- Kode BPS -->
                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="flex items-center text-sm font-medium text-gray-500">
                                <i class="fas fa-code mr-2 text-blue-500"></i>
                                Kode BPS
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                    {{ $provinsi->kodebps_prv }}
                                </span>
                            </dd>
                        </div>

                        <!-- Nama BPS -->
                        <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="flex items-center text-sm font-medium text-gray-500">
                                <i class="fas fa-building mr-2 text-blue-500"></i>
                                Nama BPS
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2 font-semibold">
                                {{ $provinsi->namabps_prv }}
                            </dd>
                        </div>

                        <!-- ID GeoJSON -->
                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="flex items-center text-sm font-medium text-gray-500">
                                <i class="fas fa-globe mr-2 text-green-500"></i>
                                ID GeoJSON
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                @if($provinsi->idgeojson_prv)
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                        {{ $provinsi->idgeojson_prv }}
                                    </span>
                                @else
                                    <span class="text-gray-400 italic">Tidak ada data</span>
                                @endif
                            </dd>
                        </div>

                        <!-- Kode GeoJSON -->
                        <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="flex items-center text-sm font-medium text-gray-500">
                                <i class="fas fa-map-pin mr-2 text-green-500"></i>
                                Kode GeoJSON
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                @if($provinsi->kodegeojson_prv)
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                        {{ $provinsi->kodegeojson_prv }}
                                    </span>
                                @else
                                    <span class="text-gray-400 italic">Tidak ada data</span>
                                @endif
                            </dd>
                        </div>

                        <!-- Status -->
                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="flex items-center text-sm font-medium text-gray-500">
                                <i class="fas fa-info-circle mr-2 text-indigo-500"></i>
                                Status
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                @if($provinsi->status_prv == 1)
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                        <i class="fas fa-check-circle mr-1"></i>
                                        Aktif
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                                        <i class="fas fa-times-circle mr-1"></i>
                                        Tidak Aktif
                                    </span>
                                @endif
                            </dd>
                        </div>

                        <!-- Created At -->
                        <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="flex items-center text-sm font-medium text-gray-500">
                                <i class="fas fa-calendar-plus mr-2 text-gray-500"></i>
                                Dibuat
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                {{ $provinsi->created_at ? \Carbon\Carbon::parse($provinsi->created_at)->format('d/m/Y H:i:s') : 'Tidak ada data' }}
                            </dd>
                        </div>

                        <!-- Updated At -->
                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="flex items-center text-sm font-medium text-gray-500">
                                <i class="fas fa-calendar-edit mr-2 text-gray-500"></i>
                                Diperbarui
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                {{ $provinsi->updated_at ? \Carbon\Carbon::parse($provinsi->updated_at)->format('d/m/Y H:i:s') : 'Tidak ada data' }}
                            </dd>
                        </div>
                    </dl>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="mt-6 flex justify-end space-x-3">
                <a href="{{ route('provinsi.index') }}" 
                   class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500">
                    <i class="fas fa-list mr-2"></i>
                    Kembali ke Daftar
                </a>
                <a href="{{ route('provinsi.edit', $provinsi->kodedagri_prv) }}" 
                   class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-orange-600 hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500">
                    <i class="fas fa-edit mr-2"></i>
                    Edit Provinsi
                </a>
            </div>
        </div>
    </div>
</body>
</html>