<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Tendako</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.0/chart.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/3.2.1/anime.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body class="bg-gray-50">
    <!-- Sidebar -->
    <aside class="fixed top-0 left-0 z-40 w-64 h-screen transition-transform -translate-x-full sm:translate-x-0">
        <div class="h-full px-3 py-4 overflow-y-auto bg-white border-r border-gray-200 shadow-lg">
            <!-- Logo -->
            <div class="flex items-center mb-8 px-3">
                <div class="bg-orange-500 text-white p-2 rounded-lg mr-3">
                    <i class="fas fa-database text-xl"></i>
                </div>
                <div>
                    <h1 class="text-xl font-bold text-gray-900">Tendako</h1>
                    <p class="text-xs text-gray-600">Pusat Data & Informasi</p>
                </div>
            </div>

            <!-- Navigation -->
            <ul class="space-y-2 font-medium">
                <li>
                    <a href="{{ route('dashboard') }}" class="flex items-center p-2 text-white rounded-lg bg-blue-600 group">
                        <i class="fas fa-tachometer-alt"></i>
                        <span class="ml-3">Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('provinsi.index') }}" class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100 group">
                        <i class="fas fa-map"></i>
                        <span class="ml-3">Data Provinsi</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('kabkota.index') }}" class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100 group">
                        <i class="fas fa-city"></i>
                        <span class="ml-3">Data Kabupaten/Kota</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('kodepos.index') }}" class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100 group">
                        <i class="fas fa-mail-bulk"></i>
                        <span class="ml-3">Data Kode Pos</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('psr.index') }}" class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100 group">
                        <i class="fas fa-building"></i>
                        <span class="ml-3">Data PSR</span>
                    </a>
                </li>
            </ul>

            <!-- Settings -->
            <div class="pt-4 mt-4 space-y-2 font-medium border-t border-gray-200">
                <a href="#" class="flex items-center p-2 text-gray-900 transition duration-75 rounded-lg hover:bg-gray-100 group">
                    <i class="fas fa-cog"></i>
                    <span class="ml-3">Pengaturan</span>
                </a>
                <a href="#" class="flex items-center p-2 text-gray-900 transition duration-75 rounded-lg hover:bg-gray-100 group">
                    <i class="fas fa-sign-out-alt"></i>
                    <span class="ml-3">Keluar</span>
                </a>
            </div>
        </div>
    </aside>

    <!-- Main Content -->
    <div class="p-4 sm:ml-64">
        <!-- Header -->
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 mb-2 opacity-0" id="main-title">Dashboard Overview</h1>
                <p class="text-gray-600 opacity-0" id="subtitle">Monitoring dan statistik data wilayah Indonesia</p>
            </div>
            <div class="flex items-center space-x-2">
                <button onclick="refreshData()" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 flex items-center space-x-2">
                    <i class="fas fa-sync-alt" id="refresh-icon"></i>
                    <span>Refresh</span>
                </button>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Provinsi Card -->
            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-200 hover:shadow-lg transition-shadow duration-300 stat-card opacity-0">
                <div class="flex items-center">
                    <div class="p-3 bg-blue-100 rounded-full">
                        <i class="fas fa-map text-blue-600 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Total Provinsi</p>
                        <p class="text-2xl font-bold text-gray-900 counter" data-target="{{ $stats['provinsi']['total'] }}">0</p>
                        <p class="text-xs text-green-600">
                            <i class="fas fa-plus mr-1"></i>+{{ $stats['provinsi']['new_this_month'] }} bulan ini
                        </p>
                    </div>
                </div>
            </div>

            <!-- Kabkota Card -->
            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-200 hover:shadow-lg transition-shadow duration-300 stat-card opacity-0">
                <div class="flex items-center">
                    <div class="p-3 bg-green-100 rounded-full">
                        <i class="fas fa-city text-green-600 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Kabupaten/Kota</p>
                        <p class="text-2xl font-bold text-gray-900 counter" data-target="{{ $stats['kabkota']['total'] }}">0</p>
                        <p class="text-xs text-green-600">
                            <i class="fas fa-plus mr-1"></i>+{{ $stats['kabkota']['new_this_month'] }} bulan ini
                        </p>
                    </div>
                </div>
            </div>

            <!-- Kodepos Card -->
            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-200 hover:shadow-lg transition-shadow duration-300 stat-card opacity-0">
                <div class="flex items-center">
                    <div class="p-3 bg-yellow-100 rounded-full">
                        <i class="fas fa-mail-bulk text-yellow-600 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Kode Pos</p>
                        <p class="text-2xl font-bold text-gray-900 counter" data-target="{{ $stats['kodepos']['total'] }}">0</p>
                        <p class="text-xs text-blue-600">
                            <i class="fas fa-plus mr-1"></i>+{{ $stats['kodepos']['new_this_month'] }} bulan ini
                        </p>
                    </div>
                </div>
            </div>

            <!-- PSR Card -->
            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-200 hover:shadow-lg transition-shadow duration-300 stat-card opacity-0">
                <div class="flex items-center">
                    <div class="p-3 bg-purple-100 rounded-full">
                        <i class="fas fa-building text-purple-600 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Total PSR</p>
                        <p class="text-2xl font-bold text-gray-900 counter" data-target="{{ $stats['psr']['total'] }}">0</p>
                        <p class="text-xs text-purple-600">
                            <i class="fas fa-plus mr-1"></i>+{{ $stats['psr']['new_this_month'] }} bulan ini
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Row 1 -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            <!-- Province Distribution Chart -->
            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-200 chart-card opacity-0">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-semibold text-gray-900">Distribusi Kabkota per Provinsi</h3>
                    <div class="flex items-center space-x-2">
                        <button class="text-sm text-gray-600 hover:text-gray-900">
                            <i class="fas fa-download"></i>
                        </button>
                    </div>
                </div>
                <div class="h-80">
                    <canvas id="provinceChart"></canvas>
                </div>
            </div>

            <!-- Growth Trend Chart -->
            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-200 chart-card opacity-0">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-semibold text-gray-900">Trend Pertumbuhan Data</h3>
                    <select class="text-sm border border-gray-300 rounded px-3 py-1" onchange="updateGrowthChart(this.value)">
                        <option value="6">6 Bulan Terakhir</option>
                        <option value="12">12 Bulan Terakhir</option>
                    </select>
                </div>
                <div class="h-80">
                    <canvas id="growthChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Charts Row 2 -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
            <!-- Doughnut Chart -->
            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-200 chart-card opacity-0">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-semibold text-gray-900">Komposisi Data</h3>
                </div>
                <div class="h-64">
                    <canvas id="compositionChart"></canvas>
                </div>
            </div>

            <!-- Activity Chart -->
            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-200 chart-card opacity-0">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-semibold text-gray-900">Aktivitas Mingguan</h3>
                </div>
                <div class="h-64">
                    <canvas id="activityChart"></canvas>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-200 chart-card opacity-0">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-semibold text-gray-900">Aktivitas Terbaru</h3>
                    <a href="#" class="text-sm text-blue-600 hover:text-blue-700">Lihat Semua</a>
                </div>
                <div class="space-y-4" id="recent-activities">
                    @foreach($recentActivities as $activity)
                    <div class="flex items-start space-x-3 activity-item opacity-0">
                        <div class="p-2 
                            @if($activity->type == 'provinsi') bg-blue-100 @endif
                            @if($activity->type == 'kabkota') bg-green-100 @endif
                            @if($activity->type == 'kodepos') bg-yellow-100 @endif
                            @if($activity->type == 'psr') bg-purple-100 @endif
                            rounded-full">
                            <i class="fas 
                                @if($activity->type == 'provinsi') fa-map text-blue-600 @endif
                                @if($activity->type == 'kabkota') fa-city text-green-600 @endif
                                @if($activity->type == 'kodepos') fa-mail-bulk text-yellow-600 @endif
                                @if($activity->type == 'psr') fa-building text-purple-600 @endif
                                text-sm"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900">
                                {{ $activity->type_label }}: {{ $activity->name }}
                            </p>
                            <p class="text-xs text-gray-500">
                                @if(isset($activity->province)){{ $activity->province }}@endif
                                @if(isset($activity->kabkota)) - {{ $activity->kabkota }}@endif
                                • {{ \Carbon\Carbon::parse($activity->updated_at)->diffForHumans() }}
                            </p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-200 mb-8 opacity-0" id="quick-actions">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Aksi Cepat</h3>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <a href="{{ route('provinsi.create') }}" class="flex flex-col items-center p-4 bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors duration-200 quick-action">
                    <i class="fas fa-plus-circle text-blue