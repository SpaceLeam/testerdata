<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class ProvinsiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = DB::table('md_provinsi')
            ->select('*')
            ->where('status_prv', 1) // Hanya tampilkan data dengan status aktif
            ->orderBy('kodedagri_prv', 'desc');

        // Search functionality
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('namadagri_prv', 'ILIKE', "%{$search}%")
                  ->orWhere('namabps_prv', 'ILIKE', "%{$search}%")
                  ->orWhere('kodedagri_prv', 'ILIKE', "%{$search}%");
            });
        }

        $provinsi = $query->paginate(10);

        return view('provinsi.index', compact('provinsi'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('provinsi.create');
    }
    
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'kodedagri_prv' => 'required|integer|unique:md_provinsi,kodedagri_prv',
            'namadagri_prv' => 'required|string|max:100',
            'kodebps_prv' => 'required|integer',
            'namabps_prv' => 'required|string|max:100',
            'idgeojson_prv' => 'nullable|string|max:100',
            'kodegeojson_prv' => 'nullable|integer'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            DB::table('md_provinsi')->insert([
                'kodedagri_prv' => $request->kodedagri_prv,
                'namadagri_prv' => $request->namadagri_prv,
                'kodebps_prv' => $request->kodebps_prv,
                'namabps_prv' => $request->namabps_prv,
                'idgeojson_prv' => $request->idgeojson_prv,
                'kodegeojson_prv' => $request->kodegeojson_prv,
                'status_prv' => 1, // Status aktif saat dibuat
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);

            return redirect()->route('provinsi.index')
                ->with('success', 'Provinsi berhasil ditambahkan');
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
        $provinsi = DB::table('md_provinsi')
            ->where('kodedagri_prv', $id)
            ->where('status_prv', 1)
            ->first();

        if (!$provinsi) {
            return redirect()->route('provinsi.index')
                ->with('error', 'Data provinsi tidak ditemukan');
        }

        return view('provinsi.show', compact('provinsi'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $provinsi = DB::table('md_provinsi')
            ->where('kodedagri_prv', $id)
            ->where('status_prv', 1)
            ->first();

        if (!$provinsi) {
            return redirect()->route('provinsi.index')
                ->with('error', 'Data provinsi tidak ditemukan');
        }

        return view('provinsi.edit', compact('provinsi'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'kodedagri_prv' => 'required|integer|unique:md_provinsi,kodedagri_prv,' . $id . ',kodedagri_prv',
            'namadagri_prv' => 'required|string|max:100',
            'kodebps_prv' => 'required|integer',
            'namabps_prv' => 'required|string|max:100',
            'idgeojson_prv' => 'nullable|string|max:100',
            'kodegeojson_prv' => 'nullable|integer'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $provinsi = DB::table('md_provinsi')
                ->where('kodedagri_prv', $id)
                ->where('status_prv', 1)
                ->first();

            if (!$provinsi) {
                return redirect()->route('provinsi.index')
                    ->with('error', 'Data provinsi tidak ditemukan');
            }

            DB::table('md_provinsi')
                ->where('kodedagri_prv', $id)
                ->update([
                    'kodedagri_prv' => $request->kodedagri_prv,
                    'namadagri_prv' => $request->namadagri_prv,
                    'kodebps_prv' => $request->kodebps_prv,
                    'namabps_prv' => $request->namabps_prv,
                    'idgeojson_prv' => $request->idgeojson_prv,
                    'kodegeojson_prv' => $request->kodegeojson_prv,
                    // 'tanggalubah_prv' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]);

            return redirect()->route('provinsi.index')
                ->with('success', 'Provinsi berhasil diperbarui');
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
            $provinsi = DB::table('md_provinsi')
                ->where('kodedagri_prv', $id)
                ->where('status_prv', 1)
                ->first();

            if (!$provinsi) {
                return redirect()->route('provinsi.index')
                    ->with('error', 'Data provinsi tidak ditemukan');
            }

            // Set status menjadi 0 (tidak aktif/dihapus)
            DB::table('md_provinsi')
                ->where('kodedagri_prv', $id)
                ->update([
                    'status_prv' => 0,
                    // 'tanggalubah_prv' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]);

            return redirect()->route('provinsi.index')
                ->with('success', 'Provinsi berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Get all provinsi data for API or AJAX
     */
    public function getData()
    {
        $provinsi = DB::table('md_provinsi')
            ->select('*')
            ->where('status_prv', 1)
            ->orderBy('kodedagri_prv', 'desc')
            ->get();

        return response()->json($provinsi);
    }

    /**
     * Restore provinsi (Set status back to 1)
     */
    public function restore($id)
    {
        try {
            $provinsi = DB::table('md_provinsi')
                ->where('kodedagri_prv', $id)
                ->where('status_prv', 0)
                ->first();

            if (!$provinsi) {
                return redirect()->route('provinsi.trash')
                    ->with('error', 'Data provinsi tidak ditemukan');
            }

            DB::table('md_provinsi')
                ->where('kodedagri_prv', $id)
                ->update([
                    'status_prv' => 1,
                    // 'tanggalubah_prv' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]);

            return redirect()->route('provinsi.trash')
                ->with('success', 'Provinsi berhasil dipulihkan');
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
        $provinsi = DB::table('md_provinsi')
            ->select('*')
            ->where('status_prv', 0)
            ->orderBy('updated_at', 'desc')
            ->paginate(10);

        return view('provinsi.trash', compact('provinsi'));
    }

    /**
     * Permanent delete provinsi
     */
    public function forceDelete($id)
    {
        try {
            // Validasi ID
            if (!is_numeric($id)) {
                return redirect()->route('provinsi.trash')
                    ->with('error', 'ID provinsi tidak valid');
            }

            $provinsi = DB::table('md_provinsi')
                ->where('kodedagri_prv', $id)
                ->where('status_prv', 0)
                ->first();

            if (!$provinsi) {
                return redirect()->route('provinsi.trash')
                    ->with('error', 'Data provinsi tidak ditemukan');
            }

            DB::table('md_provinsi')
                ->where('kodedagri_prv', $id)
                ->delete();

            return redirect()->route('provinsi.trash')
                ->with('success', 'Provinsi berhasil dihapus permanen');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    // ===== REST API METHODS =====

    /**
     * API: Get all provinsi data
     */
    public function apiIndex(Request $request)
    {
        try {
            $query = DB::table('md_provinsi')
                ->select('*')
                ->where('status_prv', 1)
                ->orderBy('kodedagri_prv', 'desc');

            // Search functionality
            if ($request->has('search') && !empty($request->search)) {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->where('namadagri_prv', 'ILIKE', "%{$search}%")
                      ->orWhere('namabps_prv', 'ILIKE', "%{$search}%")
                      ->orWhere('kodedagri_prv', 'ILIKE', "%{$search}%");
                });
            }

            $provinsi = $query->get();

            return response()->json([
                'success' => true,
                'message' => 'Data provinsi berhasil diambil',
                'data' => $provinsi
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
     * API: Get provinsi by ID
     */
    public function apiShow($id)
    {
        try {
            $provinsi = DB::table('md_provinsi')
                ->where('kodedagri_prv', $id)
                ->where('status_prv', 1)
                ->first();

            if (!$provinsi) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data provinsi tidak ditemukan',
                    'data' => null
                ], 404);
            }

            return response()->json([
                'success' => true,
                'message' => 'Data provinsi berhasil diambil',
                'data' => $provinsi
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
     * API: Store new provinsi
     */
    public function apiStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'kodedagri_prv' => 'required|integer|unique:md_provinsi,kodedagri_prv',
            'namadagri_prv' => 'required|string|max:100',
            'kodebps_prv' => 'required|integer',
            'namabps_prv' => 'required|string|max:100',
            'idgeojson_prv' => 'nullable|string|max:100',
            'kodegeojson_prv' => 'nullable|integer'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            DB::table('md_provinsi')->insert([
                'kodedagri_prv' => $request->kodedagri_prv,
                'namadagri_prv' => $request->namadagri_prv,
                'kodebps_prv' => $request->kodebps_prv,
                'namabps_prv' => $request->namabps_prv,
                'idgeojson_prv' => $request->idgeojson_prv,
                'kodegeojson_prv' => $request->kodegeojson_prv,
                'status_prv' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);

            // Get the last inserted record
            $provinsi = DB::table('md_provinsi')
                ->where('kodedagri_prv', $request->kodedagri_prv)
                ->where('status_prv', 1)
                ->first();

            return response()->json([
                'success' => true,
                'message' => 'Provinsi berhasil ditambahkan',
                'data' => $provinsi
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
     * API: Update provinsi
     */
    public function apiUpdate(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'kodedagri_prv' => 'required|integer|unique:md_provinsi,kodedagri_prv,' . $id . ',kodedagri_prv',
            'namadagri_prv' => 'required|string|max:100',
            'kodebps_prv' => 'required|integer',
            'namabps_prv' => 'required|string|max:100',
            'idgeojson_prv' => 'nullable|string|max:100',
            'kodegeojson_prv' => 'nullable|integer'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $provinsi = DB::table('md_provinsi')
                ->where('kodedagri_prv', $id)
                ->where('status_prv', 1)
                ->first();

            if (!$provinsi) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data provinsi tidak ditemukan',
                    'data' => null
                ], 404);
            }

            DB::table('md_provinsi')
                ->where('kodedagri_prv', $id)
                ->update([
                    'kodedagri_prv' => $request->kodedagri_prv,
                    'namadagri_prv' => $request->namadagri_prv,
                    'kodebps_prv' => $request->kodebps_prv,
                    'namabps_prv' => $request->namabps_prv,
                    'idgeojson_prv' => $request->idgeojson_prv,
                    'kodegeojson_prv' => $request->kodegeojson_prv,
                    // 'tanggalubah_prv' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]);

            $updatedProvinsi = DB::table('md_provinsi')
                ->where('kodedagri_prv', $request->kodedagri_prv)
                ->first();

            return response()->json([
                'success' => true,
                'message' => 'Provinsi berhasil diperbarui',
                'data' => $updatedProvinsi
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
     * API: Delete provinsi (set status to 0)
     */
    public function apiDestroy($id)
    {
        try {
            $provinsi = DB::table('md_provinsi')
                ->where('kodedagri_prv', $id)
                ->where('status_prv', 1)
                ->first();

            if (!$provinsi) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data provinsi tidak ditemukan',
                    'data' => null
                ], 404);
            }

            // Set status menjadi 0
            DB::table('md_provinsi')
                ->where('kodedagri_prv', $id)
                ->update([
                    'status_prv' => 0,
                    // 'tanggalubah_prv' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]);

            return response()->json([
                'success' => true,
                'message' => 'Provinsi berhasil dihapus',
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
            $provinsi = DB::table('md_provinsi')
                ->select('*')
                ->where('status_prv', 0)
                ->orderBy('updated_at', 'desc')
                ->get();

            return response()->json([
                'success' => true,
                'message' => 'Data trash berhasil diambil',
                'data' => $provinsi
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
     * API: Restore provinsi (set status back to 1)
     */
    public function apiRestore($id)
    {
        try {
            $provinsi = DB::table('md_provinsi')
                ->where('kodedagri_prv', $id)
                ->where('status_prv', 0)
                ->first();

            if (!$provinsi) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data provinsi tidak ditemukan',
                    'data' => null
                ], 404);
            }

            DB::table('md_provinsi')
                ->where('kodedagri_prv', $id)
                ->update([
                    'status_prv' => 1,
                    'tanggalubah_prv' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]);

            $restoredProvinsi = DB::table('md_provinsi')
                ->where('kodedagri_prv', $id)
                ->first();

            return response()->json([
                'success' => true,
                'message' => 'Provinsi berhasil dipulihkan',
                'data' => $restoredProvinsi
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