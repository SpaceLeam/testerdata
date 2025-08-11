<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class KategoriSpgController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = DB::table('md_kategorisppg')
            ->select('*')
            ->where('status_ksp', 1) // Hanya tampilkan data dengan status aktif
            ->orderBy('id_ksp', 'desc');

        // Search functionality
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_ksp', 'ILIKE', "%{$search}%")
                  ->orWhere('id_ksp', 'ILIKE', "%{$search}%");
            });
        }

        $kategoriSpg = $query->paginate(10);

        return view('kategori-spg.index', compact('kategoriSpg'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('kategori-spg.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
       $validator = Validator::make($request->all(), [
    'id_ksp'    => 'required|integer|unique:md_kategorisppg,id_ksp',
    'nama_ksp'  => 'required|string|max:100',
]);


        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            DB::table('md_kategorisppg')->insert([
    'id_ksp'      => $request->id_ksp,
    'nama_ksp'    => $request->nama_ksp,
    'status_ksp'  => 1,
    'created_at'  => Carbon::now()->setTimezone('Asia/Jakarta'),
    'updated_at'  => Carbon::now()->setTimezone('Asia/Jakarta')
]);


            return redirect()->route('kategori-spg.index')
                ->with('success', 'Kategori SPG berhasil ditambahkan');
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
        $kategoriSpg = DB::table('md_kategorisppg')
            ->where('id_ksp', $id)
            ->where('status_ksp', 1)
            ->first();

        if (!$kategoriSpg) {
            return redirect()->route('kategori-spg.index')
                ->with('error', 'Data kategori SPG tidak ditemukan');
        }

        return view('kategori-spg.show', compact('kategoriSpg'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $kategoriSpg = DB::table('md_kategorisppg')
            ->where('id_ksp', $id)
            ->where('status_ksp', 1)
            ->first();

        if (!$kategoriSpg) {
            return redirect()->route('kategori-spg.index')
                ->with('error', 'Data kategori SPG tidak ditemukan');
        }

        return view('kategori-spg.edit', compact('kategoriSpg'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama_ksp' => 'required|string|max:100'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $kategoriSpg = DB::table('md_kategorisppg')
                ->where('id_ksp', $id)
                ->where('status_ksp', 1)
                ->first();

            if (!$kategoriSpg) {
                return redirect()->route('kategori-spg.index')
                    ->with('error', 'Data kategori SPG tidak ditemukan');
            }

            DB::table('md_kategorisppg')
                ->where('id_ksp', $id)
                ->update([
                    'nama_ksp' => $request->nama_ksp,
                    'updated_at' => Carbon::now()->setTimezone('Asia/Jakarta')
                ]);

            return redirect()->route('kategori-spg.index')
                ->with('success', 'Kategori SPG berhasil diperbarui');
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
            $kategoriSpg = DB::table('md_kategorisppg')
                ->where('id_ksp', $id)
                ->where('status_ksp', 1)
                ->first();

            if (!$kategoriSpg) {
                return redirect()->route('kategori-spg.index')
                    ->with('error', 'Data kategori SPG tidak ditemukan');
            }

            // Set status menjadi 0 (tidak aktif/dihapus)
            DB::table('md_kategorisppg')
                ->where('id_ksp', $id)
                ->update([
                    'status_ksp' => 0,
                    'updated_at' => Carbon::now()->setTimezone('Asia/Jakarta')
                ]);

            return redirect()->route('kategori-spg.index')
                ->with('success', 'Kategori SPG berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Get all kategori SPG data for API or AJAX
     */
    public function getData()
    {
        $kategoriSpg = DB::table('md_kategorisppg')
            ->select('*')
            ->where('status_ksp', 1)
            ->orderBy('id_ksp', 'desc')
            ->get();

        return response()->json($kategoriSpg);
    }

    /**
     * Restore kategori SPG (Set status back to 1)
     */
    public function restore($id)
    {
        try {
            $kategoriSpg = DB::table('md_kategorisppg')
                ->where('id_ksp', $id)
                ->where('status_ksp', 0)
                ->first();

            if (!$kategoriSpg) {
                return redirect()->route('kategori-spg.trash')
                    ->with('error', 'Data kategori SPG tidak ditemukan');
            }

            DB::table('md_kategorisppg')
                ->where('id_ksp', $id)
                ->update([
                    'status_ksp' => 1,
                    'updated_at' => Carbon::now()->setTimezone('Asia/Jakarta')
                ]);

            return redirect()->route('kategori-spg.trash')
                ->with('success', 'Kategori SPG berhasil dipulihkan');
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
        $kategoriSpg = DB::table('md_kategorisppg')
            ->select('*')
            ->where('status_ksp', 0)
            ->orderBy('updated_at', 'desc')
            ->paginate(10);

        return view('kategori-spg.trash', compact('kategoriSpg'));
    }

    /**
     * Permanent delete kategori SPG
     */
    public function forceDelete($id)
    {
        try {
            // Validasi ID
            if (!is_numeric($id)) {
                return redirect()->route('kategori-spg.trash')
                    ->with('error', 'ID kategori SPG tidak valid');
            }

            $kategoriSpg = DB::table('md_kategorisppg')
                ->where('id_ksp', $id)
                ->where('status_ksp', 0)
                ->first();

            if (!$kategoriSpg) {
                return redirect()->route('kategori-spg.trash')
                    ->with('error', 'Data kategori SPG tidak ditemukan');
            }

            DB::table('md_kategorisppg')
                ->where('id_ksp', $id)
                ->delete();

            return redirect()->route('kategori-spg.trash')
                ->with('success', 'Kategori SPG berhasil dihapus permanen');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    // ===== REST API METHODS =====

    /**
     * API: Get all kategori SPG data
     */
    public function apiIndex(Request $request)
    {
        try {
            $query = DB::table('md_kategorisppg')
                ->select('*')
                ->where('status_ksp', 1)
                ->orderBy('id_ksp', 'desc');

            // Search functionality
            if ($request->has('search') && !empty($request->search)) {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->where('nama_ksp', 'ILIKE', "%{$search}%")
                      ->orWhere('id_ksp', 'ILIKE', "%{$search}%");
                });
            }

            $kategoriSpg = $query->get();

            return response()->json([
                'success' => true,
                'message' => 'Data kategori SPG berhasil diambil',
                'data' => $kategoriSpg
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
     * API: Get kategori SPG by ID
     */
    public function apiShow($id)
    {
        try {
            $kategoriSpg = DB::table('md_kategorisppg')
                ->where('id_ksp', $id)
                ->where('status_ksp', 1)
                ->first();

            if (!$kategoriSpg) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data kategori SPG tidak ditemukan',
                    'data' => null
                ], 404);
            }

            return response()->json([
                'success' => true,
                'message' => 'Data kategori SPG berhasil diambil',
                'data' => $kategoriSpg
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
     * API: Store new kategori SPG
     */
  public function apiStore(Request $request)
{
    $validator = Validator::make($request->all(), [
        'id_ksp'    => 'required|integer|unique:md_kategorisppg,id_ksp',
        'nama_ksp'  => 'required|string|max:100'
    ]);

    if ($validator->fails()) {
        return response()->json([
            'success' => false,
            'message' => 'Validasi gagal',
            'errors' => $validator->errors()
        ], 422);
    }

    try {
        DB::table('md_kategorisppg')->insert([
            'id_ksp'      => $request->id_ksp,
            'nama_ksp'    => $request->nama_ksp,
            'status_ksp'  => 1,
            'created_at'  => Carbon::now()->setTimezone('Asia/Jakarta'),
            'updated_at'  => Carbon::now()->setTimezone('Asia/Jakarta')
        ]);

        // Ambil ulang data berdasarkan ID manual
        $kategoriSpg = DB::table('md_kategorisppg')
            ->where('id_ksp', $request->id_ksp)
            ->first();

        return response()->json([
            'success' => true,
            'message' => 'Kategori SPG berhasil ditambahkan',
            'data' => $kategoriSpg
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
     * API: Update kategori SPG
     */
    public function apiUpdate(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama_ksp' => 'required|string|max:100'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $kategoriSpg = DB::table('md_kategorisppg')
                ->where('id_ksp', $id)
                ->where('status_ksp', 1)
                ->first();

            if (!$kategoriSpg) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data kategori SPG tidak ditemukan',
                    'data' => null
                ], 404);
            }

            DB::table('md_kategorisppg')
                ->where('id_ksp', $id)
                ->update([
                    'nama_ksp' => $request->nama_ksp,
                    'updated_at' => Carbon::now()->setTimezone('Asia/Jakarta')
                ]);

            $updatedKategoriSpg = DB::table('md_kategorisppg')
                ->where('id_ksp', $id)
                ->first();

            return response()->json([
                'success' => true,
                'message' => 'Kategori SPG berhasil diperbarui',
                'data' => $updatedKategoriSpg
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
     * API: Delete kategori SPG (set status to 0)
     */
    public function apiDestroy($id)
    {
        try {
            $kategoriSpg = DB::table('md_kategorisppg')
                ->where('id_ksp', $id)
                ->where('status_ksp', 1)
                ->first();

            if (!$kategoriSpg) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data kategori SPG tidak ditemukan',
                    'data' => null
                ], 404);
            }

            // Set status menjadi 0
            DB::table('md_kategorisppg')
                ->where('id_ksp', $id)
                ->update([
                    'status_ksp' => 0,
                    'updated_at' => Carbon::now()->setTimezone('Asia/Jakarta')
                ]);

            return response()->json([
                'success' => true,
                'message' => 'Kategori SPG berhasil dihapus',
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
            $kategoriSpg = DB::table('md_kategorisppg')
                ->select('*')
                ->where('status_ksp', 0)
                ->orderBy('updated_at', 'desc')
                ->get();

            return response()->json([
                'success' => true,
                'message' => 'Data trash berhasil diambil',
                'data' => $kategoriSpg
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
     * API: Restore kategori SPG (set status back to 1)
     */
    public function apiRestore($id)
    {
        try {
            $kategoriSpg = DB::table('md_kategorisppg')
                ->where('id_ksp', $id)
                ->where('status_ksp', 0)
                ->first();

            if (!$kategoriSpg) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data kategori SPG tidak ditemukan',
                    'data' => null
                ], 404);
            }

            DB::table('md_kategorisppg')
                ->where('id_ksp', $id)
                ->update([
                    'status_ksp' => 1,
                    'updated_at' => Carbon::now()->setTimezone('Asia/Jakarta')
                ]);

            $restoredKategoriSpg = DB::table('md_kategorisppg')
                ->where('id_ksp', $id)
                ->first();

            return response()->json([
                'success' => true,
                'message' => 'Kategori SPG berhasil dipulihkan',
                'data' => $restoredKategoriSpg
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