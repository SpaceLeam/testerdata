<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class AnggaranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = DB::table('md_anggaran')
            ->leftJoin('md_kategorianggaran', 'md_anggaran.id_kag', '=', 'md_kategorianggaran.id_kag')
            ->select('md_anggaran.*', 'md_kategorianggaran.nama_kag')
            ->where('md_anggaran.status_agr', 1) // Hanya tampilkan data dengan status aktif
            ->orderBy('md_anggaran.id_agr', 'desc');

        // Search functionality
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('md_anggaran.nama_agr', 'ILIKE', "%{$search}%")
                  ->orWhere('md_kategorianggaran.nama_kag', 'ILIKE', "%{$search}%");
            });
        }

        $anggaran = $query->paginate(10);

        return view('anggaran.index', compact('anggaran'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Get active kategori anggaran for dropdown
        $kategoriAnggaran = DB::table('md_kategorianggaran')
            ->where('status_kag', 1)
            ->orderBy('nama_kag', 'asc')
            ->get();

        return view('anggaran.create', compact('kategoriAnggaran'));
    }

    /**
     * Store a newly created resource in storage.
     */
  public function store(Request $request)
{
    $validator = Validator::make($request->all(), [
        'id_agr' => 'required|integer|unique:md_anggaran,id_agr',
        'id_kag' => 'required|integer|exists:md_kategorianggaran,id_kag',
        'nama_agr' => 'required|string|max:100'
        // tidak perlu validasi status_agr kalau kamu hardcode default
    ]);

    if ($validator->fails()) {
        return redirect()->back()
            ->withErrors($validator)
            ->withInput();
    }

    try {
        DB::table('md_anggaran')->insert([
            'id_agr' => $request->id_agr,
            'id_kag' => $request->id_kag,
            'nama_agr' => $request->nama_agr,
            'status_agr' => 1, // <- PENTING: karena NOT NULL
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        return redirect()->route('anggaran.index')
            ->with('success', 'Anggaran berhasil ditambahkan');
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
        $anggaran = DB::table('md_anggaran')
            ->leftJoin('md_kategorianggaran', 'md_anggaran.id_kag', '=', 'md_kategorianggaran.id_kag')
            ->select('md_anggaran.*', 'md_kategorianggaran.nama_kag')
            ->where('md_anggaran.id_agr', $id)
            ->where('md_anggaran.status_agr', 1)
            ->first();

        if (!$anggaran) {
            return redirect()->route('anggaran.index')
                ->with('error', 'Data anggaran tidak ditemukan');
        }

        return view('anggaran.show', compact('anggaran'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $anggaran = DB::table('md_anggaran')
            ->where('id_agr', $id)
            ->where('status_agr', 1)
            ->first();

        if (!$anggaran) {
            return redirect()->route('anggaran.index')
                ->with('error', 'Data anggaran tidak ditemukan');
        }

        // Get active kategori anggaran for dropdown
        $kategoriAnggaran = DB::table('md_kategorianggaran')
            ->where('status_kag', 1)
            ->orderBy('nama_kag', 'asc')
            ->get();

        return view('anggaran.edit', compact('anggaran', 'kategoriAnggaran'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'id_kag' => 'required|integer|exists:md_kategorianggaran,id_kag',
            'nama_agr' => 'required|string|max:100',
            'status_agr' => 'required|integer|in:0,1'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $anggaran = DB::table('md_anggaran')
                ->where('id_agr', $id)
                ->where('status_agr', 1)
                ->first();

            if (!$anggaran) {
                return redirect()->route('anggaran.index')
                    ->with('error', 'Data anggaran tidak ditemukan');
            }

            $updateData = [
                'id_kag' => $request->id_kag,
                'nama_agr' => $request->nama_agr,
                'status_agr' => $request->status_agr,
                'updated_at' => Carbon::now()
            ];

            DB::table('md_anggaran')
                ->where('id_agr', $id)
                ->update($updateData);

            return redirect()->route('anggaran.index')
                ->with('success', 'Anggaran berhasil diperbarui');
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
            $anggaran = DB::table('md_anggaran')
                ->where('id_agr', $id)
                ->where('status_agr', 1)
                ->first();

            if (!$anggaran) {
                return redirect()->route('anggaran.index')
                    ->with('error', 'Data anggaran tidak ditemukan');
            }

            // Set status menjadi 0 (tidak aktif/dihapus)
            DB::table('md_anggaran')
                ->where('id_agr', $id)
                ->update([
                    'status_agr' => 0,
                    'updated_at' => Carbon::now()
                ]);

            return redirect()->route('anggaran.index')
                ->with('success', 'Anggaran berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Get all anggaran data for API or AJAX
     */
    public function getData()
    {
        $anggaran = DB::table('md_anggaran')
            ->leftJoin('md_kategorianggaran', 'md_anggaran.id_kag', '=', 'md_kategorianggaran.id_kag')
            ->select('md_anggaran.*', 'md_kategorianggaran.nama_kag')
            ->where('md_anggaran.status_agr', 1)
            ->orderBy('md_anggaran.id_agr', 'desc')
            ->get();

        return response()->json($anggaran);
    }

    /**
     * Restore anggaran (Set status back to 1)
     */
    public function restore($id)
    {
        try {
            $anggaran = DB::table('md_anggaran')
                ->where('id_agr', $id)
                ->where('status_agr', 0)
                ->first();

            if (!$anggaran) {
                return redirect()->route('anggaran.trash')
                    ->with('error', 'Data anggaran tidak ditemukan');
            }

            DB::table('md_anggaran')
                ->where('id_agr', $id)
                ->update([
                    'status_agr' => 1,
                    'updated_at' => Carbon::now()
                ]);

            return redirect()->route('anggaran.trash')
                ->with('success', 'Anggaran berhasil dipulihkan');
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
        $anggaran = DB::table('md_anggaran')
            ->leftJoin('md_kategorianggaran', 'md_anggaran.id_kag', '=', 'md_kategorianggaran.id_kag')
            ->select('md_anggaran.*', 'md_kategorianggaran.nama_kag')
            ->where('md_anggaran.status_agr', 0)
            ->orderBy('md_anggaran.updated_at', 'desc')
            ->paginate(10);

        return view('anggaran.trash', compact('anggaran'));
    }

    /**
     * Permanent delete anggaran
     */
    public function forceDelete($id)
    {
        try {
            // Validasi ID
            if (!is_numeric($id)) {
                return redirect()->route('anggaran.trash')
                    ->with('error', 'ID anggaran tidak valid');
            }

            $anggaran = DB::table('md_anggaran')
                ->where('id_agr', $id)
                ->where('status_agr', 0)
                ->first();

            if (!$anggaran) {
                return redirect()->route('anggaran.trash')
                    ->with('error', 'Data anggaran tidak ditemukan');
            }

            DB::table('md_anggaran')
                ->where('id_agr', $id)
                ->delete();

            return redirect()->route('anggaran.trash')
                ->with('success', 'Anggaran berhasil dihapus permanen');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    // ===== REST API METHODS =====

    /**
     * API: Get all anggaran data
     */
    public function apiIndex(Request $request)
    {
        try {
            $query = DB::table('md_anggaran')
                ->leftJoin('md_kategorianggaran', 'md_anggaran.id_kag', '=', 'md_kategorianggaran.id_kag')
                ->select('md_anggaran.*', 'md_kategorianggaran.nama_kag')
                ->where('md_anggaran.status_agr', 1)
                ->orderBy('md_anggaran.id_agr', 'desc');

            // Search functionality
            if ($request->has('search') && !empty($request->search)) {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->where('md_anggaran.nama_agr', 'ILIKE', "%{$search}%")
                      ->orWhere('md_kategorianggaran.nama_kag', 'ILIKE', "%{$search}%");
                });
            }

            $anggaran = $query->get();

            return response()->json([
                'success' => true,
                'message' => 'Data anggaran berhasil diambil',
                'data' => $anggaran
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
     * API: Get anggaran by ID
     */
    public function apiShow($id)
    {
        try {
            $anggaran = DB::table('md_anggaran')
                ->leftJoin('md_kategorianggaran', 'md_anggaran.id_kag', '=', 'md_kategorianggaran.id_kag')
                ->select('md_anggaran.*', 'md_kategorianggaran.nama_kag')
                ->where('md_anggaran.id_agr', $id)
                ->where('md_anggaran.status_agr', 1)
                ->first();

            if (!$anggaran) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data anggaran tidak ditemukan',
                    'data' => null
                ], 404);
            }

            return response()->json([
                'success' => true,
                'message' => 'Data anggaran berhasil diambil',
                'data' => $anggaran
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
     * API: Store new anggaran
     */
    public function apiStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_kag' => 'required|integer|exists:md_kategorianggaran,id_kag',
            'nama_agr' => 'required|string|max:100',
            'status_agr' => 'required|integer|in:0,1'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            DB::table('md_anggaran')->insert([
                'id_kag' => $request->id_kag,
                'nama_agr' => $request->nama_agr,
                'status_agr' => $request->status_agr,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);

            // Get the last inserted record
            $anggaran = DB::table('md_anggaran')
                ->leftJoin('md_kategorianggaran', 'md_anggaran.id_kag', '=', 'md_kategorianggaran.id_kag')
                ->select('md_anggaran.*', 'md_kategorianggaran.nama_kag')
                ->where('md_anggaran.status_agr', 1)
                ->orderBy('md_anggaran.id_agr', 'desc')
                ->first();

            return response()->json([
                'success' => true,
                'message' => 'Anggaran berhasil ditambahkan',
                'data' => $anggaran
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
     * API: Update anggaran
     */
    public function apiUpdate(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'id_kag' => 'required|integer|exists:md_kategorianggaran,id_kag',
            'nama_agr' => 'required|string|max:100',
            'status_agr' => 'required|integer|in:0,1'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $anggaran = DB::table('md_anggaran')
                ->where('id_agr', $id)
                ->where('status_agr', 1)
                ->first();

            if (!$anggaran) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data anggaran tidak ditemukan',
                    'data' => null
                ], 404);
            }

            $updateData = [
                'id_kag' => $request->id_kag,
                'nama_agr' => $request->nama_agr,
                'status_agr' => $request->status_agr,
                'updated_at' => Carbon::now()
            ];

            DB::table('md_anggaran')
                ->where('id_agr', $id)
                ->update($updateData);

            $updatedAnggaran = DB::table('md_anggaran')
                ->leftJoin('md_kategorianggaran', 'md_anggaran.id_kag', '=', 'md_kategorianggaran.id_kag')
                ->select('md_anggaran.*', 'md_kategorianggaran.nama_kag')
                ->where('md_anggaran.id_agr', $id)
                ->first();

            return response()->json([
                'success' => true,
                'message' => 'Anggaran berhasil diperbarui',
                'data' => $updatedAnggaran
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
     * API: Delete anggaran (set status to 0)
     */
    public function apiDestroy($id)
    {
        try {
            $anggaran = DB::table('md_anggaran')
                ->where('id_agr', $id)
                ->where('status_agr', 1)
                ->first();

            if (!$anggaran) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data anggaran tidak ditemukan',
                    'data' => null
                ], 404);
            }

            // Set status menjadi 0
            DB::table('md_anggaran')
                ->where('id_agr', $id)
                ->update([
                    'status_agr' => 0,
                    'updated_at' => Carbon::now()
                ]);

            return response()->json([
                'success' => true,
                'message' => 'Anggaran berhasil dihapus',
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
            $anggaran = DB::table('md_anggaran')
                ->leftJoin('md_kategorianggaran', 'md_anggaran.id_kag', '=', 'md_kategorianggaran.id_kag')
                ->select('md_anggaran.*', 'md_kategorianggaran.nama_kag')
                ->where('md_anggaran.status_agr', 0)
                ->orderBy('md_anggaran.updated_at', 'desc')
                ->get();

            return response()->json([
                'success' => true,
                'message' => 'Data trash berhasil diambil',
                'data' => $anggaran
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
     * API: Restore anggaran (set status back to 1)
     */
    public function apiRestore($id)
    {
        try {
            $anggaran = DB::table('md_anggaran')
                ->where('id_agr', $id)
                ->where('status_agr', 0)
                ->first();

            if (!$anggaran) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data anggaran tidak ditemukan',
                    'data' => null
                ], 404);
            }

            DB::table('md_anggaran')
                ->where('id_agr', $id)
                ->update([
                    'status_agr' => 1,
                    'updated_at' => Carbon::now()
                ]);

            $restoredAnggaran = DB::table('md_anggaran')
                ->leftJoin('md_kategorianggaran', 'md_anggaran.id_kag', '=', 'md_kategorianggaran.id_kag')
                ->select('md_anggaran.*', 'md_kategorianggaran.nama_kag')
                ->where('md_anggaran.id_agr', $id)
                ->first();

            return response()->json([
                'success' => true,
                'message' => 'Anggaran berhasil dipulihkan',
                'data' => $restoredAnggaran
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