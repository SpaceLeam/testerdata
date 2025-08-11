<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- SEO Meta Tags -->
    <title>Dashboard Analytics - Tendako | Pusat Data Wilayah Indonesia</title>
    <meta name="description" content="Dashboard monitoring dan analisis data wilayah Indonesia. Kelola data provinsi, kabupaten/kota, kode pos, dan PSR dengan visualisasi interaktif dan real-time analytics.">
    <meta name="keywords" content="dashboard indonesia, data wilayah, provinsi, kabupaten, kota, kode pos, PSR, analisis data, monitoring">
    <meta name="author" content="Tendako - Pusat Data & Informasi">
    <meta name="robots" content="index, follow">
    
    <!-- Open Graph Meta Tags -->
    <meta property="og:title" content="Dashboard Analytics - Tendako">
    <meta property="og:description" content="Platform monitoring dan analisis data wilayah Indonesia dengan visualisasi interaktif">
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://tendako.id/dashboard">
    <meta property="og:image" content="https://tendako.id/assets/dashboard-preview.jpg">
    
    <!-- Twitter Card Meta Tags -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Dashboard Analytics - Tendako">
    <meta name="twitter:description" content="Platform monitoring dan analisis data wilayah Indonesia">
    
    <!-- Structured Data -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "WebApplication",
        "name": "Tendako Dashboard",
        "description": "Platform dashboard untuk monitoring data wilayah Indonesia",
        "url": "https://tendako.id/dashboard",
        "applicationCategory": "BusinessApplication",
        "operatingSystem": "Web Browser"
    }
    </script>
    
    <!-- External Libraries -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.0/chart.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/3.2.1/anime.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    
    <!-- Custom Styles -->
    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --secondary-gradient: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            --success-gradient: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            --warning-gradient: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
        }
        
        .gradient-bg {
            background: var(--primary-gradient);
        }
        
        .card-hover {
            transition: all 0.3s ease;
            cursor: pointer;
        }
        
        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
        }
        
        .stat-card {
            background: linear-gradient(145deg, #ffffff 0%, #f8fafc 100%);
            border: 1px solid rgba(255,255,255,0.2);
            backdrop-filter: blur(10px);
        }
        
        .loading-skeleton {
            background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
            background-size: 200% 100%;
            animation: loading 1.5s infinite;
        }
        
        @keyframes loading {
            0% { background-position: 200% 0; }
            100% { background-position: -200% 0; }
        }
        
        .sidebar-gradient {
            background: linear-gradient(180deg, #1e3a8a 0%, #1e40af 50%, #2563eb 100%);
        }
        
        .floating-action {
            position: fixed;
            bottom: 2rem;
            right: 2rem;
            z-index: 1000;
        }
        
        .pulse-ring {
            animation: pulse-ring 2s cubic-bezier(0.455, 0.03, 0.515, 0.955) infinite;
        }
        
        @keyframes pulse-ring {
            0% {
                transform: scale(0.33);
                opacity: 1;
            }
            80%, 100% {
                transform: scale(1.8);
                opacity: 0;
            }
        }
        
        .chart-container {
            background: linear-gradient(145deg, #ffffff 0%, #f8fafc 100%);
        }
        
        .activity-item {
            transition: all 0.2s ease;
        }
        
        .activity-item:hover {
            background: rgba(59, 130, 246, 0.05);
            border-radius: 0.5rem;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-slate-50 to-blue-50 min-h-screen">
    <!-- Loading Screen -->
    <div id="loading-screen" class="fixed inset-0 gradient-bg flex items-center justify-center z-50">
        <div class="text-center text-white">
            <div class="w-16 h-16 border-4 border-white border-t-transparent rounded-full animate-spin mx-auto mb-4"></div>
            <h2 class="text-2xl font-bold mb-2">Loading Dashboard</h2>
            <p class="opacity-80">Memuat data analitik...</p>
        </div>
    </div>

    <!-- Mobile Menu Overlay -->
    <div id="mobile-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-40 hidden"></div>

    <!-- Mobile Menu Button -->
    <button onclick="toggleSidebar()" class="fixed top-4 left-4 z-50 sm:hidden bg-white p-3 rounded-lg shadow-lg">
        <i class="fas fa-bars text-gray-700"></i>
    </button>

    <!-- Sidebar -->
    <aside id="sidebar" class="fixed top-0 left-0 z-40 w-72 h-screen transition-all duration-300 -translate-x-full sm:translate-x-0 sidebar-gradient shadow-2xl">
        <div class="h-full px-6 py-6 overflow-y-auto">
            <!-- Logo Section -->
            <div class="flex items-center mb-12 px-2">
                <div class="bg-white bg-opacity-20 backdrop-blur-sm text-white p-3 rounded-xl mr-4 pulse-ring">
                    <i class="fas fa-database text-2xl"></i>
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-white">Tendako</h1>
                    <p class="text-blue-200 text-sm">Analytics Dashboard</p>
                </div>
            </div>

            <!-- Navigation Menu -->
            <nav class="space-y-3">
                <a href="#dashboard" class="nav-item active flex items-center p-4 text-white rounded-xl bg-white bg-opacity-20 backdrop-blur-sm">
                    <i class="fas fa-tachometer-alt mr-4 text-lg"></i>
                    <span class="font-medium">Dashboard</span>
                </a>
                <a href="#provinces" class="nav-item flex items-center p-4 text-blue-200 rounded-xl hover:bg-white hover:bg-opacity-10 transition-all">
                    <i class="fas fa-map mr-4 text-lg"></i>
                    <span class="font-medium">Data Provinsi</span>
                </a>
                <a href="#cities" class="nav-item flex items-center p-4 text-blue-200 rounded-xl hover:bg-white hover:bg-opacity-10 transition-all">
                    <i class="fas fa-city mr-4 text-lg"></i>
                    <span class="font-medium">Kabupaten/Kota</span>
                </a>
                <a href="#postal" class="nav-item flex items-center p-4 text-blue-200 rounded-xl hover:bg-white hover:bg-opacity-10 transition-all">
                    <i class="fas fa-mail-bulk mr-4 text-lg"></i>
                    <span class="font-medium">Kode Pos</span>
                </a>
                <a href="#psr" class="nav-item flex items-center p-4 text-blue-200 rounded-xl hover:bg-white hover:bg-opacity-10 transition-all">
                    <i class="fas fa-building mr-4 text-lg"></i>
                    <span class="font-medium">Data PSR</span>
                </a>
            </nav>

            <!-- Bottom Section -->
            <div class="absolute bottom-6 left-6 right-6 space-y-2">
                <div class="border-t border-blue-300 border-opacity-30 pt-4">
                    <a href="#settings" class="flex items-center p-3 text-blue-200 rounded-lg hover:bg-white hover:bg-opacity-10 transition-all">
                        <i class="fas fa-cog mr-3"></i>
                        <span>Pengaturan</span>
                    </a>
                    <a href="#logout" class="flex items-center p-3 text-blue-200 rounded-lg hover:bg-white hover:bg-opacity-10 transition-all">
                        <i class="fas fa-sign-out-alt mr-3"></i>
                        <span>Keluar</span>
                    </a>
                </div>
            </div>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="sm:ml-72 transition-all duration-300">
        <!-- Header Section -->
        <header class="bg-white bg-opacity-80 backdrop-blur-sm sticky top-0 z-30 border-b border-gray-200">
            <div class="px-6 py-4">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-3xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">
                            Dashboard Analytics
                        </h1>
                        <p class="text-gray-600 mt-1">Monitoring real-time data wilayah Indonesia</p>
                    </div>
                    <div class="flex items-center space-x-4">
                        <button onclick="refreshData()" class="px-6 py-3 gradient-bg text-white rounded-xl hover:shadow-lg transition-all duration-300 flex items-center space-x-2">
                            <i class="fas fa-sync-alt"></i>
                            <span>Refresh Data</span>
                        </button>
                        <div class="relative">
                            <button class="p-3 bg-gray-100 rounded-xl hover:bg-gray-200 transition-colors">
                                <i class="fas fa-bell text-gray-600"></i>
                                <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">3</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Content Area -->
        <div class="p-6">
            <!-- Stats Cards -->
            <section class="mb-8" aria-label="Statistics Overview">
                <h2 class="text-xl font-semibold text-gray-800 mb-6">Ringkasan Data</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <!-- Provinsi Card -->
                    <div class="stat-card rounded-2xl p-6 card-hover">
                        <div class="flex items-center justify-between">
                            <div>
                                <div class="p-4 bg-gradient-to-r from-blue-500 to-blue-600 rounded-xl shadow-lg">
                                    <i class="fas fa-map text-white text-2xl"></i>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-sm text-gray-600 mb-1">Total Provinsi</p>
                                <p class="text-3xl font-bold text-gray-900" id="provinsi-count">38</p>
                                <p class="text-xs text-green-600 flex items-center justify-end mt-1">
                                    <i class="fas fa-arrow-up mr-1"></i>
                                    <span id="provinsi-growth">+2</span> bulan ini
                                </p>
                            </div>
                        </div>
                        <div class="mt-4 bg-blue-50 rounded-lg p-3">
                            <div class="flex justify-between items-center text-sm">
                                <span class="text-blue-600">Progress</span>
                                <span class="font-semibold text-blue-700">100%</span>
                            </div>
                            <div class="w-full bg-blue-200 rounded-full h-2 mt-2">
                                <div class="bg-blue-600 h-2 rounded-full" style="width: 100%"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Kabkota Card -->
                    <div class="stat-card rounded-2xl p-6 card-hover">
                        <div class="flex items-center justify-between">
                            <div>
                                <div class="p-4 bg-gradient-to-r from-green-500 to-green-600 rounded-xl shadow-lg">
                                    <i class="fas fa-city text-white text-2xl"></i>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-sm text-gray-600 mb-1">Kabupaten/Kota</p>
                                <p class="text-3xl font-bold text-gray-900" id="kabkota-count">514</p>
                                <p class="text-xs text-green-600 flex items-center justify-end mt-1">
                                    <i class="fas fa-arrow-up mr-1"></i>
                                    <span id="kabkota-growth">+12</span> bulan ini
                                </p>
                            </div>
                        </div>
                        <div class="mt-4 bg-green-50 rounded-lg p-3">
                            <div class="flex justify-between items-center text-sm">
                                <span class="text-green-600">Coverage</span>
                                <span class="font-semibold text-green-700">98%</span>
                            </div>
                            <div class="w-full bg-green-200 rounded-full h-2 mt-2">
                                <div class="bg-green-600 h-2 rounded-full" style="width: 98%"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Kodepos Card -->
                    <div class="stat-card rounded-2xl p-6 card-hover">
                        <div class="flex items-center justify-between">
                            <div>
                                <div class="p-4 bg-gradient-to-r from-yellow-500 to-yellow-600 rounded-xl shadow-lg">
                                    <i class="fas fa-mail-bulk text-white text-2xl"></i>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-sm text-gray-600 mb-1">Kode Pos</p>
                                <p class="text-3xl font-bold text-gray-900" id="kodepos-count">6,794</p>
                                <p class="text-xs text-green-600 flex items-center justify-end mt-1">
                                    <i class="fas fa-arrow-up mr-1"></i>
                                    <span id="kodepos-growth">+156</span> bulan ini
                                </p>
                            </div>
                        </div>
                        <div class="mt-4 bg-yellow-50 rounded-lg p-3">
                            <div class="flex justify-between items-center text-sm">
                                <span class="text-yellow-600">Aktif</span>
                                <span class="font-semibold text-yellow-700">95%</span>
                            </div>
                            <div class="w-full bg-yellow-200 rounded-full h-2 mt-2">
                                <div class="bg-yellow-600 h-2 rounded-full" style="width: 95%"></div>
                            </div>
                        </div>
                    </div>

                    <!-- PSR Card -->
                    <div class="stat-card rounded-2xl p-6 card-hover">
                        <div class="flex items-center justify-between">
                            <div>
                                <div class="p-4 bg-gradient-to-r from-purple-500 to-purple-600 rounded-xl shadow-lg">
                                    <i class="fas fa-building text-white text-2xl"></i>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-sm text-gray-600 mb-1">Total PSR</p>
                                <p class="text-3xl font-bold text-gray-900" id="psr-count">1,247</p>
                                <p class="text-xs text-green-600 flex items-center justify-end mt-1">
                                    <i class="fas fa-arrow-up mr-1"></i>
                                    <span id="psr-growth">+45</span> bulan ini
                                </p>
                            </div>
                        </div>
                        <div class="mt-4 bg-purple-50 rounded-lg p-3">
                            <div class="flex justify-between items-center text-sm">
                                <span class="text-purple-600">Operasional</span>
                                <span class="font-semibold text-purple-700">92%</span>
                            </div>
                            <div class="w-full bg-purple-200 rounded-full h-2 mt-2">
                                <div class="bg-purple-600 h-2 rounded-full" style="width: 92%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Charts Section -->
            <section class="mb-8">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Province Distribution Chart -->
                    <div class="chart-container rounded-2xl p-6 shadow-lg border">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-xl font-semibold text-gray-800">Distribusi Top 10 Provinsi</h3>
                            <button class="text-gray-400 hover:text-gray-600">
                                <i class="fas fa-expand-arrows-alt"></i>
                            </button>
                        </div>
                        <div class="relative h-80">
                            <canvas id="provinceChart"></canvas>
                        </div>
                    </div>

                    <!-- Growth Trend Chart -->
                    <div class="chart-container rounded-2xl p-6 shadow-lg border">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-xl font-semibold text-gray-800">Trend Pertumbuhan 6 Bulan</h3>
                            <select id="period-selector" class="px-3 py-2 border border-gray-300 rounded-lg text-sm">
                                <option value="6">6 Bulan</option>
                                <option value="12">12 Bulan</option>
                                <option value="24">24 Bulan</option>
                            </select>
                        </div>
                        <div class="relative h-80">
                            <canvas id="growthChart"></canvas>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Bottom Section -->
            <section class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Composition Chart -->
                <div class="chart-container rounded-2xl p-6 shadow-lg border">
                    <h3 class="text-xl font-semibold text-gray-800 mb-6">Komposisi Data</h3>
                    <div class="relative h-64">
                        <canvas id="compositionChart"></canvas>
                    </div>
                    <div class="mt-4 grid grid-cols-2 gap-4 text-sm">
                        <div class="flex items-center">
                            <div class="w-3 h-3 bg-blue-500 rounded-full mr-2"></div>
                            <span class="text-gray-600">Provinsi</span>
                        </div>
                        <div class="flex items-center">
                            <div class="w-3 h-3 bg-green-500 rounded-full mr-2"></div>
                            <span class="text-gray-600">Kabkota</span>
                        </div>
                        <div class="flex items-center">
                            <div class="w-3 h-3 bg-yellow-500 rounded-full mr-2"></div>
                            <span class="text-gray-600">Kodepos</span>
                        </div>
                        <div class="flex items-center">
                            <div class="w-3 h-3 bg-purple-500 rounded-full mr-2"></div>
                            <span class="text-gray-600">PSR</span>
                        </div>
                    </div>
                </div>

                <!-- Recent Activities -->
                <div class="lg:col-span-2 chart-container rounded-2xl p-6 shadow-lg border">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-xl font-semibold text-gray-800">Aktivitas Terbaru</h3>
                        <button onclick="loadActivities()" class="text-blue-600 hover:text-blue-700 text-sm font-medium">
                            Lihat Semua
                        </button>
                    </div>
                    <div id="activities-container" class="space-y-4 max-h-64 overflow-y-auto">
                        <!-- Activities will be loaded here -->
                        <div class="loading-skeleton h-16 rounded-lg"></div>
                        <div class="loading-skeleton h-16 rounded-lg"></div>
                        <div class="loading-skeleton h-16 rounded-lg"></div>
                    </div>
                </div>
            </section>
        </div>
    </main>

    <!-- Floating Action Button -->
    <div class="floating-action">
        <button onclick="exportData()" class="bg-blue-600 hover:bg-blue-700 text-white p-4 rounded-full shadow-lg transition-all duration-300 hover:shadow-xl">
            <i class="fas fa-download text-xl"></i>
        </button>
    </div>

    <!-- Scripts -->
    <script>
        // Global variables
        let charts = {};
        let dashboardData = {};
        
        // Initialize dashboard
        document.addEventListener('DOMContentLoaded', function() {
            initializeDashboard();
        });

        async function initializeDashboard() {
            try {
                // Simulate loading time
                await new Promise(resolve => setTimeout(resolve, 2000));
                
                // Hide loading screen with animation
                anime({
                    targets: '#loading-screen',
                    opacity: 0,
                    scale: 0.8,
                    duration: 800,
                    easing: 'easeOutExpo',
                    complete: function() {
                        document.getElementById('loading-screen').style.display = 'none';
                    }
                });

                // Animate main content
                anime.timeline({
                    easing: 'easeOutExpo'
                })
                .add({
                    targets: '.stat-card',
                    translateY: [50, 0],
                    opacity: [0, 1],
                    delay: anime.stagger(100),
                    duration: 800
                })
                .add({
                    targets: '.chart-container',
                    translateY: [30, 0],
                    opacity: [0, 1],
                    delay: anime.stagger(150),
                    duration: 600
                }, '-=400');

                // Load data and initialize charts
                await loadDashboardData();
                initializeCharts();
                loadActivities();
                
                // Setup periodic data refresh
                setInterval(refreshData, 30000); // Refresh every 30 seconds
                
            } catch (error) {
                console.error('Error initializing dashboard:', error);
                showError('Gagal memuat dashboard. Silakan refresh halaman.');
            }
        }

        async function loadDashboardData() {
            try {
                // Simulate API call to Laravel controller
                // In real implementation, replace with actual API endpoints
                
                // Mock data based on controller structure
                dashboardData = {
                    stats: {
                        provinsi: { total: 38, new_this_month: 2 },
                        kabkota: { total: 514, new_this_month: 12 },
                        kodepos: { total: 6794, new_this_month: 156 },
                        psr: { total: 1247, new_this_month: 45 }
                    },
                    provinceDistribution: {
                        labels: ['Jawa Barat', 'Jawa Timur', 'Jawa Tengah', 'Sumatera Utara', 'Sulawesi Selatan', 'Lampung', 'Kalimantan Timur', 'Sumatera Selatan', 'Banten', 'Riau'],
                        data: [27, 38, 35, 33, 24, 15, 10, 17, 8, 12]
                    },
                    growthTrend: {
                        labels: ['Jan 2025', 'Feb 2025', 'Mar 2025', 'Apr 2025', 'Mei 2025', 'Jun 2025'],
                        provinsi: [36, 36, 37, 37, 38, 38],
                        kabkota: [502, 504, 508, 510, 512, 514],
                        kodepos: [6500, 6580, 6650, 6720, 6750, 6794],
                        psr: [1150, 1180, 1200, 1220, 1235, 1247]
                    }
                };

                // Update stat cards with animation
                updateStatCards();
                
            } catch (error) {
                console.error('Error loading dashboard data:', error);
                throw error;
            }
        }

        function updateStatCards() {
            const stats = dashboardData.stats;
            
            // Update counts with animation
            animateCounter('provinsi-count', stats.provinsi.total);
            animateCounter('kabkota-count', stats.kabkota.total);
            animateCounter('kodepos-count', stats.kodepos.total);
            animateCounter('psr-count', stats.psr.total);
            
            // Update growth numbers
            document.getElementById('provinsi-growth').textContent = `+${stats.provinsi.new_this_month}`;
            document.getElementById('kabkota-growth').textContent = `+${stats.kabkota.new_this_month}`;
            document.getElementById('kodepos-growth').textContent = `+${stats.kodepos.new_this_month}`;
            document.getElementById('psr-growth').textContent = `+${stats.psr.new_this_month}`;
        }

        function animateCounter(elementId, targetValue) {
            const element = document.getElementById(elementId);
            const startValue = 0;
            const duration = 2000;
            
            anime({
                targets: { count: startValue },
                count: targetValue,
                duration: duration,
                easing: 'easeOutCubic',
                update: function(anim) {
                    const value = Math.round(anim.animatables[0].target.count);
                    element.textContent = value.toLocaleString('id-ID');
                }
            });
        }

        function initializeCharts() {
            // Province Distribution Chart
            const ctx1 = document.getElementById('provinceChart').getContext('2d');
            charts.province = new Chart(ctx1, {
                type: 'bar',
                data: {
                    labels: dashboardData.provinceDistribution.labels,
                    datasets: [{
                        label: 'Jumlah Kabupaten/Kota',
                        data: dashboardData.provinceDistribution.data,
                        backgroundColor: 'rgba(59, 130, 246, 0.8)',
                        borderColor: 'rgba(59, 130, 246, 1)',
                        borderWidth: 2,
                        borderRadius: 8,
                        borderSkipped: false,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: 'rgba(0, 0, 0, 0.8)',
                            titleColor: 'white',
                            bodyColor: 'white',
                            borderColor: 'rgba(59, 130, 246, 1)',
                            borderWidth: 1
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: 'rgba(0, 0, 0, 0.05)'
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            }
                        }
                    }
                }
            });

            // Growth Trend Chart
            const ctx2 = document.getElementById('growthChart').getContext('2d');
            charts.growth = new Chart(ctx2, {
                type: 'line',
                data: {
                    labels: dashboardData.growthTrend.labels,
                    datasets: [
                        {
                            label: 'Provinsi',
                            data: dashboardData.growthTrend.provinsi,
                            borderColor: 'rgb(59, 130, 246)',
                            backgroundColor: 'rgba(59, 130, 246, 0.1)',
                            tension: 0.4,
                            fill: true,
                            pointBackgroundColor: 'rgb(59, 130, 246)',
                            pointBorderColor: '#fff',
                            pointBorderWidth: 2,
                            pointRadius: 6
                        },
                        {
                            label: 'Kabupaten/Kota',
                            data: dashboardData.growthTrend.kabkota,
                            borderColor: 'rgb(34, 197, 94)',
                            backgroundColor: 'rgba(34, 197, 94, 0.1)',
                            tension: 0.4,
                            fill: true,
                            pointBackgroundColor: 'rgb(34, 197, 94)',
                            pointBorderColor: '#fff',
                            pointBorderWidth: 2,
                            pointRadius: 6
                        },
                        {
                            label: 'Kode Pos',
                            data: dashboardData.growthTrend.kodepos,
                            borderColor: 'rgb(234, 179, 8)',
                            backgroundColor: 'rgba(234, 179, 8, 0.1)',
                            tension: 0.4,
                            fill: true,
                            pointBackgroundColor: 'rgb(234, 179, 8)',
                            pointBorderColor: '#fff',
                            pointBorderWidth: 2,
                            pointRadius: 6
                        },
                        {
                            label: 'PSR',
                            data: dashboardData.growthTrend.psr,
                            borderColor: 'rgb(168, 85, 247)',
                            backgroundColor: 'rgba(168, 85, 247, 0.1)',
                            tension: 0.4,
                            fill: true,
                            pointBackgroundColor: 'rgb(168, 85, 247)',
                            pointBorderColor: '#fff',
                            pointBorderWidth: 2,
                            pointRadius: 6
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    interaction: {
                        intersect: false,
                        mode: 'index'
                    },
                    plugins: {
                        legend: {
                            position: 'top',
                            labels: {
                                usePointStyle: true,
                                padding: 20
                            }
                        },
                        tooltip: {
                            backgroundColor: 'rgba(0, 0, 0, 0.8)',
                            titleColor: 'white',
                            bodyColor: 'white',
                            borderColor: 'rgba(255, 255, 255, 0.2)',
                            borderWidth: 1
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: 'rgba(0, 0, 0, 0.05)'
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            }
                        }
                    }
                }
            });

            // Composition Chart
            const ctx3 = document.getElementById('compositionChart').getContext('2d');
            charts.composition = new Chart(ctx3, {
                type: 'doughnut',
                data: {
                    labels: ['Provinsi', 'Kabupaten/Kota', 'Kode Pos', 'PSR'],
                    datasets: [{
                        data: [
                            dashboardData.stats.provinsi.total,
                            dashboardData.stats.kabkota.total,
                            dashboardData.stats.kodepos.total,
                            dashboardData.stats.psr.total
                        ],
                        backgroundColor: [
                            'rgba(59, 130, 246, 0.8)',
                            'rgba(34, 197, 94, 0.8)',
                            'rgba(234, 179, 8, 0.8)',
                            'rgba(168, 85, 247, 0.8)'
                        ],
                        borderColor: [
                            'rgb(59, 130, 246)',
                            'rgb(34, 197, 94)',
                            'rgb(234, 179, 8)',
                            'rgb(168, 85, 247)'
                        ],
                        borderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '60%',
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            backgroundColor: 'rgba(0, 0, 0, 0.8)',
                            titleColor: 'white',
                            bodyColor: 'white',
                            callbacks: {
                                label: function(context) {
                                    const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                    const percentage = ((context.parsed / total) * 100).toFixed(1);
                                    return `${context.label}: ${context.parsed.toLocaleString('id-ID')} (${percentage}%)`;
                                }
                            }
                        }
                    }
                }
            });

            // Add animation to charts
            anime({
                targets: '.chart-container canvas',
                opacity: [0, 1],
                scale: [0.8, 1],
                duration: 1000,
                delay: anime.stagger(200),
                easing: 'easeOutExpo'
            });
        }

        async function loadActivities() {
            try {
                // Simulate loading activities from controller
                const activities = [
                    {
                        type: 'provinsi',
                        type_label: 'Data Provinsi',
                        name: 'Provinsi Papua Tengah',
                        created_at: '2 jam lalu',
                        icon: 'fas fa-map',
                        color: 'blue'
                    },
                    {
                        type: 'kabkota',
                        type_label: 'Data Kabupaten',
                        name: 'Kabupaten Maybrat',
                        province: 'Papua Barat Daya',
                        created_at: '4 jam lalu',
                        icon: 'fas fa-city',
                        color: 'green'
                    },
                    {
                        type: 'kodepos',
                        type_label: 'Data Kode Pos',
                        name: 'Kelurahan Ayamaru',
                        kodepos_kdp: '98051',
                        kabkota: 'Kabupaten Maybrat',
                        created_at: '6 jam lalu',
                        icon: 'fas fa-mail-bulk',
                        color: 'yellow'
                    },
                    {
                        type: 'psr',
                        type_label: 'Data PSR',
                        name: 'PT. Pos Indonesia Cabang Sorong',
                        cbg_psr: 'SRG001',
                        kabkota: 'Kota Sorong',
                        created_at: '8 jam lalu',
                        icon: 'fas fa-building',
                        color: 'purple'
                    },
                    {
                        type: 'provinsi',
                        type_label: 'Data Provinsi',
                        name: 'Provinsi Papua Selatan',
                        created_at: '12 jam lalu',
                        icon: 'fas fa-map',
                        color: 'blue'
                    }
                ];

                const container = document.getElementById('activities-container');
                
                // Animate out loading skeletons
                anime({
                    targets: '.loading-skeleton',
                    opacity: 0,
                    duration: 300,
                    complete: function() {
                        container.innerHTML = '';
                        
                        // Render activities
                        activities.forEach((activity, index) => {
                            const activityHTML = createActivityItem(activity);
                            container.appendChild(activityHTML);
                        });

                        // Animate in activities
                        anime({
                            targets: '.activity-item',
                            translateX: [-30, 0],
                            opacity: [0, 1],
                            delay: anime.stagger(100),
                            duration: 600,
                            easing: 'easeOutExpo'
                        });
                    }
                });

            } catch (error) {
                console.error('Error loading activities:', error);
                showError('Gagal memuat aktivitas terbaru');
            }
        }

        function createActivityItem(activity) {
            const item = document.createElement('div');
            item.className = 'activity-item flex items-start space-x-4 p-4 rounded-lg border border-gray-100 hover:bg-gray-50 transition-all cursor-pointer';
            
            const colorClasses = {
                blue: 'bg-blue-100 text-blue-600',
                green: 'bg-green-100 text-green-600',
                yellow: 'bg-yellow-100 text-yellow-600',
                purple: 'bg-purple-100 text-purple-600'
            };

            item.innerHTML = `
                <div class="p-3 ${colorClasses[activity.color]} rounded-xl">
                    <i class="${activity.icon} text-lg"></i>
                </div>
                <div class="flex-1">
                    <div class="flex items-center justify-between">
                        <h4 class="font-semibold text-gray-900">${activity.name}</h4>
                        <span class="text-xs text-gray-500">${activity.created_at}</span>
                    </div>
                    <p class="text-sm text-gray-600 mt-1">${activity.type_label}</p>
                    ${activity.province ? `<p class="text-xs text-gray-500 mt-1">${activity.province}</p>` : ''}
                    ${activity.kabkota ? `<p class="text-xs text-gray-500 mt-1">${activity.kabkota}</p>` : ''}
                    ${activity.kodepos_kdp ? `<span class="inline-block bg-gray-100 text-gray-700 text-xs px-2 py-1 rounded-full mt-2">${activity.kodepos_kdp}</span>` : ''}
                    ${activity.cbg_psr ? `<span class="inline-block bg-gray-100 text-gray-700 text-xs px-2 py-1 rounded-full mt-2">${activity.cbg_psr}</span>` : ''}
                </div>
            `;

            return item;
        }

        async function refreshData() {
            try {
                // Show loading indicator
                const refreshBtn = document.querySelector('[onclick="refreshData()"]');
                const originalContent = refreshBtn.innerHTML;
                refreshBtn.innerHTML = '<i class="fas fa-spinner animate-spin"></i><span>Memuat...</span>';
                refreshBtn.disabled = true;

                // Simulate API calls to refresh data
                await loadDashboardData();
                
                // Update charts
                Object.keys(charts).forEach(chartKey => {
                    if (charts[chartKey]) {
                        charts[chartKey].update('none');
                    }
                });

                // Reload activities
                await loadActivities();

                // Show success message
                showNotification('Data berhasil diperbarui', 'success');

                // Restore button
                refreshBtn.innerHTML = originalContent;
                refreshBtn.disabled = false;

            } catch (error) {
                console.error('Error refreshing data:', error);
                showError('Gagal memperbarui data');
                
                // Restore button
                const refreshBtn = document.querySelector('[onclick="refreshData()"]');
                refreshBtn.innerHTML = '<i class="fas fa-sync-alt"></i><span>Refresh</span>';
                refreshBtn.disabled = false;
            }
        }

        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('mobile-overlay');
            
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
            
            // Animate sidebar
            if (!sidebar.classList.contains('-translate-x-full')) {
                anime({
                    targets: sidebar,
                    translateX: [-280, 0],
                    duration: 300,
                    easing: 'easeOutCubic'
                });
            }
        }

        function exportData() {
            // Show export options
            const options = [
                { label: 'Export PDF', icon: 'fas fa-file-pdf', action: () => exportToPDF() },
                { label: 'Export Excel', icon: 'fas fa-file-excel', action: () => exportToExcel() },
                { label: 'Export CSV', icon: 'fas fa-file-csv', action: () => exportToCSV() }
            ];

            showExportModal(options);
        }

        function showExportModal(options) {
            // Create modal overlay
            const overlay = document.createElement('div');
            overlay.className = 'fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center';
            
            const modal = document.createElement('div');
            modal.className = 'bg-white rounded-2xl p-6 max-w-sm w-full mx-4 transform scale-95 opacity-0';
            
            modal.innerHTML = `
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Pilih Format Export</h3>
                <div class="space-y-3">
                    ${options.map(option => `
                        <button onclick="${option.action.name}()" class="w-full flex items-center space-x-3 p-3 text-left rounded-lg hover:bg-gray-50 transition-colors">
                            <i class="${option.icon} text-xl text-gray-600"></i>
                            <span class="font-medium">${option.label}</span>
                        </button>
                    `).join('')}
                </div>
                <button onclick="closeModal()" class="w-full mt-4 px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors">
                    Batal
                </button>
            `;
            
            overlay.appendChild(modal);
            document.body.appendChild(overlay);
            
            // Animate modal
            anime({
                targets: modal,
                scale: [0.95, 1],
                opacity: [0, 1],
                duration: 300,
                easing: 'easeOutBack'
            });
            
            // Close on overlay click
            overlay.addEventListener('click', (e) => {
                if (e.target === overlay) closeModal();
            });
            
            // Store reference for closing
            window.currentModal = overlay;
        }

        function closeModal() {
            if (window.currentModal) {
                anime({
                    targets: window.currentModal.firstElementChild,
                    scale: 0.95,
                    opacity: 0,
                    duration: 200,
                    complete: function() {
                        document.body.removeChild(window.currentModal);
                        window.currentModal = null;
                    }
                });
            }
        }

        function exportToPDF() {
            showNotification('Mengekspor ke PDF...', 'info');
            closeModal();
            // Implement PDF export logic here
            setTimeout(() => {
                showNotification('Data berhasil diekspor ke PDF', 'success');
            }, 2000);
        }

        function exportToExcel() {
            showNotification('Mengekspor ke Excel...', 'info');
            closeModal();
            // Implement Excel export logic here
            setTimeout(() => {
                showNotification('Data berhasil diekspor ke Excel', 'success');
            }, 2000);
        }

        function exportToCSV() {
            showNotification('Mengekspor ke CSV...', 'info');
            closeModal();
            // Implement CSV export logic here
            setTimeout(() => {
                showNotification('Data berhasil diekspor ke CSV', 'success');
            }, 2000);
        }

        function showNotification(message, type = 'info') {
            const notification = document.createElement('div');
            notification.className = `fixed top-4 right-4 z-50 px-6 py-4 rounded-lg shadow-lg transform translate-x-full transition-all duration-300`;
            
            const colors = {
                success: 'bg-green-500 text-white',
                error: 'bg-red-500 text-white',
                info: 'bg-blue-500 text-white',
                warning: 'bg-yellow-500 text-white'
            };
            
            const icons = {
                success: 'fas fa-check-circle',
                error: 'fas fa-exclamation-circle',
                info: 'fas fa-info-circle',
                warning: 'fas fa-exclamation-triangle'
            };
            
            notification.className += ` ${colors[type]}`;
            notification.innerHTML = `
                <div class="flex items-center space-x-3">
                    <i class="${icons[type]}"></i>
                    <span>${message}</span>
                </div>
            `;
            
            document.body.appendChild(notification);
            
            // Animate in
            setTimeout(() => {
                notification.style.transform = 'translateX(0)';
            }, 100);
            
            // Auto remove
            setTimeout(() => {
                notification.style.transform = 'translateX(100%)';
                setTimeout(() => {
                    if (document.body.contains(notification)) {
                        document.body.removeChild(notification);
                    }
                }, 300);
            }, 3000);
        }

        function showError(message) {
            showNotification(message, 'error');
        }

        // Period selector for growth chart
        document.addEventListener('change', function(e) {
            if (e.target.id === 'period-selector') {
                updateGrowthChart(parseInt(e.target.value));
            }
        });

        async function updateGrowthChart(months) {
            try {
                // Simulate API call to get growth data with different periods
                // In real implementation: fetch(`/api/growth-trend/${months}`)
                
                const chart = charts.growth;
                if (chart) {
                    // Animate chart update
                    anime({
                        targets: chart.canvas,
                        opacity: [1, 0.5, 1],
                        duration: 600,
                        complete: function() {
                            // Update chart data here
                            chart.update();
                        }
                    });
                }
                
                showNotification(`Chart diperbarui untuk ${months} bulan terakhir`, 'success');
                
            } catch (error) {
                console.error('Error updating growth chart:', error);
                showError('Gagal memperbarui chart pertumbuhan');
            }
        }

        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', function(e) {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('mobile-overlay');
            
            if (overlay && !overlay.classList.contains('hidden') && e.target === overlay) {
                toggleSidebar();
            }
        });

        // Add keyboard shortcuts
        document.addEventListener('keydown', function(e) {
            // Ctrl/Cmd + R for refresh
            if ((e.ctrlKey || e.metaKey) && e.key === 'r') {
                e.preventDefault();
                refreshData();
            }
            
            // Escape to close modals
            if (e.key === 'Escape') {
                if (window.currentModal) closeModal();
                
                const sidebar = document.getElementById('sidebar');
                const overlay = document.getElementById('mobile-overlay');
                if (!overlay.classList.contains('hidden')) {
                    toggleSidebar();
                }
            }
        });

        // Add smooth scrolling for anchor links
        document.addEventListener('click', function(e) {
            if (e.target.tagName === 'A' && e.target.getAttribute('href').startsWith('#')) {
                e.preventDefault();
                const target = document.querySelector(e.target.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({ behavior: 'smooth' });
                }
            }
        });

        // Performance monitoring
        window.addEventListener('load', function() {
            const loadTime = performance.now();
            console.log(`Dashboard loaded in ${Math.round(loadTime)}ms`);
            
            // Log performance to analytics (if needed)
            if (window.gtag) {
                gtag('event', 'timing_complete', {
                    name: 'dashboard_load',
                    value: Math.round(loadTime)
                });
            }
        });

        // Service worker registration for PWA (optional)
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', function() {
                navigator.serviceWorker.register('/sw.js')
                    .then(function(registration) {
                        console.log('ServiceWorker registration successful');
                    })
                    .catch(function(err) {
                        console.log('ServiceWorker registration failed: ', err);
                    });
            });
        }
    </script>

    <!-- Schema.org structured data for SEO -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "Dashboard",
        "name": "Tendako Analytics Dashboard",
        "description": "Real-time monitoring dashboard for Indonesian regional data including provinces, regencies, postal codes, and PSR data",
        "url": "https://tendako.id/dashboard",
        "creator": {
            "@type": "Organization",
            "name": "Tendako",
            "url": "https://tendako.id"
        },
        "dateModified": "2025-08-11",
        "inLanguage": "id-ID",
        "about": [
            {
                "@type": "Thing",
                "name": "Indonesian Provincial Data"
            },
            {
                "@type": "Thing", 
                "name": "Regional Analytics"
            },
            {
                "@type": "Thing",
                "name": "Postal Code Management"
            }
        ]
    }
    </script>
</body>
</html>