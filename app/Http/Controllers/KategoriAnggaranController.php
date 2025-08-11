<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class KategoriAnggaranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = DB::table('md_kategorianggaran')
            ->select('*')
            ->where('status_kag', 1) // Hanya tampilkan data dengan status aktif
            ->orderBy('id_kag', 'desc');

        // Search functionality
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_kag', 'ILIKE', "%{$search}%")
                  ->orWhere('id_kag', 'ILIKE', "%{$search}%");
            });
        }

        $kategoriAnggaran = $query->paginate(10);

        return view('kategori-anggaran.index', compact('kategoriAnggaran'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('kategori-anggaran.create');
    }

    /**
     * Store a newly created resource in storage.
     */
  public function store(Request $request)
{
    $validated = $request->validate([
        'id_kag' => 'nullable|integer|unique:md_kategorianggaran,id_kag',
        'nama_kag' => 'required|string|max:100',
    ]);

    try {
        DB::table('md_kategorianggaran')->insert([
            'id_kag'     => $request->id_kag ?: null, // boleh null
            'nama_kag'   => $request->nama_kag,
            'status_kag' => 1,
            'created_at' => now('Asia/Jakarta'),
            'updated_at' => now('Asia/Jakarta'),
        ]);

        return redirect()->route('kategori-anggaran.index')
            ->with('success', 'Kategori berhasil ditambahkan.');
    } catch (\Exception $e) {
        return redirect()->back()
            ->with('error', 'Gagal menyimpan: ' . $e->getMessage())
            ->withInput();
    }
}

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $kategoriAnggaran = DB::table('md_kategorianggaran')
            ->where('id_kag', $id)
            ->where('status_kag', 1)
            ->first();

        if (!$kategoriAnggaran) {
            return redirect()->route('kategori-anggaran.index')
                ->with('error', 'Data kategori anggaran tidak ditemukan');
        }

        return view('kategori-anggaran.show', compact('kategoriAnggaran'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $kategoriAnggaran = DB::table('md_kategorianggaran')
            ->where('id_kag', $id)
            ->where('status_kag', 1)
            ->first();

        if (!$kategoriAnggaran) {
            return redirect()->route('kategori-anggaran.index')
                ->with('error', 'Data kategori anggaran tidak ditemukan');
        }

        return view('kategori-anggaran.edit', compact('kategoriAnggaran'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama_kag' => 'required|string|max:100'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $kategoriAnggaran = DB::table('md_kategorianggaran')
                ->where('id_kag', $id)
                ->where('status_kag', 1)
                ->first();

            if (!$kategoriAnggaran) {
                return redirect()->route('kategori-anggaran.index')
                    ->with('error', 'Data kategori anggaran tidak ditemukan');
            }

            DB::table('md_kategorianggaran')
                ->where('id_kag', $id)
                ->update([
                    'nama_kag' => $request->nama_kag,
                    'updated_at' => Carbon::now()->setTimezone('Asia/Jakarta')
                ]);

            return redirect()->route('kategori-anggaran.index')
                ->with('success', 'Kategori anggaran berhasil diperbarui');
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
            $kategoriAnggaran = DB::table('md_kategorianggaran')
                ->where('id_kag', $id)
                ->where('status_kag', 1)
                ->first();

            if (!$kategoriAnggaran) {
                return redirect()->route('kategori-anggaran.index')
                    ->with('error', 'Data kategori anggaran tidak ditemukan');
            }

            // Set status menjadi 0 (tidak aktif/dihapus)
            DB::table('md_kategorianggaran')
                ->where('id_kag', $id)
                ->update([
                    'status_kag' => 0,
                    'updated_at' => Carbon::now()->setTimezone('Asia/Jakarta')
                ]);

            return redirect()->route('kategori-anggaran.index')
                ->with('success', 'Kategori anggaran berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Get all kategori anggaran data for API or AJAX
     */
    public function getData()
    {
        $kategoriAnggaran = DB::table('md_kategorianggaran')
            ->select('*')
            ->where('status_kag', 1)
            ->orderBy('id_kag', 'desc')
            ->get();

        return response()->json($kategoriAnggaran);
    }

    /**
     * Restore kategori anggaran (Set status back to 1)
     */
    public function restore($id)
    {
        try {
            $kategoriAnggaran = DB::table('md_kategorianggaran')
                ->where('id_kag', $id)
                ->where('status_kag', 0)
                ->first();

            if (!$kategoriAnggaran) {
                return redirect()->route('kategori-anggaran.trash')
                    ->with('error', 'Data kategori anggaran tidak ditemukan');
            }

            DB::table('md_kategorianggaran')
                ->where('id_kag', $id)
                ->update([
                    'status_kag' => 1,
                    'updated_at' => Carbon::now()->setTimezone('Asia/Jakarta')
                ]);

            return redirect()->route('kategori-anggaran.trash')
                ->with('success', 'Kategori anggaran berhasil dipulihkan');
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
        $kategoriAnggaran = DB::table('md_kategorianggaran')
            ->select('*')
            ->where('status_kag', 0)
            ->orderBy('updated_at', 'desc')
            ->paginate(10);

        return view('kategori-anggaran.trash', compact('kategoriAnggaran'));
    }

    /**
     * Permanent delete kategori anggaran
     */
    public function forceDelete($id)
    {
        try {
            // Validasi ID
            if (!is_numeric($id)) {
                return redirect()->route('kategori-anggaran.trash')
                    ->with('error', 'ID kategori anggaran tidak valid');
            }

            $kategoriAnggaran = DB::table('md_kategorianggaran')
                ->where('id_kag', $id)
                ->where('status_kag', 0)
                ->first();

            if (!$kategoriAnggaran) {
                return redirect()->route('kategori-anggaran.trash')
                    ->with('error', 'Data kategori anggaran tidak ditemukan');
            }

            DB::table('md_kategorianggaran')
                ->where('id_kag', $id)
                ->delete();

            return redirect()->route('kategori-anggaran.trash')
                ->with('success', 'Kategori anggaran berhasil dihapus permanen');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    // ===== REST API METHODS =====

    /**
     * API: Get all kategori anggaran data
     */
    public function apiIndex(Request $request)
    {
        try {
            $query = DB::table('md_kategorianggaran')
                ->select('*')
                ->where('status_kag', 1)
                ->orderBy('id_kag', 'desc');

            // Search functionality
            if ($request->has('search') && !empty($request->search)) {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->where('nama_kag', 'ILIKE', "%{$search}%")
                      ->orWhere('id_kag', 'ILIKE', "%{$search}%");
                });
            }

            $kategoriAnggaran = $query->get();

            return response()->json([
                'success' => true,
                'message' => 'Data kategori anggaran berhasil diambil',
                'data' => $kategoriAnggaran
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
     * API: Get kategori anggaran by ID
     */
    public function apiShow($id)
    {
        try {
            $kategoriAnggaran = DB::table('md_kategorianggaran')
                ->where('id_kag', $id)
                ->where('status_kag', 1)
                ->first();

            if (!$kategoriAnggaran) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data kategori anggaran tidak ditemukan',
                    'data' => null
                ], 404);
            }

            return response()->json([
                'success' => true,
                'message' => 'Data kategori anggaran berhasil diambil',
                'data' => $kategoriAnggaran
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
     * API: Store new kategori anggaran
     */
    public function apiStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_kag' => 'required|string|max:100'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $id = DB::table('md_kategorianggaran')->insertGetId([
                'nama_kag' => $request->nama_kag,
                'status_kag' => 1,
                'created_at' => Carbon::now()->setTimezone('Asia/Jakarta'),
                'updated_at' => Carbon::now()->setTimezone('Asia/Jakarta')
            ]);

            // Get the inserted record
            $kategoriAnggaran = DB::table('md_kategorianggaran')
                ->where('id_kag', $id)
                ->first();

            return response()->json([
                'success' => true,
                'message' => 'Kategori anggaran berhasil ditambahkan',
                'data' => $kategoriAnggaran
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
     * API: Update kategori anggaran
     */
    public function apiUpdate(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama_kag' => 'required|string|max:100'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $kategoriAnggaran = DB::table('md_kategorianggaran')
                ->where('id_kag', $id)
                ->where('status_kag', 1)
                ->first();

            if (!$kategoriAnggaran) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data kategori anggaran tidak ditemukan',
                    'data' => null
                ], 404);
            }

            DB::table('md_kategorianggaran')
                ->where('id_kag', $id)
                ->update([
                    'nama_kag' => $request->nama_kag,
                    'updated_at' => Carbon::now()->setTimezone('Asia/Jakarta')
                ]);

            $updatedKategoriAnggaran = DB::table('md_kategorianggaran')
                ->where('id_kag', $id)
                ->first();

            return response()->json([
                'success' => true,
                'message' => 'Kategori anggaran berhasil diperbarui',
                'data' => $updatedKategoriAnggaran
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
     * API: Delete kategori anggaran (set status to 0)
     */
    public function apiDestroy($id)
    {
        try {
            $kategoriAnggaran = DB::table('md_kategorianggaran')
                ->where('id_kag', $id)
                ->where('status_kag', 1)
                ->first();

            if (!$kategoriAnggaran) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data kategori anggaran tidak ditemukan',
                    'data' => null
                ], 404);
            }

            // Set status menjadi 0
            DB::table('md_kategorianggaran')
                ->where('id_kag', $id)
                ->update([
                    'status_kag' => 0,
                    'updated_at' => Carbon::now()->setTimezone('Asia/Jakarta')
                ]);

            return response()->json([
                'success' => true,
                'message' => 'Kategori anggaran berhasil dihapus',
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
            $kategoriAnggaran = DB::table('md_kategorianggaran')
                ->select('*')
                ->where('status_kag', 0)
                ->orderBy('updated_at', 'desc')
                ->get();

            return response()->json([
                'success' => true,
                'message' => 'Data trash berhasil diambil',
                'data' => $kategoriAnggaran
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
     * API: Restore kategori anggaran (set status back to 1)
     */
    public function apiRestore($id)
    {
        try {
            $kategoriAnggaran = DB::table('md_kategorianggaran')
                ->where('id_kag', $id)
                ->where('status_kag', 0)
                ->first();

            if (!$kategoriAnggaran) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data kategori anggaran tidak ditemukan',
                    'data' => null
                ], 404);
            }

            DB::table('md_kategorianggaran')
                ->where('id_kag', $id)
                ->update([
                    'status_kag' => 1,
                    'updated_at' => Carbon::now()->setTimezone('Asia/Jakarta')
                ]);

            $restoredKategoriAnggaran = DB::table('md_kategorianggaran')
                ->where('id_kag', $id)
                ->first();

            return response()->json([
                'success' => true,
                'message' => 'Kategori anggaran berhasil dipulihkan',
                'data' => $restoredKategoriAnggaran
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