<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Kode Pos - Tendako</title>
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
                </div>
                <div>
                    <h2 class="text-3xl font-bold text-gray-900 mb-2">Detail Kode Pos</h2>
                    <p class="text-gray-600">Informasi lengkap data kode pos</p>
                </div>
            </div>

            <!-- Detail Card -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-gray-900">Informasi Kode Pos</h3>
                        <div class="flex items-center space-x-2">
                            <a href="{{ route('kodepos.edit', $kodepos->id_kdp) }}" 
                               class="inline-flex items-center px-3 py-1.5 text-sm bg-yellow-100 text-yellow-700 hover:bg-yellow-200 rounded-lg transition-colors">
                                <i class="fas fa-edit mr-1"></i>
                                Edit
                            </a>
                            <form action="{{ route('kodepos.destroy', $kodepos->id_kdp) }}" method="POST" class="inline-block" 
                                  onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="inline-flex items-center px-3 py-1.5 text-sm bg-red-100 text-red-700 hover:bg-red-200 rounded-lg transition-colors">
                                    <i class="fas fa-trash mr-1"></i>
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Kode Pos -->
                        <div class="bg-orange-50 border border-orange-200 rounded-lg p-4">
                            <div class="flex items-center mb-2">
                                <i class="fas fa-hashtag text-orange-600 mr-2"></i>
                                <label class="text-sm font-medium text-gray-700">Kode Pos</label>
                            </div>
                            <div class="text-2xl font-bold text-orange-600">{{ $kodepos->kodepos_kdp }}</div>
                        </div>

                        <!-- Status -->
                        <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                            <div class="flex items-center mb-2">
                                <i class="fas fa-check-circle text-green-600 mr-2"></i>
                                <label class="text-sm font-medium text-gray-700">Status</label>
                            </div>
                            <div class="text-lg font-semibold text-green-600">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    <span class="w-2 h-2 bg-green-400 rounded-full mr-1"></span>
                                    Aktif
                                </span>
                            </div>
                        </div>

                        <!-- Kelurahan -->
                        <div class="border border-gray-200 rounded-lg p-4">
                            <div class="flex items-center mb-2">
                                <i class="fas fa-map-marker-alt text-gray-600 mr-2"></i>
                                <label class="text-sm font-medium text-gray-700">Kelurahan/Desa</label>
                            </div>
                            <div class="text-lg font-semibold text-gray-900">{{ $kodepos->kel_kdp }}</div>
                        </div>

                        <!-- Kecamatan -->
                        <div class="border border-gray-200 rounded-lg p-4">
                            <div class="flex items-center mb-2">
                                <i class="fas fa-location-arrow text-gray-600 mr-2"></i>
                                <label class="text-sm font-medium text-gray-700">Kecamatan</label>
                            </div>
                            <div class="text-lg font-semibold text-gray-900">{{ $kodepos->kec_kdp }}</div>
                        </div>

                        <!-- Kabupaten/Kota -->
                        <div class="border border-gray-200 rounded-lg p-4">
                            <div class="flex items-center mb-2">
                                <i class="fas fa-city text-gray-600 mr-2"></i>
                                <label class="text-sm font-medium text-gray-700">Kabupaten/Kota</label>
                            </div>
                            <div class="text-lg font-semibold text-gray-900">{{ $kodepos->namadagri_kbk }}</div>
                        </div>

                        <!-- Provinsi -->
                        <div class="border border-gray-200 rounded-lg p-4">
                            <div class="flex items-center mb-2">
                                <i class="fas fa-flag text-gray-600 mr-2"></i>
                                <label class="text-sm font-medium text-gray-700">Provinsi</label>
                            </div>
                            <div class="text-lg font-semibold text-gray-900">{{ $kodepos->namadagri_prv }}</div>
                        </div>
                    </div>

                    <!-- Full Address Display -->
                    <div class="mt-6 pt-6 border-t border-gray-200">
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                            <div class="flex items-center mb-2">
                                <i class="fas fa-map text-blue-600 mr-2"></i>
                                <label class="text-sm font-medium text-gray-700">Alamat Lengkap</label>
                            </div>
                            <div class="text-lg text-gray-900">
                                {{ $kodepos->kel_kdp }}, {{ $kodepos->kec_kdp }}, {{ $kodepos->namadagri_kbk }}, {{ $kodepos->namadagri_prv }} {{ $kodepos->kodepos_kdp }}
                            </div>
                        </div>
                    </div>

                    <!-- Metadata -->
                    @if($kodepos->created_at || $kodepos->updated_at)
                    <div class="mt-6 pt-6 border-t border-gray-200">
                        <h4 class="text-sm font-medium text-gray-700 mb-4">Informasi Sistem</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-gray-600">
                            @if($kodepos->created_at)
                            <div>
                                <span class="font-medium">Dibuat:</span>
                                <span>{{ \Carbon\Carbon::parse($kodepos->created_at)->format('d/m/Y H:i') }}</span>
                            </div>
                            @endif
                            @if($kodepos->updated_at)
                            <div>
                                <span class="font-medium">Diperbarui:</span>
                                <span>{{ \Carbon\Carbon::parse($kodepos->updated_at)->format('d/m/Y H:i') }}</span>
                            </div>
                            @endif
                        </div>
                    </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
</body>
</html>        

   

   

    <style>
        /* Custom animations for emergency elements */
        @keyframes pulse-red {
            0%, 100% { 
                background-color: #dc2626; 
                transform: scale(1);
            }
            50% { 
                background-color: #ef4444; 
                transform: scale(1.05);
            }
        }
        
        .animate-pulse-red {
            animation: pulse-red 2s infinite;
        }
    </style>
</body>
</html>