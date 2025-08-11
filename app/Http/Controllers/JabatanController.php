<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class JabatanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = DB::table('md_jabatan')
            ->where('status_jbt', 1) // Hanya tampilkan data dengan status aktif
            ->orderBy('id_jbt', 'desc');

        // Search functionality
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where('nama_jbt', 'ILIKE', "%{$search}%");
        }

        $jabatan = $query->paginate(10);

        return view('jabatan.index', compact('jabatan'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('jabatan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_jbt' => 'required|string|max:50'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            DB::table('md_jabatan')->insert([
                'nama_jbt' => $request->nama_jbt,
                'status_jbt' => 1, // Status aktif saat dibuat
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);

            return redirect()->route('jabatan.index')
                ->with('success', 'Jabatan berhasil ditambahkan');
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
        $jabatan = DB::table('md_jabatan')
            ->where('id_jbt', $id)
            ->where('status_jbt', 1)
            ->first();

        if (!$jabatan) {
            return redirect()->route('jabatan.index')
                ->with('error', 'Data jabatan tidak ditemukan');
        }

        return view('jabatan.show', compact('jabatan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $jabatan = DB::table('md_jabatan')
            ->where('id_jbt', $id)
            ->where('status_jbt', 1)
            ->first();

        if (!$jabatan) {
            return redirect()->route('jabatan.index')
                ->with('error', 'Data jabatan tidak ditemukan');
        }

        return view('jabatan.edit', compact('jabatan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama_jbt' => 'required|string|max:50'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $jabatan = DB::table('md_jabatan')
                ->where('id_jbt', $id)
                ->where('status_jbt', 1)
                ->first();

            if (!$jabatan) {
                return redirect()->route('jabatan.index')
                    ->with('error', 'Data jabatan tidak ditemukan');
            }

            DB::table('md_jabatan')
                ->where('id_jbt', $id)
                ->update([
                    'nama_jbt' => $request->nama_jbt,
                    'updated_at' => Carbon::now()
                ]);

            return redirect()->route('jabatan.index')
                ->with('success', 'Jabatan berhasil diperbarui');
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
            $jabatan = DB::table('md_jabatan')
                ->where('id_jbt', $id)
                ->where('status_jbt', 1)
                ->first();

            if (!$jabatan) {
                return redirect()->route('jabatan.index')
                    ->with('error', 'Data jabatan tidak ditemukan');
            }

            // Set status menjadi 0 (tidak aktif/dihapus)
            DB::table('md_jabatan')
                ->where('id_jbt', $id)
                ->update([
                    'status_jbt' => 0,
                    'updated_at' => Carbon::now()
                ]);

            return redirect()->route('jabatan.index')
                ->with('success', 'Jabatan berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Get all jabatan data for API or AJAX
     */
    public function getData()
    {
        $jabatan = DB::table('md_jabatan')
            ->where('status_jbt', 1)
            ->orderBy('id_jbt', 'desc')
            ->get();

        return response()->json($jabatan);
    }

    /**
     * Restore jabatan (Set status back to 1)
     */
    public function restore($id)
    {
        try {
            $jabatan = DB::table('md_jabatan')
                ->where('id_jbt', $id)
                ->where('status_jbt', 0)
                ->first();

            if (!$jabatan) {
                return redirect()->route('jabatan.trash')
                    ->with('error', 'Data jabatan tidak ditemukan');
            }

            DB::table('md_jabatan')
                ->where('id_jbt', $id)
                ->update([
                    'status_jbt' => 1,
                    'updated_at' => Carbon::now()
                ]);

            return redirect()->route('jabatan.trash')
                ->with('success', 'Jabatan berhasil dipulihkan');
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
        $jabatan = DB::table('md_jabatan')
            ->where('status_jbt', 0)
            ->orderBy('updated_at', 'desc')
            ->paginate(10);

        return view('jabatan.trash', compact('jabatan'));
    }

    /**
     * Permanent delete jabatan
     */
    public function forceDelete($id)
    {
        try {
            // Validasi ID
            if (!is_numeric($id)) {
                return redirect()->route('jabatan.trash')
                    ->with('error', 'ID jabatan tidak valid');
            }

            $jabatan = DB::table('md_jabatan')
                ->where('id_jbt', $id)
                ->where('status_jbt', 0)
                ->first();

            if (!$jabatan) {
                return redirect()->route('jabatan.trash')
                    ->with('error', 'Data jabatan tidak ditemukan');
            }

            DB::table('md_jabatan')
                ->where('id_jbt', $id)
                ->delete();

            return redirect()->route('jabatan.trash')
                ->with('success', 'Jabatan berhasil dihapus permanen');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    // ===== REST API METHODS =====

    /**
     * API: Get all jabatan data
     */
    public function apiIndex(Request $request)
    {
        try {
            $query = DB::table('md_jabatan')
                ->where('status_jbt', 1)
                ->orderBy('id_jbt', 'desc');

            // Search functionality
            if ($request->has('search') && !empty($request->search)) {
                $search = $request->search;
                $query->where('nama_jbt', 'ILIKE', "%{$search}%");
            }

            $jabatan = $query->get();

            return response()->json([
                'success' => true,
                'message' => 'Data jabatan berhasil diambil',
                'data' => $jabatan
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
     * API: Get jabatan by ID
     */
    public function apiShow($id)
    {
        try {
            $jabatan = DB::table('md_jabatan')
                ->where('id_jbt', $id)
                ->where('status_jbt', 1)
                ->first();

            if (!$jabatan) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data jabatan tidak ditemukan',
                    'data' => null
                ], 404);
            }

            return response()->json([
                'success' => true,
                'message' => 'Data jabatan berhasil diambil',
                'data' => $jabatan
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
     * API: Store new jabatan
     */
    public function apiStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_jbt' => 'required|string|max:50'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            DB::table('md_jabatan')->insert([
                'nama_jbt' => $request->nama_jbt,
                'status_jbt' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);

            // Get the last inserted record
            $jabatan = DB::table('md_jabatan')
                ->where('status_jbt', 1)
                ->orderBy('id_jbt', 'desc')
                ->first();

            return response()->json([
                'success' => true,
                'message' => 'Jabatan berhasil ditambahkan',
                'data' => $jabatan
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
     * API: Update jabatan
     */
    public function apiUpdate(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama_jbt' => 'required|string|max:50'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $jabatan = DB::table('md_jabatan')
                ->where('id_jbt', $id)
                ->where('status_jbt', 1)
                ->first();

            if (!$jabatan) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data jabatan tidak ditemukan',
                    'data' => null
                ], 404);
            }

            DB::table('md_jabatan')
                ->where('id_jbt', $id)
                ->update([
                    'nama_jbt' => $request->nama_jbt,
                    'updated_at' => Carbon::now()
                ]);

            $updatedJabatan = DB::table('md_jabatan')
                ->where('id_jbt', $id)
                ->first();

            return response()->json([
                'success' => true,
                'message' => 'Jabatan berhasil diperbarui',
                'data' => $updatedJabatan
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
     * API: Delete jabatan (set status to 0)
     */
    public function apiDestroy($id)
    {
        try {
            $jabatan = DB::table('md_jabatan')
                ->where('id_jbt', $id)
                ->where('status_jbt', 1)
                ->first();

            if (!$jabatan) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data jabatan tidak ditemukan',
                    'data' => null
                ], 404);
            }

            // Set status menjadi 0
            DB::table('md_jabatan')
                ->where('id_jbt', $id)
                ->update([
                    'status_jbt' => 0,
                    'updated_at' => Carbon::now()
                ]);

            return response()->json([
                'success' => true,
                'message' => 'Jabatan berhasil dihapus',
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
            $jabatan = DB::table('md_jabatan')
                ->where('status_jbt', 0)
                ->orderBy('updated_at', 'desc')
                ->get();

            return response()->json([
                'success' => true,
                'message' => 'Data trash berhasil diambil',
                'data' => $jabatan
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
     * API: Restore jabatan (set status back to 1)
     */
    public function apiRestore($id)
    {
        try {
            $jabatan = DB::table('md_jabatan')
                ->where('id_jbt', $id)
                ->where('status_jbt', 0)
                ->first();

            if (!$jabatan) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data jabatan tidak ditemukan',
                    'data' => null
                ], 404);
            }

            DB::table('md_jabatan')
                ->where('id_jbt', $id)
                ->update([
                    'status_jbt' => 1,
                    'updated_at' => Carbon::now()
                ]);

            $restoredJabatan = DB::table('md_jabatan')
                ->where('id_jbt', $id)
                ->first();

            return response()->json([
                'success' => true,
                'message' => 'Jabatan berhasil dipulihkan',
                'data' => $restoredJabatan
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