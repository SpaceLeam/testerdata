<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panic Button - Tendako Emergency</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.1/dist/flowbite.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.1/dist/flowbite.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body class="bg-red-50">
    <div class="min-h-screen">
        <!-- Header -->
        <div class="bg-red-600 shadow-lg">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between h-16">
                    <div class="flex items-center">
                        <div class="bg-white text-red-600 p-2 rounded-lg mr-3 animate-pulse">
                            <i class="fas fa-exclamation-triangle"></i>
                        </div>
                        <h1 class="text-xl font-bold text-white">Tendako Emergency</h1>
                        <div class="ml-4 flex items-center text-sm text-red-100">
                            <div class="w-2 h-2 bg-red-300 rounded-full mr-2 animate-pulse"></div>
                            Emergency Mode
                        </div>
                    </div>
                    <div class="flex items-center space-x-4">
                        <div id="locationStatus" class="text-red-100 text-sm">
                            <i class="fas fa-location-arrow mr-1"></i>
                            <span id="statusText">Lokasi GPS: Belum aktif</span>
                        </div>
                        <a href="{{ route('kodepos.index') }}" class="text-red-100 hover:text-white font-medium">
                            <i class="fas fa-arrow-left mr-2"></i>
                            Kembali ke Normal
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Content -->
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <!-- Emergency Header -->
            <div class="text-center mb-8">
                <div class="inline-flex items-center justify-center w-24 h-24 bg-red-600 rounded-full mb-4 animate-pulse">
                    <i class="fas fa-exclamation-triangle text-white text-3xl"></i>
                </div>
                <h2 class="text-4xl font-bold text-red-600 mb-2">PANIC BUTTON</h2>
                <p class="text-red-700 text-lg">Sistem Pelaporan Darurat Tendako</p>
                <p class="text-red-600 text-sm mt-2">Gunakan hanya untuk situasi darurat yang memerlukan respon cepat</p>
            </div>

            <!-- GPS Status Card -->
            <div id="gpsStatusCard" class="mb-6 bg-white rounded-lg shadow-lg border-2 border-yellow-300 overflow-hidden">
                <div class="bg-yellow-500 px-6 py-3">
                    <h3 class="text-lg font-bold text-white flex items-center">
                        <i class="fas fa-satellite-dish mr-2"></i>
                        Status Lokasi GPS
                    </h3>
                </div>
                <div class="p-4">
                    <div id="gpsContent" class="text-center">
                        <div class="inline-flex items-center justify-center w-12 h-12 bg-yellow-100 rounded-full mb-3">
                            <i class="fas fa-location-arrow text-yellow-600 text-xl"></i>
                        </div>
                        <p class="text-gray-700 mb-4">Lokasi GPS diperlukan untuk laporan darurat yang akurat</p>
                        <div class="flex flex-col sm:flex-row justify-center space-y-2 sm:space-y-0 sm:space-x-3">
                            <button onclick="requestLocationPermission()" 
                                    class="inline-flex items-center px-4 py-2 bg-green-500 text-white hover:bg-green-600 rounded-lg font-medium transition-colors">
                                <i class="fas fa-crosshairs mr-2"></i>
                                Aktifkan GPS
                            </button>
                            <button onclick="skipGPS()" 
                                    class="inline-flex items-center px-4 py-2 border border-gray-300 text-gray-700 bg-white hover:bg-gray-50 rounded-lg font-medium transition-colors">
                                <i class="fas fa-forward mr-2"></i>
                                Lewati (Input Manual)
                            </button>
                        </div>
                    </div>
                    <div id="gpsSuccess" class="hidden text-center">
                        <div class="inline-flex items-center justify-center w-12 h-12 bg-green-100 rounded-full mb-3">
                            <i class="fas fa-check-circle text-green-600 text-xl"></i>
                        </div>
                        <p class="text-green-700 font-medium mb-2">Lokasi GPS Berhasil Didapatkan!</p>
                        <div class="bg-green-50 border border-green-200 rounded-lg p-3 mb-3">
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 text-sm">
                                <div>
                                    <span class="font-medium text-green-700">Latitude:</span>
                                    <span id="currentLat" class="text-green-600">-</span>
                                </div>
                                <div>
                                    <span class="font-medium text-green-700">Longitude:</span>
                                    <span id="currentLng" class="text-green-600">-</span>
                                </div>
                                <div class="sm:col-span-2">
                                    <span class="font-medium text-green-700">Akurasi:</span>
                                    <span id="currentAccuracy" class="text-green-600">-</span> meter
                                </div>
                            </div>
                        </div>
                        <button onclick="refreshLocation()" 
                                class="inline-flex items-center px-3 py-1.5 text-sm bg-blue-500 text-white hover:bg-blue-600 rounded-lg font-medium transition-colors">
                            <i class="fas fa-sync-alt mr-1"></i>
                            Perbarui Lokasi
                        </button>
                    </div>
                    <div id="gpsError" class="hidden text-center">
                        <div class="inline-flex items-center justify-center w-12 h-12 bg-red-100 rounded-full mb-3">
                            <i class="fas fa-exclamation-triangle text-red-600 text-xl"></i>
                        </div>
                        <p class="text-red-700 font-medium mb-2">Gagal Mendapatkan Lokasi GPS</p>
                        <p id="gpsErrorMessage" class="text-red-600 text-sm mb-3">-</p>
                        <div class="flex flex-col sm:flex-row justify-center space-y-2 sm:space-y-0 sm:space-x-3">
                            <button onclick="requestLocationPermission()" 
                                    class="inline-flex items-center px-4 py-2 bg-green-500 text-white hover:bg-green-600 rounded-lg font-medium transition-colors">
                                <i class="fas fa-redo mr-2"></i>
                                Coba Lagi
                            </button>
                            <button onclick="skipGPS()" 
                                    class="inline-flex items-center px-4 py-2 border border-gray-300 text-gray-700 bg-white hover:bg-gray-50 rounded-lg font-medium transition-colors">
                                <i class="fas fa-edit mr-2"></i>
                                Input Manual
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Emergency Status Display -->
            <div id="statusDisplay" class="hidden mb-6">
                <!-- Will be populated by JavaScript -->
            </div>

            <!-- Emergency Form -->
            <div id="panicForm" class="bg-white rounded-lg shadow-lg border-2 border-red-200 overflow-hidden">
                <div class="bg-red-600 px-6 py-4">
                    <h3 class="text-lg font-bold text-white flex items-center">
                        <i class="fas fa-siren mr-2"></i>
                        Form Laporan Darurat
                    </h3>
                    <p class="text-red-100 text-sm mt-1">Isi informasi berikut dengan lengkap dan akurat</p>
                </div>
                
                <form id="emergencyForm" class="p-6">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Location Selection -->
                        <div class="md:col-span-2">
                            <label class="block text-sm font-bold text-red-700 mb-2">
                                <i class="fas fa-map-marker-alt mr-1"></i>
                                Lokasi Kode Pos <span class="text-red-500">*</span>
                            </label>
                            <select name="id_kdp" id="id_kdp" required
                                    class="block w-full px-3 py-2 border-2 border-red-300 rounded-lg focus:ring-red-500 focus:border-red-500 bg-red-50">
                                <option value="">Pilih Lokasi Kode Pos</option>
                                <!-- Will be populated by AJAX if needed, or you can populate from controller -->
                            </select>
                        </div>

                        <!-- Emergency Type -->
                        <div class="md:col-span-1">
                            <label class="block text-sm font-bold text-red-700 mb-2">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                Jenis Darurat <span class="text-red-500">*</span>
                            </label>
                            <select name="jenis_laporan" id="jenis_laporan" required
                                    class="block w-full px-3 py-2 border-2 border-red-300 rounded-lg focus:ring-red-500 focus:border-red-500 bg-red-50">
                                <option value="">Pilih Jenis Darurat</option>
                                <option value="kebakaran">🔥 Kebakaran</option>
                                <option value="kecelakaan">🚨 Kecelakaan</option>
                                <option value="bencana_alam">🌊 Bencana Alam</option>
                                <option value="kejahatan">🚔 Tindak Kejahatan</option>
                                <option value="medis">🏥 Darurat Medis</option>
                                <option value="infrastruktur">⚡ Infrastruktur</option>
                                <option value="lainnya">❓ Lainnya</option>
                            </select>
                        </div>

                        <!-- Reporting Branch -->
                        <div class="md:col-span-1">
                            <label class="block text-sm font-bold text-red-700 mb-2">
                                <i class="fas fa-building mr-1"></i>
                                Cabang Pelapor <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="cbg_psr" id="cbg_psr" required
                                   placeholder="Nama cabang/unit pelapor"
                                   class="block w-full px-3 py-2 border-2 border-red-300 rounded-lg focus:ring-red-500 focus:border-red-500 bg-red-50"
                                   maxlength="100">
                        </div>

                        <!-- Address -->
                        <div class="md:col-span-2">
                            <label class="block text-sm font-bold text-red-700 mb-2">
                                <i class="fas fa-location-arrow mr-1"></i>
                                Alamat Lokasi Kejadian <span class="text-red-500">*</span>
                            </label>
                            <textarea name="alamat_psr" id="alamat_psr" rows="3" required
                                      placeholder="Jelaskan alamat lengkap lokasi kejadian darurat..."
                                      class="block w-full px-3 py-2 border-2 border-red-300 rounded-lg focus:ring-red-500 focus:border-red-500 bg-red-50"></textarea>
                        </div>

                        <!-- GPS Coordinates with Auto-fill -->
                        <div class="md:col-span-2">
                            <div class="bg-blue-50 border-2 border-blue-200 rounded-lg p-4">
                                <h4 class="text-sm font-bold text-blue-700 mb-3 flex items-center">
                                    <i class="fas fa-crosshairs mr-2"></i>
                                    Koordinat GPS
                                    <span id="gpsAutoFill" class="ml-2 text-xs bg-green-100 text-green-700 px-2 py-1 rounded-full hidden">
                                        <i class="fas fa-check mr-1"></i>Auto-filled
                                    </span>
                                </h4>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-blue-700 mb-1">
                                            Longitude <span class="text-red-500">*</span>
                                        </label>
                                        <div class="relative">
                                            <input type="number" name="longitude_psr" id="longitude_psr" 
                                                   step="any" min="-180" max="180" required
                                                   placeholder="Contoh: 106.845599"
                                                   class="block w-full px-3 py-2 border-2 border-blue-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 bg-blue-50">
                                            <button type="button" onclick="requestLocationPermission()" 
                                                    class="absolute right-2 top-2 text-blue-500 hover:text-blue-700">
                                                <i class="fas fa-location-arrow"></i>
                                            </button>
                                        </div>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-blue-700 mb-1">
                                            Latitude <span class="text-red-500">*</span>
                                        </label>
                                        <input type="number" name="latitude_psr" id="latitude_psr" 
                                               step="any" min="-90" max="90" required
                                               placeholder="Contoh: -6.208763"
                                               class="block w-full px-3 py-2 border-2 border-blue-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 bg-blue-50">
                                    </div>
                                </div>
                                
                                <div class="mt-3 flex flex-wrap gap-2">
                                    <button type="button" onclick="requestLocationPermission()" 
                                            class="inline-flex items-center px-3 py-1.5 text-sm bg-green-500 text-white hover:bg-green-600 rounded-lg font-medium transition-colors">
                                        <i class="fas fa-crosshairs mr-1"></i>
                                        Dapatkan Lokasi Saat Ini
                                    </button>
                                    <button type="button" onclick="clearCoordinates()" 
                                            class="inline-flex items-center px-3 py-1.5 text-sm border border-gray-300 text-gray-700 bg-white hover:bg-gray-50 rounded-lg font-medium transition-colors">
                                        <i class="fas fa-eraser mr-1"></i>
                                        Clear
                                    </button>
                                    <!-- Quick presets for development/testing -->
                                    <div class="hidden" id="presetButtons">
                                        <button type="button" onclick="usePresetCoordinates('jakarta')" 
                                                class="inline-flex items-center px-2 py-1 text-xs bg-gray-400 text-white hover:bg-gray-500 rounded font-medium transition-colors">
                                            Jakarta
                                        </button>
                                        <button type="button" onclick="usePresetCoordinates('bandung')" 
                                                class="inline-flex items-center px-2 py-1 text-xs bg-gray-400 text-white hover:bg-gray-500 rounded font-medium transition-colors">
                                            Bandung
                                        </button>
                                        <button type="button" onclick="usePresetCoordinates('surabaya')" 
                                                class="inline-flex items-center px-2 py-1 text-xs bg-gray-400 text-white hover:bg-gray-500 rounded font-medium transition-colors">
                                            Surabaya
                                        </button>
                                    </div>
                                    <div id="coordinateAccuracy" class="hidden flex items-center text-xs text-gray-600">
                                        <i class="fas fa-bullseye mr-1"></i>
                                        <span>Akurasi: <span id="accuracyValue">-</span>m</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Emergency Description -->
                        <div class="md:col-span-2">
                            <label class="block text-sm font-bold text-red-700 mb-2">
                                <i class="fas fa-clipboard-list mr-1"></i>
                                Deskripsi Situasi Darurat <span class="text-red-500">*</span>
                            </label>
                            <textarea name="deskripsi_darurat" id="deskripsi_darurat" rows="4" required
                                      placeholder="Jelaskan secara detail situasi darurat yang terjadi, jumlah korban (jika ada), tingkat bahaya, dan bantuan yang diperlukan..."
                                      class="block w-full px-3 py-2 border-2 border-red-300 rounded-lg focus:ring-red-500 focus:border-red-500 bg-red-50"></textarea>
                        </div>
                    </div>

                    <!-- Warning Notice -->
                    <div class="mt-6 p-4 bg-yellow-50 border-2 border-yellow-300 rounded-lg">
                        <div class="flex items-start">
                            <i class="fas fa-exclamation-triangle text-yellow-600 mt-0.5 mr-3"></i>
                            <div>
                                <h4 class="text-sm font-bold text-yellow-800">PERINGATAN PENTING:</h4>
                                <ul class="mt-2 text-sm text-yellow-700 space-y-1">
                                    <li>• Pastikan informasi yang dimasukkan akurat dan sesuai kondisi sebenarnya</li>
                                    <li>• Laporan palsu dapat dikenakan sanksi hukum</li>
                                    <li>• Tim respons darurat akan segera menindaklanjuti laporan ini</li>
                                    <li>• Untuk situasi yang mengancam jiwa, hubungi 112 secara langsung</li>
                                    <li>• Koordinat GPS akan membantu tim respons menemukan lokasi dengan cepat</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="flex flex-col sm:flex-row justify-center space-y-3 sm:space-y-0 sm:space-x-4 mt-8 pt-6 border-t-2 border-red-200">
                        <button type="button" onclick="confirmSubmit()" 
                                class="w-full sm:w-auto inline-flex items-center justify-center px-8 py-4 bg-red-600 text-white hover:bg-red-700 rounded-lg font-bold text-lg transition-all duration-200 transform hover:scale-105 shadow-lg">
                            <i class="fas fa-paper-plane mr-3 animate-pulse"></i>
                            KIRIM LAPORAN DARURAT
                        </button>
                        <a href="{{ route('kodepos.index') }}" 
                           class="w-full sm:w-auto inline-flex items-center justify-center px-6 py-4 border-2 border-gray-400 text-gray-700 bg-white hover:bg-gray-50 rounded-lg font-medium transition-colors">
                            <i class="fas fa-times mr-2"></i>
                            Batal
                        </a>
                    </div>
                </form>
            </div>

            <!-- Emergency Contacts -->
            <div class="mt-8 bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">
                    <i class="fas fa-phone text-red-500 mr-2"></i>
                    Kontak Darurat
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="text-center p-4 bg-red-50 rounded-lg">
                        <i class="fas fa-ambulance text-red-500 text-2xl mb-2"></i>
                        <div class="font-semibold text-gray-900">Ambulans/Medis</div>
                        <div class="text-red-600 font-bold text-lg">118</div>
                    </div>
                    <div class="text-center p-4 bg-blue-50 rounded-lg">
                        <i class="fas fa-shield-alt text-blue-500 text-2xl mb-2"></i>
                        <div class="font-semibold text-gray-900">Polisi</div>
                        <div class="text-blue-600 font-bold text-lg">110</div>
                    </div>
                    <div class="text-center p-4 bg-orange-50 rounded-lg">
                        <i class="fas fa-fire text-orange-500 text-2xl mb-2"></i>
                        <div class="font-semibold text-gray-900">Pemadam Kebakaran</div>
                        <div class="text-orange-600 font-bold text-lg">113</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Global variables for GPS
        let watchId = null;
        let currentPosition = null;
        let gpsPermissionGranted = false;

        // Clear coordinates - FROM PASTE.TXT
        function clearCoordinates() {
            document.getElementById('latitude_psr').value = '';
            document.getElementById('longitude_psr').value = '';
            document.getElementById('gpsAutoFill').classList.add('hidden');
            document.getElementById('coordinateAccuracy').classList.add('hidden');
            showToast('Koordinat dikosongkan', 'info');
        }

        // Quick coordinate presets for development/testing - FROM PASTE.TXT
        function usePresetCoordinates(preset) {
            let lat, lng, location;
            
            switch(preset) {
                case 'jakarta':
                    lat = -6.200000;
                    lng = 106.816666;
                    location = 'Jakarta Pusat';
                    break;
                case 'bandung':
                    lat = -6.917464;
                    lng = 107.619125;
                    location = 'Bandung';
                    break;
                case 'surabaya':
                    lat = -7.257472;
                    lng = 112.752090;
                    location = 'Surabaya';
                    break;
                default:
                    return;
            }
            
            document.getElementById('latitude_psr').value = lat;
            document.getElementById('longitude_psr').value = lng;
            
            showToast(`Koordinat ${location} telah diisi`, 'success');
        }

        // Show success report - FIXED version FROM PASTE.TXT
        function showSuccessReport(data) {
            document.getElementById('panicForm').style.display = 'none';
            
            const statusDisplay = document.getElementById('statusDisplay');
            statusDisplay.innerHTML = `
                <div class="bg-green-100 border-2 border-green-300 rounded-lg p-6 text-center">
                    <div class="inline-flex items-center justify-center w-16 h-16 bg-green-500 rounded-full mb-4">
                        <i class="fas fa-check text-white text-2xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-green-700 mb-2">Laporan Darurat Berhasil Dikirim!</h3>
                    <div class="bg-white rounded-lg p-4 mb-4">
                        <p class="text-lg font-semibold text-gray-900 mb-2">Nomor Laporan:</p>
                        <p class="text-2xl font-bold text-green-600">${data.nomor_laporan}</p>
                    </div>
                    <p class="text-green-700 mb-4">${data.message}</p>
                    <div class="space-y-2 text-sm text-green-600">
                        <p>⏰ Status: <span class="font-semibold">${data.data.status_penanganan.toUpperCase()} - Menunggu Tim Respons</span></p>
                        <p>📍 Lokasi: ${data.data.kel_kdp}, ${data.data.kec_kdp}</p>
                        <p>🏢 Cabang: ${data.data.cbg_psr}</p>
                        <p>🚨 Jenis: ${data.data.jenis_laporan}</p>
                        <p>📅 Tanggal: ${new Date(data.data.tanggal_laporan).toLocaleString('id-ID')}</p>
                    </div>
                    <div class="mt-6 flex flex-col sm:flex-row justify-center space-y-3 sm:space-y-0 sm:space-x-4">
                        <a href="{{ route('kodepos.index') }}" 
                           class="inline-flex items-center px-6 py-3 bg-orange-500 text-white hover:bg-orange-600 rounded-lg font-medium transition-colors">
                            <i class="fas fa-home mr-2"></i>
                            Kembali ke Beranda
                        </a>
                        <button onclick="printReport()" 
                                class="inline-flex items-center px-6 py-3 border border-green-500 text-green-700 bg-white hover:bg-green-50 rounded-lg font-medium transition-colors">
                            <i class="fas fa-print mr-2"></i>
                            Cetak Laporan
                        </button>
                    </div>
                </div>
            `;
            statusDisplay.classList.remove('hidden');
            
            // Auto redirect after 30 seconds
            setTimeout(() => {
                if (confirm('Laporan telah berhasil dikirim. Klik OK untuk kembali ke beranda.')) {
                    window.location.href = '/kodepos'; // Use direct URL instead of Laravel route
                }
            }, 30000);
        }

        // Enhanced form validation before submit - FROM PASTE.TXT
        function confirmSubmit() {
            // Validate required coordinates
            const lat = document.getElementById('latitude_psr').value;
            const lng = document.getElementById('longitude_psr').value;
            const jenisLaporan = document.getElementById('jenis_laporan').value;
            const cbgPsr = document.getElementById('cbg_psr').value;
            const alamatPsr = document.getElementById('alamat_psr').value;
            const deskripsiDarurat = document.getElementById('deskripsi_darurat').value;
            const idKdp = document.getElementById('id_kdp').value;
            
            // Check required fields (koordinat optional sekarang)
            const missingFields = [];
            if (!idKdp) missingFields.push('Lokasi Kode Pos');
            if (!jenisLaporan) missingFields.push('Jenis Darurat');
            if (!cbgPsr) missingFields.push('Cabang Pelapor');
            if (!alamatPsr) missingFields.push('Alamat Lokasi');
            if (!deskripsiDarurat) missingFields.push('Deskripsi Darurat');
            
            if (missingFields.length > 0) {
                showToast(`Field wajib belum diisi: ${missingFields.join(', ')}`, 'error');
                return;
            }
            
            // Validate coordinate ranges only if provided
            if (lat && (parseFloat(lat) < -90 || parseFloat(lat) > 90)) {
                showToast('Latitude harus antara -90 dan 90', 'error');
                return;
            }
            
            if (lng && (parseFloat(lng) < -180 || parseFloat(lng) > 180)) {
                showToast('Longitude harus antara -180 dan 180', 'error');
                return;
            }
            
            const message = `KONFIRMASI PENGIRIMAN LAPORAN DARURAT

Apakah Anda yakin ingin mengirim laporan darurat ini?
Tim respons akan segera menindaklanjuti laporan Anda.

Lokasi GPS: ${lat || 'Tidak ada'}, ${lng || 'Tidak ada'}
Jenis Darurat: ${jenisLaporan}
Cabang: ${cbgPsr}
${currentPosition ? `Akurasi: ~${Math.round(currentPosition.coords.accuracy)}m` : 'Input manual'}

Klik OK untuk mengirim, atau Cancel untuk membatalkan.`;
            
            if (confirm(message)) {
                submitEmergencyReport();
            }
        }

        // Enhanced error handling in submit - FROM PASTE.TXT
        function submitEmergencyReport() {
            const form = document.getElementById('emergencyForm');
            const formData = new FormData(form);
            
            // Show loading state
            showLoading();
            
            // Use the correct URL for your Laravel route
            fetch(window.location.origin + '/kodepos/panic-report', { // Dynamic URL
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP ${response.status}: ${response.statusText}`);
                }
                return response.json();
            })
            .then(data => {
                hideLoading();
                
                if (data.success) {
                    showSuccessReport(data);
                } else {
                    showToast(data.message || 'Terjadi kesalahan saat mengirim laporan', 'error');
                    if (data.errors) {
                        Object.values(data.errors).forEach(errorArray => {
                            if (Array.isArray(errorArray)) {
                                errorArray.forEach(error => showToast(error, 'error'));
                            } else {
                                showToast(errorArray, 'error');
                            }
                        });
                    }
                    if (data.debug) {
                        console.error('Debug info:', data.debug);
                    }
                }
            })
            .catch(error => {
                hideLoading();
                console.error('Error:', error);
                showToast(`Terjadi kesalahan jaringan: ${error.message}`, 'error');
            });
        }

        // Request location permission and get current location
        function requestLocationPermission() {
            if (!navigator.geolocation) {
                showGPSError("Browser tidak mendukung geolocation");
                return;
            }

            // Show loading state
            updateGPSStatus('loading');
            
            // Request permission and get location
            navigator.geolocation.getCurrentPosition(
                function(position) {
                    currentPosition = position;
                    gpsPermissionGranted = true;
                    updateLocationFields(position);
                    updateGPSStatus('success');
                    showToast('Lokasi GPS berhasil didapatkan!', 'success');
                },
                function(error) {
                    handleLocationError(error);
                },
                {
                    enableHighAccuracy: true,
                    timeout: 15000,
                    maximumAge: 60000
                }
            );
        }

        // Handle location errors
        function handleLocationError(error) {
            let message = '';
            switch(error.code) {
                case error.PERMISSION_DENIED:
                    message = "Izin akses lokasi ditolak. Mohon aktifkan GPS dan berikan izin lokasi.";
                    break;
                case error.POSITION_UNAVAILABLE:
                    message = "Informasi lokasi tidak tersedia. Pastikan GPS aktif.";
                    break;
                case error.TIMEOUT:
                    message = "Waktu pencarian lokasi habis. Coba lagi atau periksa sinyal GPS.";
                    break;
                default:
                    message = "Terjadi kesalahan tidak dikenal saat mencari lokasi.";
                    break;
            }
            showGPSError(message);
        }

        // Update location fields with GPS data
        function updateLocationFields(position) {
            document.getElementById('latitude_psr').value = position.coords.latitude.toFixed(6);
            document.getElementById('longitude_psr').value = position.coords.longitude.toFixed(6);
            
            // Show auto-fill indicator
            document.getElementById('gpsAutoFill').classList.remove('hidden');
            document.getElementById('coordinateAccuracy').classList.remove('hidden');
            document.getElementById('accuracyValue').textContent = Math.round(position.coords.accuracy);
            
            // Update display values
            document.getElementById('currentLat').textContent = position.coords.latitude.toFixed(6);
            document.getElementById('currentLng').textContent = position.coords.longitude.toFixed(6);
            document.getElementById('currentAccuracy').textContent = Math.round(position.coords.accuracy);
        }

        // Update GPS status display
        function updateGPSStatus(status) {
            const gpsContent = document.getElementById('gpsContent');
            const gpsSuccess = document.getElementById('gpsSuccess');
            const gpsError = document.getElementById('gpsError');
            const statusText = document.getElementById('statusText');
            const gpsStatusCard = document.getElementById('gpsStatusCard');

            // Hide all status divs
            gpsContent.classList.add('hidden');
            gpsSuccess.classList.add('hidden');
            gpsError.classList.add('hidden');

            switch(status) {
                case 'loading':
                    gpsContent.classList.remove('hidden');
                    gpsContent.innerHTML = `
                        <div class="inline-flex items-center justify-center w-12 h-12 bg-blue-100 rounded-full mb-3">
                            <i class="fas fa-spinner text-blue-600 text-xl animate-spin"></i>
                        </div>
                        <p class="text-blue-700 font-medium mb-2">Mencari lokasi GPS...</p>
                        <p class="text-blue-600 text-sm">Mohon tunggu dan pastikan GPS aktif</p>
                    `;
                    statusText.innerHTML = '<i class="fas fa-spinner animate-spin mr-1"></i>Mencari lokasi GPS...';
                    gpsStatusCard.className = 'mb-6 bg-white rounded-lg shadow-lg border-2 border-blue-300 overflow-hidden';
                    break;
                    
                case 'success':
                    gpsSuccess.classList.remove('hidden');
                    statusText.innerHTML = '<i class="fas fa-check-circle mr-1"></i>GPS aktif dan terhubung';
                    gpsStatusCard.className = 'mb-6 bg-white rounded-lg shadow-lg border-2 border-green-300 overflow-hidden';
                    break;
                    
                case 'error':
                    gpsError.classList.remove('hidden');
                    statusText.innerHTML = '<i class="fas fa-exclamation-triangle mr-1"></i>GPS tidak tersedia';
                    gpsStatusCard.className = 'mb-6 bg-white rounded-lg shadow-lg border-2 border-red-300 overflow-hidden';
                    break;
                    
                default:
                    gpsContent.classList.remove('hidden');
                    statusText.textContent = 'Lokasi GPS: Belum aktif';
                    gpsStatusCard.className = 'mb-6 bg-white rounded-lg shadow-lg border-2 border-yellow-300 overflow-hidden';
            }
        }

        // Show GPS error
        function showGPSError(message) {
            updateGPSStatus('error');
            document.getElementById('gpsErrorMessage').textContent = message;
            showToast(message, 'error');
        }

        // Skip GPS and allow manual input
        function skipGPS() {
            const gpsStatusCard = document.getElementById('gpsStatusCard');
            gpsStatusCard.style.display = 'none';
            showToast('GPS dilewati. Silakan input koordinat manual.', 'info');
        }

        // Refresh location
        function refreshLocation() {
            requestLocationPermission();
        }

        // Show loading state
        function showLoading() {
            const statusDisplay = document.getElementById('statusDisplay');
            statusDisplay.innerHTML = `
                <div class="bg-blue-100 border-2 border-blue-300 rounded-lg p-6 text-center">
                    <div class="inline-flex items-center justify-center w-16 h-16 bg-blue-500 rounded-full mb-4 animate-spin">
                        <i class="fas fa-spinner text-white text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-blue-700 mb-2">Mengirim Laporan Darurat...</h3>
                    <p class="text-blue-600">Mohon tunggu, laporan sedang diproses</p>
                </div>
            `;
            statusDisplay.classList.remove('hidden');
        }

        // Hide loading state
        function hideLoading() {
            const statusDisplay = document.getElementById('statusDisplay');
            statusDisplay.classList.add('hidden');
        }

        // Show toast notification
        function showToast(message, type) {
            const toast = document.createElement('div');
            const bgColor = type === 'success' ? 'bg-green-500' : type === 'error' ? 'bg-red-500' : 'bg-blue-500';
            const icon = type === 'success' ? 'fa-check-circle' : type === 'error' ? 'fa-exclamation-circle' : 'fa-info-circle';
            
            toast.className = `fixed top-4 right-4 ${bgColor} text-white px-6 py-3 rounded-lg shadow-lg z-50 flex items-center max-w-md`;
            toast.innerHTML = `
                <i class="fas ${icon} mr-2"></i>
                <span>${message}</span>
                <button onclick="this.parentElement.remove()" class="ml-4 text-white hover:text-gray-200">
                    <i class="fas fa-times"></i>
                </button>
            `;
            
            document.body.appendChild(toast);
            
            // Auto remove after 5 seconds
            setTimeout(() => {
                if (toast.parentElement) {
                    toast.remove();
                }
            }, 5000);
        }

        // Print report function
        function printReport() {
            window.print();
        }

        // Watch position continuously (optional)
        function startWatchingPosition() {
            if (navigator.geolocation) {
                watchId = navigator.geolocation.watchPosition(
                    function(position) {
                        currentPosition = position;
                        updateLocationFields(position);
                    },
                    function(error) {
                        console.log('Watch position error:', error);
                    },
                    {
                        enableHighAccuracy: true,
                        timeout: 10000,
                        maximumAge: 30000
                    }
                );
            }
        }

        // Stop watching position
        function stopWatchingPosition() {
            if (watchId !== null) {
                navigator.geolocation.clearWatch(watchId);
                watchId = null;
            }
        }

        // Initialize page
        document.addEventListener('DOMContentLoaded', function() {
            // Load kode pos options
            loadKodeposOptions();
            
            // Add form validation
            const form = document.getElementById('emergencyForm');
            form.addEventListener('input', function(e) {
                if (e.target.hasAttribute('required') && e.target.value.trim() !== '') {
                    e.target.classList.remove('border-red-300');
                    e.target.classList.add('border-green-300');
                } else if (e.target.hasAttribute('required')) {
                    e.target.classList.remove('border-green-300');
                    e.target.classList.add('border-red-300');
                }
            });

            // Auto-request GPS on page load
            setTimeout(() => {
                showToast('Sistem akan mencoba mengaktifkan GPS secara otomatis untuk akurasi laporan darurat.', 'info');
                requestLocationPermission();
            }, 2000);
        });

        // Load kode pos options
        function loadKodeposOptions() {
            fetch('{{ route("kodepos.getData") }}')
            .then(response => response.json())
            .then(data => {
                const select = document.getElementById('id_kdp');
                select.innerHTML = '<option value="">Pilih Lokasi Kode Pos</option>';
                
                data.forEach(item => {
                    const option = document.createElement('option');
                    option.value = item.id_kdp;
                    option.textContent = `${item.kodepos_kdp} - ${item.kel_kdp}, ${item.kec_kdp}, ${item.namadagri_kbk}`;
                    select.appendChild(option);
                });
            })
            .catch(error => {
                console.error('Error loading kode pos:', error);
                showToast('Gagal memuat data kode pos', 'error');
            });
        }

        // Emergency sound alert (optional)
        function playEmergencySound() {
            // You can add sound alerts here if needed
            // const audio = new Audio('/sounds/emergency-alert.mp3');
            // audio.play().catch(e => console.log('Audio play failed'));
        }

        // Keyboard shortcuts
        document.addEventListener('keydown', function(e) {
            // Ctrl + Enter to submit form
            if (e.ctrlKey && e.key === 'Enter') {
                e.preventDefault();
                confirmSubmit();
            }
            // Escape to cancel
            if (e.key === 'Escape') {
                if (confirm('Yakin ingin membatalkan laporan darurat?')) {
                    window.location.href = '{{ route("kodepos.index") }}';
                }
            }
        });

        // Prevent accidental page refresh
        window.addEventListener('beforeunload', function(e) {
            const form = document.getElementById('emergencyForm');
            if (form && form.style.display !== 'none') {
                const hasData = Array.from(form.querySelectorAll('input, select, textarea'))
                    .some(field => field.value.trim() !== '');
                
                if (hasData) {
                    e.preventDefault();
                    e.returnValue = 'Data laporan darurat akan hilang. Yakin ingin meninggalkan halaman?';
                }
            }
        });
    </script>

    <style>
        /* Custom animations for emergency theme */
        @keyframes pulse-red {
            0%, 100% { background-color: #dc2626; }
            50% { background-color: #ef4444; }
        }
        
        .animate-pulse-red {
            animation: pulse-red 2s infinite;
        }
        
        /* Print styles */
        @media print {
            body * {
                visibility: hidden;
            }
            #statusDisplay, #statusDisplay * {
                visibility: visible;
            }
            #statusDisplay {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
            }
        }

        /* Enhanced mobile responsiveness */
        @media (max-width: 640px) {
            .text-4xl { font-size: 2rem; }
            .px-8 { padding-left: 1.5rem; padding-right: 1.5rem; }
            .py-4 { padding-top: 0.75rem; padding-bottom: 0.75rem; }
        }

        /* GPS Status animations */
        .border-pulse {
            animation: border-pulse 2s infinite;
        }
        
        @keyframes border-pulse {
            0%, 100% { border-color: #fbbf24; }
            50% { border-color: #f59e0b; }
        }
    </style>
</body>
</html>