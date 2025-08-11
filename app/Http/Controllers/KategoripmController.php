<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class KategoriPmController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = DB::table('md_kategoripm')
            ->select('*')
            ->where('status_kpm', 1) // Hanya tampilkan data dengan status aktif
            ->orderBy('id_kpm', 'desc');

        // Search functionality
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_kpm', 'ILIKE', "%{$search}%")
                  ->orWhere('id_kpm', 'ILIKE', "%{$search}%");
            });
        }

        $kategoriPm = $query->paginate(10);

        return view('kategori-pm.index', compact('kategoriPm'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('kategori-pm.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    /**
 * Store a newly created resource in storage.
 */
public function store(Request $request)
{
    $validator = Validator::make($request->all(), [
        'id_kpm' => 'required|string|max:50|unique:md_kategoripm,id_kpm',
        'nama_kpm' => 'required|string|max:100'
    ]);

    if ($validator->fails()) {
        return redirect()->back()
            ->withErrors($validator)
            ->withInput();
    }

    try {
        DB::table('md_kategoripm')->insert([
            'id_kpm' => $request->id_kpm,
            'nama_kpm' => $request->nama_kpm,
            'status_kpm' => 1, // Status aktif saat dibuat
            'created_at' => Carbon::now()->setTimezone('Asia/Jakarta'),
            'updated_at' => Carbon::now()->setTimezone('Asia/Jakarta')
        ]);

        return redirect()->route('kategori-pm.index')
            ->with('success', 'Kategori PM berhasil ditambahkan');
    } catch (\Exception $e) {
        return redirect()->back()
            ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
            ->withInput();
    }
} /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $kategoriPm = DB::table('md_kategoripm')
            ->where('id_kpm', $id)
            ->where('status_kpm', 1)
            ->first();

        if (!$kategoriPm) {
            return redirect()->route('kategori-pm.index')
                ->with('error', 'Data kategori PM tidak ditemukan');
        }

        return view('kategori-pm.show', compact('kategoriPm'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $kategoriPm = DB::table('md_kategoripm')
            ->where('id_kpm', $id)
            ->where('status_kpm', 1)
            ->first();

        if (!$kategoriPm) {
            return redirect()->route('kategori-pm.index')
                ->with('error', 'Data kategori PM tidak ditemukan');
        }

        return view('kategori-pm.edit', compact('kategoriPm'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama_kpm' => 'required|string|max:100'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $kategoriPm = DB::table('md_kategoripm')
                ->where('id_kpm', $id)
                ->where('status_kpm', 1)
                ->first();

            if (!$kategoriPm) {
                return redirect()->route('kategori-pm.index')
                    ->with('error', 'Data kategori PM tidak ditemukan');
            }

            DB::table('md_kategoripm')
                ->where('id_kpm', $id)
                ->update([
                    'nama_kpm' => $request->nama_kpm,
                    'updated_at' => Carbon::now()->setTimezone('Asia/Jakarta')
                ]);

            return redirect()->route('kategori-pm.index')
                ->with('success', 'Kategori PM berhasil diperbarui');
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
            $kategoriPm = DB::table('md_kategoripm')
                ->where('id_kpm', $id)
                ->where('status_kpm', 1)
                ->first();

            if (!$kategoriPm) {
                return redirect()->route('kategori-pm.index')
                    ->with('error', 'Data kategori PM tidak ditemukan');
            }

            // Set status menjadi 0 (tidak aktif/dihapus)
            DB::table('md_kategoripm')
                ->where('id_kpm', $id)
                ->update([
                    'status_kpm' => 0,
                    'updated_at' => Carbon::now()->setTimezone('Asia/Jakarta')
                ]);

            return redirect()->route('kategori-pm.index')
                ->with('success', 'Kategori PM berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Get all kategori PM data for API or AJAX
     */
    public function getData()
    {
        $kategoriPm = DB::table('md_kategoripm')
            ->select('*')
            ->where('status_kpm', 1)
            ->orderBy('id_kpm', 'desc')
            ->get();

        return response()->json($kategoriPm);
    }

    /**
     * Restore kategori PM (Set status back to 1)
     */
    public function restore($id)
    {
        try {
            $kategoriPm = DB::table('md_kategoripm')
                ->where('id_kpm', $id)
                ->where('status_kpm', 0)
                ->first();

            if (!$kategoriPm) {
                return redirect()->route('kategori-pm.trash')
                    ->with('error', 'Data kategori PM tidak ditemukan');
            }

            DB::table('md_kategoripm')
                ->where('id_kpm', $id)
                ->update([
                    'status_kpm' => 1,
                    'updated_at' => Carbon::now()->setTimezone('Asia/Jakarta')
                ]);

            return redirect()->route('kategori-pm.trash')
                ->with('success', 'Kategori PM berhasil dipulihkan');
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
        $kategoriPm = DB::table('md_kategoripm')
            ->select('*')
            ->where('status_kpm', 0)
            ->orderBy('updated_at', 'desc')
            ->paginate(10);

        return view('kategori-pm.trash', compact('kategoriPm'));
    }

    /**
     * Permanent delete kategori PM
     */
    public function forceDelete($id)
    {
        try {
            // Validasi ID
            if (!is_numeric($id)) {
                return redirect()->route('kategori-pm.trash')
                    ->with('error', 'ID kategori PM tidak valid');
            }

            $kategoriPm = DB::table('md_kategoripm')
                ->where('id_kpm', $id)
                ->where('status_kpm', 0)
                ->first();

            if (!$kategoriPm) {
                return redirect()->route('kategori-pm.trash')
                    ->with('error', 'Data kategori PM tidak ditemukan');
            }

            DB::table('md_kategoripm')
                ->where('id_kpm', $id)
                ->delete();

            return redirect()->route('kategori-pm.trash')
                ->with('success', 'Kategori PM berhasil dihapus permanen');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    // ===== REST API METHODS =====

    /**
     * API: Get all kategori PM data
     */
    public function apiIndex(Request $request)
    {
        try {
            $query = DB::table('md_kategoripm')
                ->select('*')
                ->where('status_kpm', 1)
                ->orderBy('id_kpm', 'desc');

            // Search functionality
            if ($request->has('search') && !empty($request->search)) {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->where('nama_kpm', 'ILIKE', "%{$search}%")
                      ->orWhere('id_kpm', 'ILIKE', "%{$search}%");
                });
            }

            $kategoriPm = $query->get();

            return response()->json([
                'success' => true,
                'message' => 'Data kategori PM berhasil diambil',
                'data' => $kategoriPm
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
     * API: Get kategori PM by ID
     */
    public function apiShow($id)
    {
        try {
            $kategoriPm = DB::table('md_kategoripm')
                ->where('id_kpm', $id)
                ->where('status_kpm', 1)
                ->first();

            if (!$kategoriPm) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data kategori PM tidak ditemukan',
                    'data' => null
                ], 404);
            }

            return response()->json([
                'success' => true,
                'message' => 'Data kategori PM berhasil diambil',
                'data' => $kategoriPm
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
     * API: Store new kategori PM
     */
    public function apiStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_kpm' => 'required|string|max:100'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $id = DB::table('md_kategoripm')->insertGetId([
                'nama_kpm' => $request->nama_kpm,
                'status_kpm' => 1,
                'created_at' => Carbon::now()->setTimezone('Asia/Jakarta'),
                'updated_at' => Carbon::now()->setTimezone('Asia/Jakarta')
            ]);

            // Get the inserted record
            $kategoriPm = DB::table('md_kategoripm')
                ->where('id_kpm', $id)
                ->first();

            return response()->json([
                'success' => true,
                'message' => 'Kategori PM berhasil ditambahkan',
                'data' => $kategoriPm
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
     * API: Update kategori PM
     */
    public function apiUpdate(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama_kpm' => 'required|string|max:100'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $kategoriPm = DB::table('md_kategoripm')
                ->where('id_kpm', $id)
                ->where('status_kpm', 1)
                ->first();

            if (!$kategoriPm) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data kategori PM tidak ditemukan',
                    'data' => null
                ], 404);
            }

            DB::table('md_kategoripm')
                ->where('id_kpm', $id)
                ->update([
                    'nama_kpm' => $request->nama_kpm,
                    'updated_at' => Carbon::now()->setTimezone('Asia/Jakarta')
                ]);

            $updatedKategoriPm = DB::table('md_kategoripm')
                ->where('id_kpm', $id)
                ->first();

            return response()->json([
                'success' => true,
                'message' => 'Kategori PM berhasil diperbarui',
                'data' => $updatedKategoriPm
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
     * API: Delete kategori PM (set status to 0)
     */
    public function apiDestroy($id)
    {
        try {
            $kategoriPm = DB::table('md_kategoripm')
                ->where('id_kpm', $id)
                ->where('status_kpm', 1)
                ->first();

            if (!$kategoriPm) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data kategori PM tidak ditemukan',
                    'data' => null
                ], 404);
            }

            // Set status menjadi 0
            DB::table('md_kategoripm')
                ->where('id_kpm', $id)
                ->update([
                    'status_kpm' => 0,
                    'updated_at' => Carbon::now()->setTimezone('Asia/Jakarta')
                ]);

            return response()->json([
                'success' => true,
                'message' => 'Kategori PM berhasil dihapus',
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
            $kategoriPm = DB::table('md_kategoripm')
                ->select('*')
                ->where('status_kpm', 0)
                ->orderBy('updated_at', 'desc')
                ->get();

            return response()->json([
                'success' => true,
                'message' => 'Data trash berhasil diambil',
                'data' => $kategoriPm
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
     * API: Restore kategori PM (set status back to 1)
     */
    public function apiRestore($id)
    {
        try {
            $kategoriPm = DB::table('md_kategoripm')
                ->where('id_kpm', $id)
                ->where('status_kpm', 0)
                ->first();

            if (!$kategoriPm) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data kategori PM tidak ditemukan',
                    'data' => null
                ], 404);
            }

            DB::table('md_kategoripm')
                ->where('id_kpm', $id)
                ->update([
                    'status_kpm' => 1,
                    'updated_at' => Carbon::now()->setTimezone('Asia/Jakarta')
                ]);

            $restoredKategoriPm = DB::table('md_kategoripm')
                ->where('id_kpm', $id)
                ->first();

            return response()->json([
                'success' => true,
                'message' => 'Kategori PM berhasil dipulihkan',
                'data' => $restoredKategoriPm
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