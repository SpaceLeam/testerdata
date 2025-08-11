<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JabatanController;
use App\Http\Controllers\PenggunaController;
use App\Http\Controllers\ProvinsiController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// API Routes untuk Jabatan
Route::prefix('jabatan')->group(function () {
    Route::get('/', [JabatanController::class, 'apiIndex']);           // GET /api/jabatan
    Route::get('/{id}', [JabatanController::class, 'apiShow']);        // GET /api/jabatan/{id}
    Route::post('/', [JabatanController::class, 'apiStore']);          // POST /api/jabatan
    Route::put('/{id}', [JabatanController::class, 'apiUpdate']);      // PUT /api/jabatan/{id}
    Route::patch('/{id}/restore', [JabatanController::class, 'apiRestore']);

        Route::delete('/{id}', [JabatanController::class, 'apiDestroy']);  // DELETE /api/jabatan/{id}
});

use App\Http\Controllers\KodeposController;

// API Routes (di api.php)
Route::prefix('kodepos')->group(function () {
    Route::get('/', [KodeposController::class, 'apiIndex']);
    Route::get('/{id}', [KodeposController::class, 'apiShow']);
    Route::post('/', [KodeposController::class, 'apiStore']);
    Route::put('/{id}', [KodeposController::class, 'apiUpdate']);
    Route::delete('/{id}', [KodeposController::class, 'apiDestroy']);
    Route::get('/trash/list', [KodeposController::class, 'apiTrash']);
    Route::patch('/{id}/restore', [KodeposController::class, 'apiRestore']);
    Route::get('/kabkota/{kodedagri_prv}', [KodeposController::class, 'apiGetKabkotaByProvinsi']);
});
// Alternative: Menggunakan apiResource (pilih salah satu)
// Route::apiResource('jabatan', JabatanController::class, [
//     'names' => [
//         'index' => 'jabatan.api.index',
//         'show' => 'jabatan.api.show', 
//         'store' => 'jabatan.api.store',
//         'update' => 'jabatan.api.update',
//         'destroy' => 'jabatan.api.destroy'
//     ]
// ]);

// Jika ingin menambahkan middleware auth untuk API jabatan
// Route::middleware(['auth:sanctum'])->prefix('jabatan')->group(function () {
//     Route::get('/', [JabatanController::class, 'apiIndex']);
//     Route::get('/{id}', [JabatanController::class, 'apiShow']);
//     Route::post('/', [JabatanController::class, 'apiStore']);
//     Route::put('/{id}', [JabatanController::class, 'apiUpdate']);
//     Route::delete('/{id}', [JabatanController::class, 'apiDestroy']);
// });


// File: routes/api.php


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/


// API Routes untuk Pengguna
Route::prefix('pengguna')->group(function () {
    Route::get('/', [PenggunaController::class, 'apiIndex']);           // GET /api/pengguna
    Route::get('/{id}', [PenggunaController::class, 'apiShow']);        // GET /api/pengguna/{id}
    Route::post('/', [PenggunaController::class, 'apiStore']);          // POST /api/pengguna
    Route::put('/{id}', [PenggunaController::class, 'apiUpdate']);      // PUT /api/pengguna/{id}
    Route::delete('/{id}', [PenggunaController::class, 'apiDestroy']);  // DELETE /api/pengguna/{id}
    
    // Additional routes for trash functionality
    Route::get('/trash/list', [PenggunaController::class, 'apiTrash']);     // GET /api/pengguna/trash/list
    Route::post('/{id}/restore', [PenggunaController::class, 'apiRestore']); // POST /api/pengguna/{id}/restore
});

// Alternative menggunakan string jika masih error (uncomment jika perlu):
/*
Route::prefix('pengguna')->group(function () {
    Route::get('/', 'App\Http\Controllers\PenggunaController@apiIndex');
    Route::get('/{id}', 'App\Http\Controllers\PenggunaController@apiShow');
    Route::post('/', 'App\Http\Controllers\PenggunaController@apiStore');
    Route::put('/{id}', 'App\Http\Controllers\PenggunaController@apiUpdate');
    Route::delete('/{id}', 'App\Http\Controllers\PenggunaController@apiDestroy');
    Route::get('/trash/list', 'App\Http\Controllers\PenggunaController@apiTrash');
    Route::post('/{id}/restore', 'App\Http\Controllers\PenggunaController@apiRestore');
});
*/
Route::prefix('provinsi')->group(function () {
    Route::get('/', [ProvinsiController::class, 'apiIndex']);           // GET /api/pengguna
    Route::get('/{id}', [ProvinsiController::class, 'apiShow']);        // GET /api/pengguna/{id}
    Route::post('/', [ProvinsiController::class, 'apiStore']);          // POST /api/pengguna
    Route::put('/{id}', [ProvinsiController::class, 'apiUpdate']);      // PUT /api/pengguna/{id}
    Route::delete('/{id}', [ProvinsiController::class, 'apiDestroy']);  // DELETE /api/pengguna/{id}
    
    // Additional routes for trash functionality
    Route::get('/trash/list', [ProvinsiController::class, 'apiTrash']);     // GET /api/pengguna/trash/list
    Route::post('/{id}/restore', [ProvinsiController::class, 'apiRestore']); // POST /api/pengguna/{id}/restore
});


