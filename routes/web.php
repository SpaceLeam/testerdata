    <?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JabatanController;
use App\Http\Controllers\PenggunaController;
use App\Http\Controllers\ProvinsiController;
use App\Http\Controllers\KabkotaController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\DashboardController;


route::get('/', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// Dashboard AJAX API routes
Route::prefix('dashboard')->name('dashboard.')->group(function () {
    
    // Get stats data for refresh
    Route::get('/stats-data', [DashboardController::class, 'getStatsData'])->name('stats-data');
    
    // Get charts data for refresh  
    Route::get('/charts-data', [DashboardController::class, 'getChartsData'])->name('charts-data');
    
    // Get recent activities data
    Route::get('/activities-data', [DashboardController::class, 'getActivitiesData'])->name('activities-data');
    
    // Get weekly activity data for radar chart
    Route::get('/weekly-activity', [DashboardController::class, 'getWeeklyActivity'])->name('weekly-activity');
    
    // Get growth trend data with custom period
    Route::get('/growth-trend/{months}', [DashboardController::class, 'getGrowthTrend'])
         ->where('months', '[0-9]+')
         ->name('growth-trend');
    
    // Export data (PDF/Excel)
    Route::post('/export', [DashboardController::class, 'exportData'])->name('export');
});
// Route tambahan untuk fitur khusus HARUS di atas resource route
Route::prefix('jabatan')->name('jabatan.')->group(function () {
    Route::get('data', [JabatanController::class, 'getData'])->name('data');
    Route::get('trash', [JabatanController::class, 'trash'])->name('trash');
    Route::patch('{id}/restore', [JabatanController::class, 'restore'])->name('restore');
    Route::delete('{id}/force-delete', [JabatanController::class, 'forceDelete'])->name('forceDelete');
});

// Resource routes untuk CRUD utama
Route::resource('jabatan', JabatanController::class);

Route::resource('pengguna', PenggunaController::class);
Route::get('pengguna-trash', [PenggunaController::class, 'trash'])->name('pengguna.trash');
Route::delete('pengguna-force-delete/{id}', [PenggunaController::class, 'forceDelete'])->name('pengguna.forceDelete');
Route::PUT('pengguna-restore/{id}', [PenggunaController::class, 'restore'])->name('pengguna.restore');
Route::post('pengguna-reset-otp/{id}', [PenggunaController::class, 'resetOtp'])->name('pengguna.resetOtp');


// ===== WEB ROUTES =====

//Route::resource('provinsi', ProvinsiController::class);
// Pindahkan route trash ke ATAS sebelum route resource
Route::get('/provinsi/trash', [ProvinsiController::class, 'trash'])->name('provinsi.trash');
Route::post('/provinsi/{id}/restore', [ProvinsiController::class, 'restore'])->name('provinsi.restore');
Route::delete('/provinsi/{id}/force-delete', [ProvinsiController::class, 'forceDelete'])->name('provinsi.force-delete');
Route::get('/provinsi/data/get', [ProvinsiController::class, 'getData'])->name('provinsi.data');

// KEMUDIAN baru route resource
Route::resource('provinsi', ProvinsiController::class);
// Routes untuk
Route::prefix('kabkota')->group(function () {
    // Trash route HARUS di atas route {id}
    Route::get('/trash', [KabkotaController::class, 'trash'])->name('kabkota.trash');
    
    // Baru route lainnya
    Route::get('/', [KabkotaController::class, 'index'])->name('kabkota.index');
    Route::get('/create', [KabkotaController::class, 'create'])->name('kabkota.create');
    Route::post('/', [KabkotaController::class, 'store'])->name('kabkota.store');
    Route::get('/{id}', [KabkotaController::class, 'show'])->name('kabkota.show');
    Route::get('/{id}/edit', [KabkotaController::class, 'edit'])->name('kabkota.edit');
    Route::put('/{id}', [KabkotaController::class, 'update'])->name('kabkota.update');
    Route::delete('/{id}', [KabkotaController::class, 'destroy'])->name('kabkota.destroy');
    Route::patch('/{id}/restore', [KabkotaController::class, 'restore'])->name('kabkota.restore');
    Route::delete('/{id}/force-delete', [KabkotaController::class, 'forceDelete'])->name('kabkota.force-delete');
});

// Resource routes
// Route khusus harus didefinisikan SEBELUM route dengan parameter
Route::get('menu/trash', [MenuController::class, 'trash'])->name('menu.trash');
Route::post('menu/restore/{id}', [MenuController::class, 'restore'])->name('menu.restore');
Route::delete('menu/force-delete/{id}', [MenuController::class, 'forceDelete'])->name('menu.forceDelete');
Route::post('menu/empty-trash', [MenuController::class, 'emptyTrash'])->name('menu.emptyTrash');

// Route dengan parameter {id} harus di bawah
Route::resource('menu', MenuController::class);



use App\Http\Controllers\KategoriAnggaranController;

// Resource routes (CRUD dasar)
// ✅ 1. Route khusus dulu
Route::prefix('kategori-anggaran')->name('kategori-anggaran.')->group(function () {
    Route::get('trash', [KategoriAnggaranController::class, 'trash'])->name('trash');
    Route::patch('{id}/restore', [KategoriAnggaranController::class, 'restore'])->name('restore');
    Route::get('data/all', [KategoriAnggaranController::class, 'getData'])->name('data');
    Route::delete('{id}/force-delete', [KategoriAnggaranController::class, 'forceDelete'])->name('force-delete');

});

// ✅ 2. Baru route resource
Route::resource('kategori-anggaran', KategoriAnggaranController::class);


use App\Http\Controllers\KategoriPmController;

/*
|--------------------------------------------------------------------------
| Kategori PM Routes
|--------------------------------------------------------------------------
*/

// Resource routes untuk CRUD dasar


// Additional routes untuk fitur tambahan
Route::prefix('kategori-pm')->name('kategori-pm.')->group(function () {
    // Route untuk mendapatkan data via AJAX/API
    Route::get('get-data', [KategoriPmController::class, 'getData'])->name('get-data');
    
    // Route untuk halaman trash
    Route::get('trash', [KategoriPmController::class, 'trash'])->name('trash');
    
    // Route untuk restore data dari trash
    Route::put('restore/{id}', [KategoriPmController::class, 'restore'])->name('restore');
    
    // Route untuk force delete (hapus permanen)
    Route::delete('force-delete/{id}', [KategoriPmController::class, 'forceDelete'])->name('force-delete');
});


Route::resource('kategori-pm', KategoriPmController::class);
// Tambahkan ini di web.php

use App\Http\Controllers\PsrController;
Route::resource('psr', PsrController::class);
Route::get('psr-trash', [PsrController::class, 'trash'])->name('psr.trash');
Route::post('psr/{id}/restore', [PsrController::class, 'restore'])->name('psr.restore');
Route::get('api/psr', [PsrController::class, 'getData']);
Route::get('api/psr/provinsi/{id}', [PsrController::class, 'getByProvinsi']);
Route::get('api/psr/kabkota/{id}', [PsrController::class, 'getByKabkota']);
Route::get('api/psr/kodepos/{id}', [PsrController::class, 'getByKodepos']);
Route::get('api/psr/map', [PsrController::class, 'getForMap']);

use App\Http\Controllers\KategoriInstansiController;

// Resource routes untuk CRUD dasar


// Route tambahan untuk fitur sampah dan restore
Route::get('/kategori-instansi-trash', [KategoriInstansiController::class, 'trash'])->name('kategori-instansi.trash');
Route::put('/kategori-instansi/{id}/restore', [KategoriInstansiController::class, 'restore'])->name('kategori-instansi.restore');
Route::delete('/kategori-instansi/{id}/force-delete', [KategoriInstansiController::class, 'forceDelete'])->name('kategori-instansi.force-delete');
Route::get('/kategori-instansi/data/get', [KategoriInstansiController::class, 'getData'])->name('kategori-instansi.data');

Route::resource('kategori-instansi', KategoriInstansiController::class);


use App\Http\Controllers\AnggaranController;

Route::resource('anggaran', AnggaranController::class);

// Route tambahan untuk fitur trash & restore (karena tidak termasuk dalam resource)
Route::prefix('anggaran')->name('anggaran.')->group(function () {
    Route::get('trash', [AnggaranController::class, 'trash'])->name('trash');
    Route::patch('{id}/restore', [AnggaranController::class, 'restore'])->name('restore');
});



use App\Http\Controllers\KategoriSpgController;

// Web Routes for Kategori SPG
Route::resource('kategori-spg', KategoriSpgController::class);

// Additional routes for trash management
Route::get('kategori-spg-trash', [KategoriSpgController::class, 'trash'])->name('kategori-spg.trash');
Route::post('kategori-spg/{id}/restore', [KategoriSpgController::class, 'restore'])->name('kategori-spg.restore');
Route::delete('kategori-spg/{id}/force-delete', [KategoriSpgController::class, 'forceDelete'])->name('kategori-spg.force-delete');

// AJAX/API route
Route::get('kategori-spg-data', [KategoriSpgController::class, 'getData'])->name('kategori-spg.data');

// API Routes (optional - for REST API)

// Add this to your web.php or routes file

use App\Http\Controllers\KodeposController;

// Kodepos Routes
Route::prefix('kodepos')->name('kodepos.')->group(function () {
    // Basic CRUD Routes
    Route::get('/', [KodeposController::class, 'index'])->name('index');
    Route::get('/create', [KodeposController::class, 'create'])->name('create');
    Route::post('/', [KodeposController::class, 'store'])->name('store');
    Route::get('/{id}', [KodeposController::class, 'show'])->name('show');
    Route::get('/{id}/edit', [KodeposController::class, 'edit'])->name('edit');
    Route::put('/{id}', [KodeposController::class, 'update'])->name('update');
    Route::delete('/{id}', [KodeposController::class, 'destroy'])->name('destroy');
    
    // Trash Management Routes
    Route::get('/trash/index', [KodeposController::class, 'trash'])->name('trash');
    Route::post('/trash/{id}/restore', [KodeposController::class, 'restore'])->name('restore');
    Route::delete('/trash/{id}/force-delete', [KodeposController::class, 'forceDelete'])->name('force-delete');
    
    // API Routes for AJAX
    Route::get('/api/data', [KodeposController::class, 'getData'])->name('getData');
    Route::get('/api/provinsi/{provinsiId}', [KodeposController::class, 'getByProvinsi'])->name('getByProvinsi');
    Route::get('/api/kabkota/{kabkotaId}', [KodeposController::class, 'getByKabkota'])->name('getByKabkota');
    
   
});