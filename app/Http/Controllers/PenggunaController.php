<?php
namespace App\Http\Controllers;  // Huruf besar A

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class PenggunaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = DB::table('md_pengguna')
            ->leftJoin('md_jabatan', 'md_pengguna.id_jbt', '=', 'md_jabatan.id_jbt')
            ->select('md_pengguna.*', 'md_jabatan.nama_jbt')
            ->where('md_pengguna.status_pgn', 1) // Hanya tampilkan data dengan status aktif
            ->orderBy('md_pengguna.id_pgn', 'desc');

        // Search functionality
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('md_pengguna.nama_pgn', 'ILIKE', "%{$search}%")
                  ->orWhere('md_pengguna.email_pgn', 'ILIKE', "%{$search}%");
            });
        }

        $pengguna = $query->paginate(10);

        return view('pengguna.index', compact('pengguna'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Get active jabatan for dropdown
        $jabatan = DB::table('md_jabatan')
            ->where('status_jbt', 1)
            ->orderBy('nama_jbt', 'asc')
            ->get();

        return view('pengguna.create', compact('jabatan'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_jbt' => 'required|integer|exists:md_jabatan,id_jbt',
            'nama_pgn' => 'required|string|max:100',
            'email_pgn' => 'required|email|max:100|unique:md_pengguna,email_pgn',
            'katasandi_pgn' => 'required|string|min:6|max:100'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            DB::table('md_pengguna')->insert([
                'id_jbt' => $request->id_jbt,
                'nama_pgn' => $request->nama_pgn,
                'email_pgn' => $request->email_pgn,
                'katasandi_pgn' => Hash::make($request->katasandi_pgn),
                'status_pgn' => 1, // Status aktif saat dibuat
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);

            return redirect()->route('pengguna.index')
                ->with('success', 'Pengguna berhasil ditambahkan');
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
        $pengguna = DB::table('md_pengguna')
            ->leftJoin('md_jabatan', 'md_pengguna.id_jbt', '=', 'md_jabatan.id_jbt')
            ->select('md_pengguna.*', 'md_jabatan.nama_jbt')
            ->where('md_pengguna.id_pgn', $id)
            ->where('md_pengguna.status_pgn', 1)
            ->first();

        if (!$pengguna) {
            return redirect()->route('pengguna.index')
                ->with('error', 'Data pengguna tidak ditemukan');
        }

        return view('pengguna.show', compact('pengguna'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $pengguna = DB::table('md_pengguna')
            ->where('id_pgn', $id)
            ->where('status_pgn', 1)
            ->first();

        if (!$pengguna) {
            return redirect()->route('pengguna.index')
                ->with('error', 'Data pengguna tidak ditemukan');
        }

        // Get active jabatan for dropdown
        $jabatan = DB::table('md_jabatan')
            ->where('status_jbt', 1)
            ->orderBy('nama_jbt', 'asc')
            ->get();

        return view('pengguna.edit', compact('pengguna', 'jabatan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'id_jbt' => 'required|integer|exists:md_jabatan,id_jbt',
            'nama_pgn' => 'required|string|max:100',
            'email_pgn' => 'required|email|max:100|unique:md_pengguna,email_pgn,' . $id . ',id_pgn',
            'katasandi_pgn' => 'nullable|string|min:6|max:100'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $pengguna = DB::table('md_pengguna')
                ->where('id_pgn', $id)
                ->where('status_pgn', 1)
                ->first();

            if (!$pengguna) {
                return redirect()->route('pengguna.index')
                    ->with('error', 'Data pengguna tidak ditemukan');
            }

            $updateData = [
                'id_jbt' => $request->id_jbt,
                'nama_pgn' => $request->nama_pgn,
                'email_pgn' => $request->email_pgn,
                'updated_at' => Carbon::now()
            ];

            // Only update password if provided
            if (!empty($request->katasandi_pgn)) {
                $updateData['katasandi_pgn'] = Hash::make($request->katasandi_pgn);
            }

            DB::table('md_pengguna')
                ->where('id_pgn', $id)
                ->update($updateData);

            return redirect()->route('pengguna.index')
                ->with('success', 'Pengguna berhasil diperbarui');
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
            $pengguna = DB::table('md_pengguna')
                ->where('id_pgn', $id)
                ->where('status_pgn', 1)
                ->first();

            if (!$pengguna) {
                return redirect()->route('pengguna.index')
                    ->with('error', 'Data pengguna tidak ditemukan');
            }

            // Set status menjadi 0 (tidak aktif/dihapus)
            DB::table('md_pengguna')
                ->where('id_pgn', $id)
                ->update([
                    'status_pgn' => 0,
                    'updated_at' => Carbon::now()
                ]);

            return redirect()->route('pengguna.index')
                ->with('success', 'Pengguna berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Get all pengguna data for API or AJAX
     */
    public function getData()
    {
        $pengguna = DB::table('md_pengguna')
            ->leftJoin('md_jabatan', 'md_pengguna.id_jbt', '=', 'md_jabatan.id_jbt')
            ->select('md_pengguna.*', 'md_jabatan.nama_jbt')
            ->where('md_pengguna.status_pgn', 1)
            ->orderBy('md_pengguna.id_pgn', 'desc')
            ->get();

        return response()->json($pengguna);
    }

    /**
     * Restore pengguna (Set status back to 1)
     */
    public function restore($id)
    {
        try {
            $pengguna = DB::table('md_pengguna')
                ->where('id_pgn', $id)
                ->where('status_pgn', 0)
                ->first();

            if (!$pengguna) {
                return redirect()->route('pengguna.trash')
                    ->with('error', 'Data pengguna tidak ditemukan');
            }

            DB::table('md_pengguna')
                ->where('id_pgn', $id)
                ->update([
                    'status_pgn' => 1,
                    'updated_at' => Carbon::now()
                ]);

            return redirect()->route('pengguna.trash')
                ->with('success', 'Pengguna berhasil dipulihkan');
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
        $pengguna = DB::table('md_pengguna')
            ->leftJoin('md_jabatan', 'md_pengguna.id_jbt', '=', 'md_jabatan.id_jbt')
            ->select('md_pengguna.*', 'md_jabatan.nama_jbt')
            ->where('md_pengguna.status_pgn', 0)
            ->orderBy('md_pengguna.updated_at', 'desc')
            ->paginate(10);

        return view('pengguna.trash', compact('pengguna'));
    }

    /**
     * Permanent delete pengguna
     */
    public function forceDelete($id)
    {
        try {
            // Validasi ID
            if (!is_numeric($id)) {
                return redirect()->route('pengguna.trash')
                    ->with('error', 'ID pengguna tidak valid');
            }

            $pengguna = DB::table('md_pengguna')
                ->where('id_pgn', $id)
                ->where('status_pgn', 0)
                ->first();

            if (!$pengguna) {
                return redirect()->route('pengguna.trash')
                    ->with('error', 'Data pengguna tidak ditemukan');
            }

            DB::table('md_pengguna')
                ->where('id_pgn', $id)
                ->delete();

            return redirect()->route('pengguna.trash')
                ->with('success', 'Pengguna berhasil dihapus permanen');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    // ===== REST API METHODS =====

    /**
     * API: Get all pengguna data
     */
    public function apiIndex(Request $request)
    {
        try {
            $query = DB::table('md_pengguna')
                ->leftJoin('md_jabatan', 'md_pengguna.id_jbt', '=', 'md_jabatan.id_jbt')
                ->select('md_pengguna.*', 'md_jabatan.nama_jbt')
                ->where('md_pengguna.status_pgn', 1)
                ->orderBy('md_pengguna.id_pgn', 'desc');

            // Search functionality
            if ($request->has('search') && !empty($request->search)) {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->where('md_pengguna.nama_pgn', 'ILIKE', "%{$search}%")
                      ->orWhere('md_pengguna.email_pgn', 'ILIKE', "%{$search}%");
                });
            }

            $pengguna = $query->get();

            // Hide password from response
            $pengguna = $pengguna->map(function ($item) {
                unset($item->katasandi_pgn);
                return $item;
            });

            return response()->json([
                'success' => true,
                'message' => 'Data pengguna berhasil diambil',
                'data' => $pengguna
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
     * API: Get pengguna by ID
     */
    public function apiShow($id)
    {
        try {
            $pengguna = DB::table('md_pengguna')
                ->leftJoin('md_jabatan', 'md_pengguna.id_jbt', '=', 'md_jabatan.id_jbt')
                ->select('md_pengguna.*', 'md_jabatan.nama_jbt')
                ->where('md_pengguna.id_pgn', $id)
                ->where('md_pengguna.status_pgn', 1)
                ->first();

            if (!$pengguna) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data pengguna tidak ditemukan',
                    'data' => null
                ], 404);
            }

            // Hide password from response
            unset($pengguna->katasandi_pgn);

            return response()->json([
                'success' => true,
                'message' => 'Data pengguna berhasil diambil',
                'data' => $pengguna
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
     * API: Store new pengguna
     */
    public function apiStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_jbt' => 'required|integer|exists:md_jabatan,id_jbt',
            'nama_pgn' => 'required|string|max:100',
            'email_pgn' => 'required|email|max:100|unique:md_pengguna,email_pgn',
            'katasandi_pgn' => 'required|string|min:6|max:100'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            DB::table('md_pengguna')->insert([
                'id_jbt' => $request->id_jbt,
                'nama_pgn' => $request->nama_pgn,
                'email_pgn' => $request->email_pgn,
                'katasandi_pgn' => Hash::make($request->katasandi_pgn),
                'status_pgn' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);

            // Get the last inserted record
            $pengguna = DB::table('md_pengguna')
                ->leftJoin('md_jabatan', 'md_pengguna.id_jbt', '=', 'md_jabatan.id_jbt')
                ->select('md_pengguna.*', 'md_jabatan.nama_jbt')
                ->where('md_pengguna.status_pgn', 1)
                ->orderBy('md_pengguna.id_pgn', 'desc')
                ->first();

            // Hide password from response
            unset($pengguna->katasandi_pgn);

            return response()->json([
                'success' => true,
                'message' => 'Pengguna berhasil ditambahkan',
                'data' => $pengguna
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
     * API: Update pengguna
     */
    public function apiUpdate(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'id_jbt' => 'required|integer|exists:md_jabatan,id_jbt',
            'nama_pgn' => 'required|string|max:100',
            'email_pgn' => 'required|email|max:100|unique:md_pengguna,email_pgn,' . $id . ',id_pgn',
            'katasandi_pgn' => 'nullable|string|min:6|max:100'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $pengguna = DB::table('md_pengguna')
                ->where('id_pgn', $id)
                ->where('status_pgn', 1)
                ->first();

            if (!$pengguna) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data pengguna tidak ditemukan',
                    'data' => null
                ], 404);
            }

            $updateData = [
                'id_jbt' => $request->id_jbt,
                'nama_pgn' => $request->nama_pgn,
                'email_pgn' => $request->email_pgn,
                'updated_at' => Carbon::now()
            ];

            // Only update password if provided
            if (!empty($request->katasandi_pgn)) {
                $updateData['katasandi_pgn'] = Hash::make($request->katasandi_pgn);
            }

            DB::table('md_pengguna')
                ->where('id_pgn', $id)
                ->update($updateData);

            $updatedPengguna = DB::table('md_pengguna')
                ->leftJoin('md_jabatan', 'md_pengguna.id_jbt', '=', 'md_jabatan.id_jbt')
                ->select('md_pengguna.*', 'md_jabatan.nama_jbt')
                ->where('md_pengguna.id_pgn', $id)
                ->first();

            // Hide password from response
            unset($updatedPengguna->katasandi_pgn);

            return response()->json([
                'success' => true,
                'message' => 'Pengguna berhasil diperbarui',
                'data' => $updatedPengguna
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
     * API: Delete pengguna (set status to 0)
     */
    public function apiDestroy($id)
    {
        try {
            $pengguna = DB::table('md_pengguna')
                ->where('id_pgn', $id)
                ->where('status_pgn', 1)
                ->first();

            if (!$pengguna) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data pengguna tidak ditemukan',
                    'data' => null
                ], 404);
            }

            // Set status menjadi 0
            DB::table('md_pengguna')
                ->where('id_pgn', $id)
                ->update([
                    'status_pgn' => 0,
                    'updated_at' => Carbon::now()
                ]);

            return response()->json([
                'success' => true,
                'message' => 'Pengguna berhasil dihapus',
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
            $pengguna = DB::table('md_pengguna')
                ->leftJoin('md_jabatan', 'md_pengguna.id_jbt', '=', 'md_jabatan.id_jbt')
                ->select('md_pengguna.*', 'md_jabatan.nama_jbt')
                ->where('md_pengguna.status_pgn', 0)
                ->orderBy('md_pengguna.updated_at', 'desc')
                ->get();

            // Hide password from response
            $pengguna = $pengguna->map(function ($item) {
                unset($item->katasandi_pgn);
                return $item;
            });

            return response()->json([
                'success' => true,
                'message' => 'Data trash berhasil diambil',
                'data' => $pengguna
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
     * API: Restore pengguna (set status back to 1)
     */
    public function apiRestore($id)
    {
        try {
            $pengguna = DB::table('md_pengguna')
                ->where('id_pgn', $id)
                ->where('status_pgn', 0)
                ->first();

            if (!$pengguna) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data pengguna tidak ditemukan',
                    'data' => null
                ], 404);
            }

            DB::table('md_pengguna')
                ->where('id_pgn', $id)
                ->update([
                    'status_pgn' => 1,
                    'updated_at' => Carbon::now()
                ]);

            $restoredPengguna = DB::table('md_pengguna')
                ->leftJoin('md_jabatan', 'md_pengguna.id_jbt', '=', 'md_jabatan.id_jbt')
                ->select('md_pengguna.*', 'md_jabatan.nama_jbt')
                ->where('md_pengguna.id_pgn', $id)
                ->first();

            // Hide password from response
            unset($restoredPengguna->katasandi_pgn);

            return response()->json([
                'success' => true,
                'message' => 'Pengguna berhasil dipulihkan',
                'data' => $restoredPengguna
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