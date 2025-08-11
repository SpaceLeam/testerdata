<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class KategoriInstansiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = DB::table('md_kategoriinstansi')
            ->select('*')
            ->where('status_kin', 1) // Hanya tampilkan data dengan status aktif
            ->orderBy('id_kin', 'desc');

        // Search functionality
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_kin', 'ILIKE', "%{$search}%")
                  ->orWhere('id_kin', 'ILIKE', "%{$search}%");
            });
        }

        $kategoriInstansi = $query->paginate(10);

        return view('kategori-instansi.index', compact('kategoriInstansi'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('kategori-instansi.create');
    }

    /**
     * Store a newly created resource in storage.
     */
  public function store(Request $request)
{
    // Validasi input
    $validator = Validator::make($request->all(), [
        'id_kin'    => 'required|integer|min:1|unique:md_kategoriinstansi,id_kin',
        'nama_kin'  => 'required|string|max:100',
    ]);

    // Jika validasi gagal
    if ($validator->fails()) {
        return redirect()->back()
            ->withErrors($validator)
            ->withInput();
    }

    try {
        // Simpan data ke database
        DB::table('md_kategoriinstansi')->insert([
            'id_kin'      => $request->id_kin,
            'nama_kin'    => $request->nama_kin,
            'status_kin'  => 1, // Status aktif default
            'created_at'  => Carbon::now()->setTimezone('Asia/Jakarta'),
            'updated_at'  => Carbon::now()->setTimezone('Asia/Jakarta'),
        ]);

        return redirect()->route('kategori-instansi.index')
            ->with('success', 'Kategori instansi berhasil ditambahkan');
    } catch (\Exception $e) {
        return redirect()->back()
            ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
            ->withInput();
    }
}

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $kategoriInstansi = DB::table('md_kategoriinstansi')
            ->where('id_kin', $id)
            ->where('status_kin', 1)
            ->first();

        if (!$kategoriInstansi) {
            return redirect()->route('kategori-instansi.index')
                ->with('error', 'Data kategori instansi tidak ditemukan');
        }

        return view('kategori-instansi.show', compact('kategoriInstansi'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $kategoriInstansi = DB::table('md_kategoriinstansi')
            ->where('id_kin', $id)
            ->where('status_kin', 1)
            ->first();

        if (!$kategoriInstansi) {
            return redirect()->route('kategori-instansi.index')
                ->with('error', 'Data kategori instansi tidak ditemukan');
        }

        return view('kategori-instansi.edit', compact('kategoriInstansi'));
    }
    
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama_kin' => 'required|string|max:100'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $kategoriInstansi = DB::table('md_kategoriinstansi')
                ->where('id_kin', $id)
                ->where('status_kin', 1)
                ->first();

            if (!$kategoriInstansi) {
                return redirect()->route('kategori-instansi.index')
                    ->with('error', 'Data kategori instansi tidak ditemukan');
            }

            DB::table('md_kategoriinstansi')
                ->where('id_kin', $id)
                ->update([
                    'nama_kin' => $request->nama_kin,
                    'updated_at' => Carbon::now()->setTimezone('Asia/Jakarta')
                ]);

            return redirect()->route('kategori-instansi.index')
                ->with('success', 'Kategori instansi berhasil diperbarui');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage (Set status to 0).
     */
    public function destroy($id)
    {
        try {
            $kategoriInstansi = DB::table('md_kategoriinstansi')
                ->where('id_kin', $id)
                ->where('status_kin', 1)
                ->first();

            if (!$kategoriInstansi) {
                return redirect()->route('kategori-instansi.index')
                    ->with('error', 'Data kategori instansi tidak ditemukan');
            }

            // Set status menjadi 0 (tidak aktif/dihapus)
            DB::table('md_kategoriinstansi')
                ->where('id_kin', $id)
                ->update([
                    'status_kin' => 0,
                    'updated_at' => Carbon::now()->setTimezone('Asia/Jakarta')
                ]);

            return redirect()->route('kategori-instansi.index')
                ->with('success', 'Kategori instansi berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Get all kategori instansi data for API or AJAX
     */
    public function getData()
    {
        $kategoriInstansi = DB::table('md_kategoriinstansi')
            ->select('*')
            ->where('status_kin', 1)
            ->orderBy('id_kin', 'desc')
            ->get();

        return response()->json($kategoriInstansi);
    }

    /**
     * Restore kategori instansi (Set status back to 1)
     */
    public function restore($id)
    {
        try {
            $kategoriInstansi = DB::table('md_kategoriinstansi')
                ->where('id_kin', $id)
                ->where('status_kin', 0)
                ->first();

            if (!$kategoriInstansi) {
                return redirect()->route('kategori-instansi.trash')
                    ->with('error', 'Data kategori instansi tidak ditemukan');
            }

            DB::table('md_kategoriinstansi')
                ->where('id_kin', $id)
                ->update([
                    'status_kin' => 1,
                    'updated_at' => Carbon::now()->setTimezone('Asia/Jakarta')
                ]);

            return redirect()->route('kategori-instansi.trash')
                ->with('success', 'Kategori instansi berhasil dipulihkan');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Show trash page (data with status 0)
     */
    public function trash()
    {
        $kategoriInstansi = DB::table('md_kategoriinstansi')
            ->select('*')
            ->where('status_kin', 0)
            ->orderBy('updated_at', 'desc')
            ->paginate(10);

        return view('kategori-instansi.trash', compact('kategoriInstansi'));
    }

    /**
     * Permanent delete kategori instansi
     */
    public function forceDelete($id)
    {
        try {
            // Validasi ID
            if (!is_numeric($id)) {
                return redirect()->route('kategori-instansi.trash')
                    ->with('error', 'ID kategori instansi tidak valid');
            }

            $kategoriInstansi = DB::table('md_kategoriinstansi')
                ->where('id_kin', $id)
                ->where('status_kin', 0)
                ->first();

            if (!$kategoriInstansi) {
                return redirect()->route('kategori-instansi.trash')
                    ->with('error', 'Data kategori instansi tidak ditemukan');
            }

            DB::table('md_kategoriinstansi')
                ->where('id_kin', $id)
                ->delete();

            return redirect()->route('kategori-instansi.trash')
                ->with('success', 'Kategori instansi berhasil dihapus permanen');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    // ===== REST API METHODS =====

    /**
     * API: Get all kategori instansi data
     */
    public function apiIndex(Request $request)
    {
        try {
            $query = DB::table('md_kategoriinstansi')
                ->select('*')
                ->where('status_kin', 1)
                ->orderBy('id_kin', 'desc');

            // Search functionality
            if ($request->has('search') && !empty($request->search)) {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->where('nama_kin', 'ILIKE', "%{$search}%")
                      ->orWhere('id_kin', 'ILIKE', "%{$search}%");
                });
            }

            $kategoriInstansi = $query->get();

            return response()->json([
                'success' => true,
                'message' => 'Data kategori instansi berhasil diambil',
                'data' => $kategoriInstansi
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
                'data' => null
            ], 500);
        }
    }

    /**
     * API: Get kategori instansi by ID
     */
    public function apiShow($id)
    {
        try {
            $kategoriInstansi = DB::table('md_kategoriinstansi')
                ->where('id_kin', $id)
                ->where('status_kin', 1)
                ->first();

            if (!$kategoriInstansi) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data kategori instansi tidak ditemukan',
                    'data' => null
                ], 404);
            }

            return response()->json([
                'success' => true,
                'message' => 'Data kategori instansi berhasil diambil',
                'data' => $kategoriInstansi
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
                'data' => null
            ], 500);
        }
    }

    /**
     * API: Store new kategori instansi
     */
    public function apiStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_kin' => 'required|string|max:100'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $id = DB::table('md_kategoriinstansi')->insertGetId([
                'nama_kin' => $request->nama_kin,
                'status_kin' => 1,
                'created_at' => Carbon::now()->setTimezone('Asia/Jakarta'),
                'updated_at' => Carbon::now()->setTimezone('Asia/Jakarta')
            ]);

            // Get the inserted record
            $kategoriInstansi = DB::table('md_kategoriinstansi')
                ->where('id_kin', $id)
                ->first();

            return response()->json([
                'success' => true,
                'message' => 'Kategori instansi berhasil ditambahkan',
                'data' => $kategoriInstansi
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
                'data' => null
            ], 500);
        }
    }

    /**
     * API: Update kategori instansi
     */
    public function apiUpdate(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama_kin' => 'required|string|max:100'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $kategoriInstansi = DB::table('md_kategoriinstansi')
                ->where('id_kin', $id)
                ->where('status_kin', 1)
                ->first();

            if (!$kategoriInstansi) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data kategori instansi tidak ditemukan',
                    'data' => null
                ], 404);
            }

            DB::table('md_kategoriinstansi')
                ->where('id_kin', $id)
                ->update([
                    'nama_kin' => $request->nama_kin,
                    'updated_at' => Carbon::now()->setTimezone('Asia/Jakarta')
                ]);

            $updatedKategoriInstansi = DB::table('md_kategoriinstansi')
                ->where('id_kin', $id)
                ->first();

            return response()->json([
                'success' => true,
                'message' => 'Kategori instansi berhasil diperbarui',
                'data' => $updatedKategoriInstansi
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
                'data' => null
            ], 500);
        }
    }

    /**
     * API: Delete kategori instansi (set status to 0)
     */
    public function apiDestroy($id)
    {
        try {
            $kategoriInstansi = DB::table('md_kategoriinstansi')
                ->where('id_kin', $id)
                ->where('status_kin', 1)
                ->first();

            if (!$kategoriInstansi) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data kategori instansi tidak ditemukan',
                    'data' => null
                ], 404);
            }

            // Set status menjadi 0
            DB::table('md_kategoriinstansi')
                ->where('id_kin', $id)
                ->update([
                    'status_kin' => 0,
                    'updated_at' => Carbon::now()->setTimezone('Asia/Jakarta')
                ]);

            return response()->json([
                'success' => true,
                'message' => 'Kategori instansi berhasil dihapus',
                'data' => null
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
                'data' => null
            ], 500);
        }
    }

    /**
     * API: Get trash data (status 0)
     */
    public function apiTrash()
    {
        try {
            $kategoriInstansi = DB::table('md_kategoriinstansi')
                ->select('*')
                ->where('status_kin', 0)
                ->orderBy('updated_at', 'desc')
                ->get();

            return response()->json([
                'success' => true,
                'message' => 'Data trash berhasil diambil',
                'data' => $kategoriInstansi
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
                'data' => null
            ], 500);
        }
    }

    /**
     * API: Restore kategori instansi (set status back to 1)
     */
    public function apiRestore($id)
    {
        try {
            $kategoriInstansi = DB::table('md_kategoriinstansi')
                ->where('id_kin', $id)
                ->where('status_kin', 0)
                ->first();

            if (!$kategoriInstansi) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data kategori instansi tidak ditemukan',
                    'data' => null
                ], 404);
            }

            DB::table('md_kategoriinstansi')
                ->where('id_kin', $id)
                ->update([
                    'status_kin' => 1,
                    'updated_at' => Carbon::now()->setTimezone('Asia/Jakarta')
                ]);

            $restoredKategoriInstansi = DB::table('md_kategoriinstansi')
                ->where('id_kin', $id)
                ->first();

            return response()->json([
                'success' => true,
                'message' => 'Kategori instansi berhasil dipulihkan',
                'data' => $restoredKategoriInstansi
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
                'data' => null
            ], 500);
        }
    }
}   