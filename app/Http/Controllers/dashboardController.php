<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Display dashboard with statistics and charts data
     */
    public function index(Request $request)
    {
        // Get basic statistics
        $stats = $this->getBasicStats();
        
        // Get chart data
        $chartData = $this->getChartData();
        
        // Get recent activities
        $recentActivities = $this->getRecentActivities();
        
        // Get province distribution
        $provinceDistribution = $this->getProvinceDistribution();
        
        // Get growth trend (last 6 months)
        $growthTrend = $this->getGrowthTrend();

        return view('welcome', [
    'stats' => $stats,
    'chartData' => $chartData, 
    'recentActivities' => $recentActivities,
    'provinceDistribution' => $provinceDistribution,
    'growthTrend' => $growthTrend
]);
    }
    /**
     * Get basic statistics for all data types
     */
    private function getBasicStats()
    {
        $stats = [
            'provinsi' => [
                'total' => DB::table('md_provinsi')->where('status_prv', 1)->count(),
                'new_this_month' => DB::table('md_provinsi')
                    ->where('status_prv', 1)
                    ->whereYear('created_at', Carbon::now()->year)
                    ->whereMonth('created_at', Carbon::now()->month)
                    ->count()
            ],
            'kabkota' => [
                'total' => DB::table('md_kabkota')->where('status_kbk', 1)->count(),
                'new_this_month' => DB::table('md_kabkota')
                    ->where('status_kbk', 1)
                    ->whereYear('created_at', Carbon::now()->year)
                    ->whereMonth('created_at', Carbon::now()->month)
                    ->count()
            ],
            'kodepos' => [
                'total' => DB::table('md_kodepos')->where('status_kdp', 1)->count(),
                'new_this_month' => DB::table('md_kodepos')
                    ->where('status_kdp', 1)
                    ->whereYear('created_at', Carbon::now()->year)
                    ->whereMonth('created_at', Carbon::now()->month)
                    ->count()
            ],
            'psr' => [
                'total' => DB::table('md_psr')->where('status_psr', 1)->count(),
                'new_this_month' => DB::table('md_psr')
                    ->where('status_psr', 1)
                    ->whereYear('created_at', Carbon::now()->year)
                    ->whereMonth('created_at', Carbon::now()->month)
                    ->count()
            ]
        ];

        return $stats;
    }

    /**
     * Get data for composition chart
     */
    private function getChartData()
    {
        return [
            'provinsi' => DB::table('md_provinsi')->where('status_prv', 1)->count(),
            'kabkota' => DB::table('md_kabkota')->where('status_kbk', 1)->count(),
            'kodepos' => DB::table('md_kodepos')->where('status_kdp', 1)->count(),
            'psr' => DB::table('md_psr')->where('status_psr', 1)->count()
        ];
    }

    /**
     * Get province distribution data (top 10 provinces by kabkota count)
     */
    private function getProvinceDistribution()
    {
        $distribution = DB::table('md_kabkota')
            ->select('md_provinsi.namadagri_prv', DB::raw('COUNT(md_kabkota.kodedagri_kbk) as jumlah_kabkota'))
            ->leftJoin('md_provinsi', 'md_kabkota.kodedagri_prv', '=', 'md_provinsi.kodedagri_prv')
            ->where('md_kabkota.status_kbk', 1)
            ->where('md_provinsi.status_prv', 1)
            ->groupBy('md_provinsi.kodedagri_prv', 'md_provinsi.namadagri_prv')
            ->orderBy('jumlah_kabkota', 'desc')
            ->limit(10)
            ->get();

        return [
            'labels' => $distribution->pluck('namadagri_prv')->toArray(),
            'data' => $distribution->pluck('jumlah_kabkota')->toArray()
        ];
    }

    /**
     * Get growth trend data for the last 6 months
     */
    private function getGrowthTrend()
    {
        $months = [];
        $provinsiData = [];
        $kabkotaData = [];
        $kodeposData = [];
        $psrData = [];

        // Generate last 6 months
        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $months[] = $date->format('M Y');

            // Count data up to each month
            $provinsiData[] = DB::table('md_provinsi')
                ->where('status_prv', 1)
                ->where('created_at', '<=', $date->endOfMonth())
                ->count();

            $kabkotaData[] = DB::table('md_kabkota')
                ->where('status_kbk', 1)
                ->where('created_at', '<=', $date->endOfMonth())
                ->count();

            $kodeposData[] = DB::table('md_kodepos')
                ->where('status_kdp', 1)
                ->where('created_at', '<=', $date->endOfMonth())
                ->count();

            $psrData[] = DB::table('md_psr')
                ->where('status_psr', 1)
                ->where('created_at', '<=', $date->endOfMonth())
                ->count();
        }

        return [
            'labels' => $months,
            'provinsi' => $provinsiData,
            'kabkota' => $kabkotaData,
            'kodepos' => $kodeposData,
            'psr' => $psrData
        ];
    }

    /**
     * Get recent activities from all tables
     */
    private function getRecentActivities()
    {
        $activities = collect();

        // Recent provinsi activities
        $provinsiActivities = DB::table('md_provinsi')
            ->select(
                'namadagri_prv as name',
                'created_at',
                'updated_at',
                DB::raw("'provinsi' as type"),
                DB::raw("'Data Provinsi' as type_label")
            )
            ->where('status_prv', 1)
            ->orderBy('updated_at', 'desc')
            ->limit(3)
            ->get();

        // Recent kabkota activities
        $kabkotaActivities = DB::table('md_kabkota')
            ->select(
                'md_kabkota.namadagri_kbk as name',
                'md_kabkota.created_at',
                'md_kabkota.updated_at',
                'md_provinsi.namadagri_prv as province',
                DB::raw("'kabkota' as type"),
                DB::raw("'Data Kabkota' as type_label")
            )
            ->leftJoin('md_provinsi', 'md_kabkota.kodedagri_prv', '=', 'md_provinsi.kodedagri_prv')
            ->where('md_kabkota.status_kbk', 1)
            ->orderBy('md_kabkota.updated_at', 'desc')
            ->limit(3)
            ->get();

        // Recent kodepos activities
        $kodeposActivities = DB::table('md_kodepos')
            ->select(
                'md_kodepos.kel_kdp as name',
                'md_kodepos.kodepos_kdp',
                'md_kodepos.created_at',
                'md_kodepos.updated_at',
                'md_provinsi.namadagri_prv as province',
                'md_kabkota.namadagri_kbk as kabkota',
                DB::raw("'kodepos' as type"),
                DB::raw("'Data Kodepos' as type_label")
            )
            ->leftJoin('md_provinsi', 'md_kodepos.kodedagri_prv', '=', 'md_provinsi.kodedagri_prv')
            ->leftJoin('md_kabkota', 'md_kodepos.kodedagri_kbk', '=', 'md_kabkota.kodedagri_kbk')
            ->where('md_kodepos.status_kdp', 1)
            ->orderBy('md_kodepos.updated_at', 'desc')
            ->limit(3)
            ->get();

        // Recent PSR activities
        $psrActivities = DB::table('md_psr')
            ->select(
                'md_psr.alamat_psr as name',
                'md_psr.cbg_psr',
                'md_psr.created_at',
                'md_psr.updated_at',
                'md_provinsi.namadagri_prv as province',
                'md_kabkota.namadagri_kbk as kabkota',
                DB::raw("'psr' as type"),
                DB::raw("'Data PSR' as type_label")
            )
            ->leftJoin('md_kodepos', 'md_psr.id_kdp', '=', 'md_kodepos.id_kdp')
            ->leftJoin('md_provinsi', 'md_kodepos.kodedagri_prv', '=', 'md_provinsi.kodedagri_prv')
            ->leftJoin('md_kabkota', 'md_kodepos.kodedagri_kbk', '=', 'md_kabkota.kodedagri_kbk')
            ->where('md_psr.status_psr', 1)
            ->orderBy('md_psr.updated_at', 'desc')
            ->limit(3)
            ->get();

        // Combine all activities and sort by updated_at
        $activities = $activities
            ->merge($provinsiActivities)
            ->merge($kabkotaActivities)
            ->merge($kodeposActivities)
            ->merge($psrActivities)
            ->sortByDesc('updated_at')
            ->take(10);

        return $activities->values()->all();
    }

    /**
     * Get data for API endpoints (AJAX calls)
     */
    public function getStatsData()
    {
        $stats = $this->getBasicStats();
        return response()->json($stats);
    }

    /**
     * Get chart data for AJAX calls
     */
    public function getChartsData()
    {
        $chartData = $this->getChartData();
        $provinceDistribution = $this->getProvinceDistribution();
        $growthTrend = $this->getGrowthTrend();

        return response()->json([
            'composition' => $chartData,
            'province_distribution' => $provinceDistribution,
            'growth_trend' => $growthTrend
        ]);
    }

    public function getGrowthTrendWithPeriod($months = 6)
{
    $months = (int) $months;
    if ($months < 1 || $months > 24) {
        $months = 6; // Default to 6 months
    }

    $monthsData = [];
    $provinsiData = [];
    $kabkotaData = [];
    $kodeposData = [];
    $psrData = [];

    // Generate months based on parameter
    for ($i = $months - 1; $i >= 0; $i--) {
        $date = Carbon::now()->subMonths($i);
        $monthsData[] = $date->format('M Y');

        // Count data up to each month
        $provinsiData[] = DB::table('md_provinsi')
            ->where('status_prv', 1)
            ->where('created_at', '<=', $date->endOfMonth())
            ->count();

        $kabkotaData[] = DB::table('md_kabkota')
            ->where('status_kbk', 1)
            ->where('created_at', '<=', $date->endOfMonth())
            ->count();

        $kodeposData[] = DB::table('md_kodepos')
            ->where('status_kdp', 1)
            ->where('created_at', '<=', $date->endOfMonth())
            ->count();

        $psrData[] = DB::table('md_psr')
            ->where('status_psr', 1)
            ->where('created_at', '<=', $date->endOfMonth())
            ->count();
    }

    return response()->json([
        'labels' => $monthsData,
        'provinsi' => $provinsiData,
        'kabkota' => $kabkotaData,
        'kodepos' => $kodeposData,
        'psr' => $psrData
    ]);
}
    /**
     * Get recent activities for AJAX calls
     */
    public function getActivitiesData()
    {
        $activities = $this->getRecentActivities();
        return response()->json($activities);
    }

    /**
     * Get weekly activity data for radar chart
     */
    public function getWeeklyActivity()
    {
        $weeklyData = [];
        $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
        
        foreach ($days as $day) {
            $totalActivity = 0;
            
            // Count activities for each table for this day of week
            $totalActivity += DB::table('md_provinsi')
                ->where('status_prv', 1)
                ->whereRaw('EXTRACT(DOW FROM created_at) = ?', [array_search($day, $days) + 1])
                ->whereDate('created_at', '>=', Carbon::now()->subWeek())
                ->count();
                
            $totalActivity += DB::table('md_kabkota')
                ->where('status_kbk', 1)
                ->whereRaw('EXTRACT(DOW FROM created_at) = ?', [array_search($day, $days) + 1])
                ->whereDate('created_at', '>=', Carbon::now()->subWeek())
                ->count();
                
            $totalActivity += DB::table('md_kodepos')
                ->where('status_kdp', 1)
                ->whereRaw('EXTRACT(DOW FROM created_at) = ?', [array_search($day, $days) + 1])
                ->whereDate('created_at', '>=', Carbon::now()->subWeek())
                ->count();
                
            $totalActivity += DB::table('md_psr')
                ->where('status_psr', 1)
                ->whereRaw('EXTRACT(DOW FROM created_at) = ?', [array_search($day, $days) + 1])
                ->whereDate('created_at', '>=', Carbon::now()->subWeek())
                ->count();
                
            $weeklyData[] = $totalActivity;
        }

        return response()->json([
            'labels' => ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'],
            'data' => $weeklyData
        ]);
    }

    /**
     * Export dashboard data to PDF/Excel (optional)
     */
    public function exportData(Request $request)
    {
        $format = $request->get('format', 'pdf'); // pdf or excel
        $stats = $this->getBasicStats();
        
        // Implementation for export functionality
        // You can add PDF/Excel export logic here
        
        return response()->json([
            'message' => 'Export functionality to be implemented',
            'format' => $format,
            'data' => $stats
        ]);
    }
}  