use App\Http\Controllers\MenuController;

// API: Menu
Route::prefix('menu')->group(function () {
    Route::get('/', [MenuController::class, 'apiIndex']);              // GET all active menu
    Route::get('/trash', [MenuController::class, 'apiTrash']);         // GET trashed menu
    Route::get('/{id}', [MenuController::class, 'apiShow']);           // GET single menu
    Route::post('/', [MenuController::class, 'apiStore']);             // POST new menu
    Route::put('/{id}', [MenuController::class, 'apiUpdate']);         // PUT update
    Route::delete('/{id}', [MenuController::class, 'apiDestroy']);     // DELETE (soft delete)
    Route::patch('/{id}/restore', [MenuController::class, 'apiRestore']); // PATCH restore
});

use App\Http\Controllers\KategoriAnggaranController;

Route::prefix('kategori-anggaran')->group(function () {
    Route::get('/', [KategoriAnggaranController::class, 'apiIndex']);             // GET all active
    Route::get('/trash', [KategoriAnggaranController::class, 'apiTrash']);        // GET trashed
    Route::get('/{id}', [KategoriAnggaranController::class, 'apiShow']);          // GET by ID
    Route::post('/', [KategoriAnggaranController::class, 'apiStore']);            // POST new
    Route::put('/{id}', [KategoriAnggaranController::class, 'apiUpdate']);        // PUT update
    Route::delete('/{id}', [KategoriAnggaranController::class, 'apiDestroy']);    // DELETE (soft)
    Route::patch('/{id}/restore', [KategoriAnggaranController::class, 'apiRestore']); // PATCH restore
});


use App\Http\Controllers\KategoriPmController;

Route::prefix('kategori-pm')->group(function () {
    // GET all kategori PM
    Route::get('/', [KategoriPmController::class, 'apiIndex'])->name('kategori-pm.index');

    // GET kategori PM by ID
    Route::get('{id}', [KategoriPmController::class, 'apiShow'])->name('kategori-pm.show');

    // POST create kategori PM
    Route::post('/', [KategoriPmController::class, 'apiStore'])->name('kategori-pm.store');

    // PUT/PATCH update kategori PM
    Route::match(['put', 'patch'], '{id}', [KategoriPmController::class, 'apiUpdate'])->name('kategori-pm.update');

    // DELETE soft delete kategori PM (status to 0)
    Route::delete('{id}', [KategoriPmController::class, 'apiDestroy'])->name('kategori-pm.destroy');

    // GET trash (data dengan status 0)
    Route::get('trash/data', [KategoriPmController::class, 'apiTrash'])->name('kategori-pm.trash');

    // PATCH restore from trash (status to 1)
    Route::patch('{id}/restore', [KategoriPmController::class, 'apiRestore'])->name('kategori-pm.restore');
});

use App\Http\Controllers\KategoriInstansiController;
    use App\Http\Controllers\KategoriSpgController;
Route::prefix('kategori-spg')->group(function () {
    Route::get('/', [KategoriSpgController::class, 'apiIndex']);
    Route::get('/trash', [KategoriSpgController::class, 'apiTrash']);
    Route::get('/{id}', [KategoriSpgController::class, 'apiShow']);
    Route::post('/', [KategoriSpgController::class, 'apiStore']);
    Route::put('/{id}', [KategoriSpgController::class, 'apiUpdate']);
    Route::patch('/{id}/restore', [KategoriSpgController::class, 'apiRestore']);
    Route::delete('/{id}', [KategoriSpgController::class, 'apiDestroy']);
});


    
use App\Http\Controllers\AnggaranController;

Route::prefix('anggaran')->group(function () {
    Route::get('/', [AnggaranController::class, 'apiIndex']);
    Route::get('/trash', [AnggaranController::class, 'apiTrash']);
    Route::get('/{id}', [AnggaranController::class, 'apiShow']);
    Route::post('/', [AnggaranController::class, 'apiStore']);
    Route::put('/{id}', [AnggaranController::class, 'apiUpdate']);
    Route::delete('/{id}', [AnggaranController::class, 'apiDestroy']);
    Route::patch('/{id}/restore', [AnggaranController::class, 'apiRestore']);
});
