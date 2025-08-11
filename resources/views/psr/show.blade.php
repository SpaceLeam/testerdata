<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail PSR - {{ $psr->cbg_psr }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_GOOGLE_MAPS_API_KEY&libraries=places"></script>
</head>
<body class="bg-gray-50">
    <div class="min-h-screen">
        <!-- Header Section -->
        <div class="bg-white shadow-sm border-b">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <a href="{{ route('psr.index') }}" 
                           class="text-gray-600 hover:text-gray-900 transition-colors duration-200">
                            <i class="fas fa-arrow-left text-xl"></i>
                        </a>
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900 flex items-center">
                                <i class="fas fa-building text-orange-500 mr-3"></i>
                                Detail PSR
                            </h1>
                            <p class="text-gray-600 mt-1">{{ $psr->cbg_psr }}</p>
                        </div>
                    </div>
                    <div class="flex space-x-3">
                        <a href="{{ route('psr.edit', $psr->id_psr) }}" 
                           class="inline-flex items-center px-4 py-2 bg-orange-500 hover:bg-orange-600 text-white rounded-lg transition-colors duration-200">
                            <i class="fas fa-edit mr-2"></i>
                            Edit
                        </a>
                        <form action="{{ route('psr.destroy', $psr->id_psr) }}" 
                              method="POST" 
                              class="inline"
                              onsubmit="return confirm('Apakah Anda yakin ingin menghapus data PSR {{ $psr->cbg_psr }}?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="inline-flex items-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg transition-colors duration-200">
                                <i class="fas fa-trash mr-2"></i>
                                Hapus
                            </button>
                        </form>
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

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Main Information -->
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <h2 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                        <i class="fas fa-info-circle text-blue-500 mr-2"></i>
                        Informasi Umum
                    </h2>
                    
                    <div class="space-y-6">
                        <div class="flex items-start space-x-3">
                            <div class="flex-shrink-0 w-8 h-8 bg-orange-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-id-badge text-orange-600"></i>
                            </div>
                            <div class="flex-1">
                                <label class="block text-sm font-medium text-gray-700 mb-1">ID PSR</label>
                                <p class="text-lg font-semibold text-gray-900">{{ $psr->id_psr }}</p>
                            </div>
                        </div>

                        <div class="flex items-start space-x-3">
                            <div class="flex-shrink-0 w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-building text-blue-600"></i>
                            </div>
                            <div class="flex-1">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Cabang PSR</label>
                                <p class="text-lg font-semibold text-gray-900">{{ $psr->cbg_psr }}</p>
                            </div>
                        </div>

                        <div class="flex items-start space-x-3">
                            <div class="flex-shrink-0 w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-map-marker-alt text-green-600"></i>
                            </div>
                            <div class="flex-1">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Alamat Lengkap</label>
                                <p class="text-gray-900 leading-relaxed">{{ $psr->alamat_psr }}</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div class="flex items-start space-x-3">
                                <div class="flex-shrink-0 w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-mail-bulk text-purple-600"></i>
                                </div>
                                <div class="flex-1">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Kodepos</label>
                                    <span class="inline-flex items-center bg-purple-100 text-purple-800 px-3 py-1 rounded-full text-sm font-medium">
                                        {{ $psr->kodepos_kdp }}
                                    </span>
                                </div>
                            </div>

                            <div class="flex items-start space-x-3">
                                <div class="flex-shrink-0 w-8 h-8 bg-teal-100 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-home text-teal-600"></i>
                                </div>
                                <div class="flex-1">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Kelurahan</label>
                                    <p class="text-gray-900">{{ $psr->kel_kdp }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div class="flex items-start space-x-3">
                                <div class="flex-shrink-0 w-8 h-8 bg-indigo-100 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-city text-indigo-600"></i>
                                </div>
                                <div class="flex-1">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Kecamatan</label>
                                    <p class="text-gray-900">{{ $psr->kec_kdp }}</p>
                                </div>
                            </div>

                            <div class="flex items-start space-x-3">
                                <div class="flex-shrink-0 w-8 h-8 bg-pink-100 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-map text-pink-600"></i>
                                </div>
                                <div class="flex-1">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Kabupaten/Kota</label>
                                    <p class="text-gray-900">{{ $psr->namadagri_kbk }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-start space-x-3">
                            <div class="flex-shrink-0 w-8 h-8 bg-red-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-flag text-red-600"></i>
                            </div>
                            <div class="flex-1">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Provinsi</label>
                                <p class="text-gray-900">{{ $psr->namadagri_prv }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- GPS Coordinates & Map -->
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <h2 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                        <i class="fas fa-satellite text-green-500 mr-2"></i>
                        Koordinat GPS
                    </h2>
                    
                    @if($psr->latitude_psr && $psr->longitude_psr)
                        <div class="space-y-4 mb-6">
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div class="bg-green-50 p-4 rounded-lg">
                                    <label class="block text-sm font-medium text-green-700 mb-1">Latitude</label>
                                    <p class="text-lg font-mono font-semibold text-green-900">{{ $psr->latitude_psr }}</p>
                                </div>
                                <div class="bg-green-50 p-4 rounded-lg">
                                    <label class="block text-sm font-medium text-green-700 mb-1">Longitude</label>
                                    <p class="text-lg font-mono font-semibold text-green-900">{{ $psr->longitude_psr }}</p>
                                </div>
                            </div>
                            
                            <div class="flex flex-wrap gap-2">
                                <a href="https://www.google.com/maps?q={{ $psr->latitude_psr }},{{ $psr->longitude_psr }}" 
                                   target="_blank"
                                   class="inline-flex items-center px-3 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm transition-colors duration-200">
                                    <i class="fab fa-google mr-2"></i>
                                    Google Maps
                                </a>
                                <button onclick="copyCoordinates()" 
                                        class="inline-flex items-center px-3 py-2 bg-gray-600 hover:bg-gray-700 text-white rounded-lg text-sm transition-colors duration-200">
                                    <i class="fas fa-copy mr-2"></i>
                                    Copy Koordinat
                                </button>
                            </div>
                        </div>
                        
                        <!-- Map Container -->
                        <div class="w-full h-64 bg-gray-200 rounded-lg" id="map"></div>
                    @else
                        <div class="text-center py-8">
                            <i class="fas fa-map-marker-alt text-gray-400 text-4xl mb-4"></i>
                            <h3 class="text-lg font-medium text-gray-900 mb-1">Koordinat GPS Tidak Tersedia</h3>
                            <p class="text-gray-600 mb-4">Data koordinat belum diisi untuk PSR ini</p>
                            <a href="{{ route('psr.edit', $psr->id_psr) }}" 
                               class="inline-flex items-center px-4 py-2 bg-orange-500 hover:bg-orange-600 text-white rounded-lg transition-colors duration-200">
                                <i class="fas fa-edit mr-2"></i>
                                Tambah Koordinat
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Timestamps Section -->
            <div class="mt-8 bg-white rounded-xl shadow-lg p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                    <i class="fas fa-clock text-gray-500 mr-2"></i>
                    Informasi Waktu
                </h2>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div class="flex items-start space-x-3">
                        <div class="flex-shrink-0 w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-plus-circle text-blue-600"></i>
                        </div>
                        <div class="flex-1">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Dibuat Pada</label>
                            <p class="text-gray-900">
                                {{ $psr->created_at ? \Carbon\Carbon::parse($psr->created_at)->format('d F Y, H:i') : 'Tidak tersedia' }}
                            </p>
                            <p class="text-sm text-gray-500 mt-1">
                                {{ $psr->created_at ? \Carbon\Carbon::parse($psr->created_at)->diffForHumans() : '' }}
                            </p>
                        </div>
                    </div>

                    <div class="flex items-start space-x-3">
                        <div class="flex-shrink-0 w-8 h-8 bg-orange-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-edit text-orange-600"></i>
                        </div>
                        <div class="flex-1">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Terakhir Diperbarui</label>
                            <p class="text-gray-900">
                                {{ $psr->updated_at ? \Carbon\Carbon::parse($psr->updated_at)->format('d F Y, H:i') : 'Tidak tersedia' }}
                            </p>
                            <p class="text-sm text-gray-500 mt-1">
                                {{ $psr->updated_at ? \Carbon\Carbon::parse($psr->updated_at)->diffForHumans() : '' }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="mt-8 flex flex-col sm:flex-row justify-center space-y-3 sm:space-y-0 sm:space-x-4">
                <a href="{{ route('psr.index') }}" 
                   class="inline-flex items-center justify-center px-6 py-3 border border-gray-300 text-gray-700 bg-white hover:bg-gray-50 rounded-lg transition-colors duration-200">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Kembali ke Daftar
                </a>
                <a href="{{ route('psr.edit', $psr->id_psr) }}" 
                   class="inline-flex items-center justify-center px-6 py-3 bg-orange-500 hover:bg-orange-600 text-white rounded-lg transition-colors duration-200">
                    <i class="fas fa-edit mr-2"></i>
                    Edit Data
                </a>
            </div>
        </div>
    </div>

    <!-- JavaScript -->
    <script>
        // Copy coordinates function
        function copyCoordinates() {
            @if($psr->latitude_psr && $psr->longitude_psr)
                const coordinates = "{{ $psr->latitude_psr }},{{ $psr->longitude_psr }}";
                navigator.clipboard.writeText(coordinates).then(function() {
                    // Show success message
                    const button = event.target.closest('button');
                    const originalText = button.innerHTML;
                    button.innerHTML = '<i class="fas fa-check mr-2"></i>Tersalin!';
                    button.classList.remove('bg-gray-600', 'hover:bg-gray-700');
                    button.classList.add('bg-green-600');
                    
                    setTimeout(function() {
                        button.innerHTML = originalText;
                        button.classList.remove('bg-green-600');
                        button.classList.add('bg-gray-600', 'hover:bg-gray-700');
                    }, 2000);
                }).catch(function(err) {
                    console.error('Could not copy text: ', err);
                });
            @endif
        }

        // Initialize Google Map
        @if($psr->latitude_psr && $psr->longitude_psr)
            function initMap() {
                const location = { lat: {{ $psr->latitude_psr }}, lng: {{ $psr->longitude_psr }} };
                
                const map = new google.maps.Map(document.getElementById("map"), {
                    zoom: 15,
                    center: location,
                    mapTypeControl: true,
                    mapTypeControlOptions: {
                        style: google.maps.MapTypeControlStyle.DROPDOWN_MENU,
                    },
                });

                const marker = new google.maps.Marker({
                    position: location,
                    map: map,
                    title: "{{ $psr->cbg_psr }}",
                    icon: {
                        url: 'data:image/svg+xml;charset=UTF-8,' + encodeURIComponent(`
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="%23f97316" width="32" height="32">
                                <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/>
                            </svg>
                        `),
                        scaledSize: new google.maps.Size(32, 32),
                        anchor: new google.maps.Point(16, 32)
                    }
                });

                const infoWindow = new google.maps.InfoWindow({
                    content: `
                        <div class="p-2">
                            <h3 class="font-bold text-lg">{{ $psr->cbg_psr }}</h3>
                            <p class="text-sm text-gray-600 mt-1">{{ $psr->alamat_psr }}</p>
                            <p class="text-xs text-gray-500 mt-1">{{ $psr->kel_kdp }}, {{ $psr->kec_kdp }}</p>
                            <div class="mt-2 text-xs">
                                <span class="font-mono">{{ $psr->latitude_psr }}, {{ $psr->longitude_psr }}</span>
                            </div>
                        </div>
                    `
                });

                marker.addListener("click", () => {
                    infoWindow.open(map, marker);
                });

                // Open info window by default
                infoWindow.open(map, marker);
            }

            // Load map when page is ready
            window.onload = initMap;
        @endif
    </script>
</body>
</html> 