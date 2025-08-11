<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class KodeposController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = DB::table('md_kodepos')
            ->select('md_kodepos.*', 'md_provinsi.namadagri_prv', 'md_kabkota.namadagri_kbk')
            ->leftJoin('md_provinsi', 'md_kodepos.kodedagri_prv', '=', 'md_provinsi.kodedagri_prv')
            ->leftJoin('md_kabkota', 'md_kodepos.kodedagri_kbk', '=', 'md_kabkota.kodedagri_kbk')
            ->where('md_kodepos.status_kdp', 1) // Hanya tampilkan data dengan status aktif
            ->orderBy('md_kodepos.id_kdp', 'desc');

        // Search functionality
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('md_kodepos.kodepos_kdp', 'ILIKE', "%{$search}%")
                ->orWhere('md_kodepos.kel_kdp', 'ILIKE', "%{$search}%")
                ->orWhere('md_kodepos.kec_kdp', 'ILIKE', "%{$search}%")
                ->orWhere('md_provinsi.namadagri_prv', 'ILIKE', "%{$search}%")
                ->orWhere('md_kabkota.namadagri_kbk', 'ILIKE', "%{$search}%");
            });
        }

        // Filter by province
        if ($request->has('provinsi') && !empty($request->provinsi)) {
            $query->where('md_kodepos.kodedagri_prv', $request->provinsi);
        }

        // Filter by kabkota
        if ($request->has('kabkota') && !empty($request->kabkota)) {
            $query->where('md_kodepos.kodedagri_kbk', $request->kabkota);
        }

        $kodepos = $query->paginate(10);

        // Get provinces for filter dropdown
        $provinsi = DB::table('md_provinsi')
            ->select('kodedagri_prv', 'namadagri_prv')
            ->where('status_prv', 1)
            ->orderBy('namadagri_prv', 'asc')
            ->get();

        // Get kabkota for filter dropdown
        $kabkota = DB::table('md_kabkota')
            ->select('kodedagri_kbk', 'namadagri_kbk')
            ->where('status_kbk', 1)
            ->orderBy('namadagri_kbk', 'asc')
            ->get();

        return view('kodepos.index', compact('kodepos', 'provinsi', 'kabkota'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Get provinces for dropdown
        $provinsi = DB::table('md_provinsi')
            ->select('kodedagri_prv', 'namadagri_prv')
            ->where('status_prv', 1)
            ->orderBy('namadagri_prv', 'asc')
            ->get();

        // Get kabkota for dropdown
        $kabkota = DB::table('md_kabkota')
            ->select('kodedagri_kbk', 'namadagri_kbk', 'kodedagri_prv')
            ->where('status_kbk', 1)
            ->orderBy('namadagri_kbk', 'asc')
            ->get();

        return view('kodepos.create', compact('provinsi', 'kabkota'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'kodepos_kdp' => 'required|string|max:10',
            'kel_kdp' => 'required|string|max:100',
            'kec_kdp' => 'required|string|max:100',
            'kodedagri_prv' => 'required|integer|exists:md_provinsi,kodedagri_prv',
            'kodedagri_kbk' => 'required|integer|exists:md_kabkota,kodedagri_kbk',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            DB::table('md_kodepos')->insert([
                'kodepos_kdp' => $request->kodepos_kdp,
                'kel_kdp' => $request->kel_kdp,
                'kec_kdp' => $request->kec_kdp,
                'kodedagri_prv' => $request->kodedagri_prv,
                'kodedagri_kbk' => $request->kodedagri_kbk,
                'status_kdp' => 1, // Status aktif saat dibuat
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);

            return redirect()->route('kodepos.index')
                ->with('success', 'Data kode pos berhasil ditambahkan');
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
        $kodepos = DB::table('md_kodepos')
            ->select('md_kodepos.*', 'md_provinsi.namadagri_prv', 'md_kabkota.namadagri_kbk')
            ->leftJoin('md_provinsi', 'md_kodepos.kodedagri_prv', '=', 'md_provinsi.kodedagri_prv')
            ->leftJoin('md_kabkota', 'md_kodepos.kodedagri_kbk', '=', 'md_kabkota.kodedagri_kbk')
            ->where('md_kodepos.id_kdp', $id)
            ->where('md_kodepos.status_kdp', 1)
            ->first();

        if (!$kodepos) {
            return redirect()->route('kodepos.index')
                ->with('error', 'Data kode pos tidak ditemukan');
        }

        return view('kodepos.show', compact('kodepos'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $kodepos = DB::table('md_kodepos')
            ->where('id_kdp', $id)
            ->where('status_kdp', 1)
            ->first();

        if (!$kodepos) {
            return redirect()->route('kodepos.index')
                ->with('error', 'Data kode pos tidak ditemukan');
        }

        // Get provinces for dropdown
        $provinsi = DB::table('md_provinsi')
            ->select('kodedagri_prv', 'namadagri_prv')
            ->where('status_prv', 1)
            ->orderBy('namadagri_prv', 'asc')
            ->get();

        // Get kabkota for dropdown
        $kabkota = DB::table('md_kabkota')
            ->select('kodedagri_kbk', 'namadagri_kbk', 'kodedagri_prv')
            ->where('status_kbk', 1)
            ->orderBy('namadagri_kbk', 'asc')
            ->get();

        return view('kodepos.edit', compact('kodepos', 'provinsi', 'kabkota'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'kodepos_kdp' => 'required|string|max:10',
            'kel_kdp' => 'required|string|max:100',
            'kec_kdp' => 'required|string|max:100',
            'kodedagri_prv' => 'required|integer|exists:md_provinsi,kodedagri_prv',
            'kodedagri_kbk' => 'required|integer|exists:md_kabkota,kodedagri_kbk',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $kodepos = DB::table('md_kodepos')
                ->where('id_kdp', $id)
                ->where('status_kdp', 1)
                ->first();

            if (!$kodepos) {
                return redirect()->route('kodepos.index')
                    ->with('error', 'Data kode pos tidak ditemukan');
            }

            DB::table('md_kodepos')
                ->where('id_kdp', $id)
                ->update([
                    'kodepos_kdp' => $request->kodepos_kdp,
                    'kel_kdp' => $request->kel_kdp,
                    'kec_kdp' => $request->kec_kdp,
                    'kodedagri_prv' => $request->kodedagri_prv,
                    'kodedagri_kbk' => $request->kodedagri_kbk,
                    'updated_at' => Carbon::now()
                ]);

            return redirect()->route('kodepos.index')
                ->with('success', 'Data kode pos berhasil diperbarui');
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
            $kodepos = DB::table('md_kodepos')
                ->where('id_kdp', $id)
                ->where('status_kdp', 1)
                ->first();

            if (!$kodepos) {
                return redirect()->route('kodepos.index')
                    ->with('error', 'Data kode pos tidak ditemukan');
            }

            // Set status menjadi 0 (tidak aktif/dihapus)
            DB::table('md_kodepos')
                ->where('id_kdp', $id)
                ->update([
                    'status_kdp' => 0,
                    'updated_at' => Carbon::now()
                ]);

            return redirect()->route('kodepos.index')
                ->with('success', 'Data kode pos berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Get all kodepos data for API or AJAX
     */
    public function getData(Request $request)
    {
        $query = DB::table('md_kodepos')
            ->select('md_kodepos.*', 'md_provinsi.namadagri_prv', 'md_kabkota.namadagri_kbk')
            ->leftJoin('md_provinsi', 'md_kodepos.kodedagri_prv', '=', 'md_provinsi.kodedagri_prv')
            ->leftJoin('md_kabkota', 'md_kodepos.kodedagri_kbk', '=', 'md_kabkota.kodedagri_kbk')
            ->where('md_kodepos.status_kdp', 1)
            ->orderBy('md_kodepos.id_kdp', 'desc');

        // Filter by province if provided
        if ($request->has('provinsi') && !empty($request->provinsi)) {
            $query->where('md_kodepos.kodedagri_prv', $request->provinsi);
        }

        // Filter by kabkota if provided
        if ($request->has('kabkota') && !empty($request->kabkota)) {
            $query->where('md_kodepos.kodedagri_kbk', $request->kabkota);
        }

        $kodepos = $query->get();

        return response()->json($kodepos);
    }

    /**
     * Get kodepos by province ID
     */
    public function getByProvinsi($provinsiId)
    {
        $kodepos = DB::table('md_kodepos')
            ->select('*')
            ->where('kodedagri_prv', $provinsiId)
            ->where('status_kdp', 1)
            ->orderBy('kel_kdp', 'asc')
            ->get();

        return response()->json($kodepos);
    }

    /**
     * Get kodepos by kabkota ID
     */
    public function getByKabkota($kabkotaId)
    {
        $kodepos = DB::table('md_kodepos')
            ->select('*')
            ->where('kodedagri_kbk', $kabkotaId)
            ->where('status_kdp', 1)
            ->orderBy('kel_kdp', 'asc')
            ->get();

        return response()->json($kodepos);
    }

    /**
     * Restore kodepos (Set status back to 1)
     */
    public function restore($id)
    {
        try {
            $kodepos = DB::table('md_kodepos')
                ->where('id_kdp', $id)
                ->where('status_kdp', 0)
                ->first();

            if (!$kodepos) {
                return redirect()->route('kodepos.trash')
                    ->with('error', 'Data kode pos tidak ditemukan');
            }

            DB::table('md_kodepos')
                ->where('id_kdp', $id)
                ->update([
                    'status_kdp' => 1,
                    'updated_at' => Carbon::now()
                ]);

            return redirect()->route('kodepos.trash')
                ->with('success', 'Data kode pos berhasil dipulihkan');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Show trash page (data with status 0)
     */
    public function trash(Request $request)
    {
        $query = DB::table('md_kodepos')
            ->select('md_kodepos.*', 'md_provinsi.namadagri_prv', 'md_kabkota.namadagri_kbk')
            ->leftJoin('md_provinsi', 'md_kodepos.kodedagri_prv', '=', 'md_provinsi.kodedagri_prv')
            ->leftJoin('md_kabkota', 'md_kodepos.kodedagri_kbk', '=', 'md_kabkota.kodedagri_kbk')
            ->where('md_kodepos.status_kdp', 0) // Status deleted
            ->orderBy('md_kodepos.updated_at', 'desc');

        // Search functionality
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('md_kodepos.kodepos_kdp', 'ILIKE', "%{$search}%")
                ->orWhere('md_kodepos.kel_kdp', 'ILIKE', "%{$search}%")
                ->orWhere('md_kodepos.kec_kdp', 'ILIKE', "%{$search}%")
                ->orWhere('md_provinsi.namadagri_prv', 'ILIKE', "%{$search}%")
                ->orWhere('md_kabkota.namadagri_kbk', 'ILIKE', "%{$search}%");
            });
        }

        $kodepos = $query->paginate(10);

        return view('kodepos.trash', compact('kodepos'));
    }

    /**
     * Permanent delete kodepos
     */
    public function forceDelete($id)
    {
        try {
            // Validasi ID
            if (!is_numeric($id)) {
                return redirect()->route('kodepos.trash')
                    ->with('error', 'ID kode pos tidak valid');
            }

            $kodepos = DB::table('md_kodepos')
                ->where('id_kdp', $id)
                ->where('status_kdp', 0)
                ->first();

            if (!$kodepos) {
                return redirect()->route('kodepos.trash')
                    ->with('error', 'Data kode pos tidak ditemukan');
            }

            DB::table('md_kodepos')
                ->where('id_kdp', $id)
                ->delete();

            return redirect()->route('kodepos.trash')
                ->with('success', 'Data kode pos berhasil dihapus permanen');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    // ===== PANIC BUTTON FUNCTIONALITY =====

   
    // ===== REST API METHODS =====

    /**
     * API: Get all kodepos data
     */
    public function apiIndex(Request $request)
    {
        try {
            $query = DB::table('md_kodepos')
                ->select('md_kodepos.*', 'md_provinsi.namadagri_prv', 'md_kabkota.namadagri_kbk')
                ->leftJoin('md_provinsi', 'md_kodepos.kodedagri_prv', '=', 'md_provinsi.kodedagri_prv')
                ->leftJoin('md_kabkota', 'md_kodepos.kodedagri_kbk', '=', 'md_kabkota.kodedagri_kbk')
                ->where('md_kodepos.status_kdp', 1)
                ->orderBy('md_kodepos.id_kdp', 'desc');

            // Search functionality
            if ($request->has('search') && !empty($request->search)) {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->where('md_kodepos.kodepos_kdp', 'ILIKE', "%{$search}%")
                    ->orWhere('md_kodepos.kel_kdp', 'ILIKE', "%{$search}%")
                    ->orWhere('md_kodepos.kec_kdp', 'ILIKE', "%{$search}%")
                    ->orWhere('md_provinsi.namadagri_prv', 'ILIKE', "%{$search}%")
                    ->orWhere('md_kabkota.namadagri_kbk', 'ILIKE', "%{$search}%");
                });
            }

            // Filter by province
            if ($request->has('provinsi') && !empty($request->provinsi)) {
                $query->where('md_kodepos.kodedagri_prv', $request->provinsi);
            }

            // Filter by kabkota
            if ($request->has('kabkota') && !empty($request->kabkota)) {
                $query->where('md_kodepos.kodedagri_kbk', $request->kabkota);
            }

            $perPage = $request->get('per_page', 15);
            $kodepos = $query->paginate($perPage);

            return response()->json([
                'success' => true,
                'message' => 'Data kode pos berhasil diambil',
                'data' => $kodepos
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
     * API: Get kodepos by ID
     */
    public function apiShow($id)
    {
        try {
            $kodepos = DB::table('md_kodepos')
                ->select('md_kodepos.*', 'md_provinsi.namadagri_prv', 'md_kabkota.namadagri_kbk')
                ->leftJoin('md_provinsi', 'md_kodepos.kodedagri_prv', '=', 'md_provinsi.kodedagri_prv')
                ->leftJoin('md_kabkota', 'md_kodepos.kodedagri_kbk', '=', 'md_kabkota.kodedagri_kbk')
                ->where('md_kodepos.id_kdp', $id)
                ->where('md_kodepos.status_kdp', 1)
                ->first();

            if (!$kodepos) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data kode pos tidak ditemukan',
                    'data' => null
                ], 404);
            }

            return response()->json([
                'success' => true,
                'message' => 'Data kode pos berhasil diambil',
                'data' => $kodepos
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
     * API: Store new kodepos
     */
    public function apiStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'kodepos_kdp' => 'required|string|max:10',
            'kel_kdp' => 'required|string|max:100',
            'kec_kdp' => 'required|string|max:100',
            'kodedagri_prv' => 'required|integer|exists:md_provinsi,kodedagri_prv',
            'kodedagri_kbk' => 'required|integer|exists:md_kabkota,kodedagri_kbk',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $id = DB::table('md_kodepos')->insertGetId([
                'kodepos_kdp' => $request->kodepos_kdp,
                'kel_kdp' => $request->kel_kdp,
                'kec_kdp' => $request->kec_kdp,
                'kodedagri_prv' => $request->kodedagri_prv,
                'kodedagri_kbk' => $request->kodedagri_kbk,
                'status_kdp' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);

            // Get the inserted record with relations
            $kodepos = DB::table('md_kodepos')
                ->select('md_kodepos.*', 'md_provinsi.namadagri_prv', 'md_kabkota.namadagri_kbk')
                ->leftJoin('md_provinsi', 'md_kodepos.kodedagri_prv', '=', 'md_provinsi.kodedagri_prv')
                ->leftJoin('md_kabkota', 'md_kodepos.kodedagri_kbk', '=', 'md_kabkota.kodedagri_kbk')
                ->where('md_kodepos.id_kdp', $id)
                ->first();

            return response()->json([
                'success' => true,
                'message' => 'Data kode pos berhasil ditambahkan',
                'data' => $kodepos
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
     * API: Update kodepos
     */
    public function apiUpdate(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'kodepos_kdp' => 'required|string|max:10',
            'kel_kdp' => 'required|string|max:100',
            'kec_kdp' => 'required|string|max:100',
            'kodedagri_prv' => 'required|integer|exists:md_provinsi,kodedagri_prv',
            'kodedagri_kbk' => 'required|integer|exists:md_kabkota,kodedagri_kbk',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $kodepos = DB::table('md_kodepos')
                ->where('id_kdp', $id)
                ->where('status_kdp', 1)
                ->first();

            if (!$kodepos) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data kode pos tidak ditemukan',
                    'data' => null
                ], 404);
            }

            DB::table('md_kodepos')
                ->where('id_kdp', $id)
                ->update([
                    'kodepos_kdp' => $request->kodepos_kdp,
                    'kel_kdp' => $request->kel_kdp,
                    'kec_kdp' => $request->kec_kdp,
                    'kodedagri_prv' => $request->kodedagri_prv,
                    'kodedagri_kbk' => $request->kodedagri_kbk,
                    'updated_at' => Carbon::now()
                ]);

            $updatedKodepos = DB::table('md_kodepos')
                ->select('md_kodepos.*', 'md_provinsi.namadagri_prv', 'md_kabkota.namadagri_kbk')
                ->leftJoin('md_provinsi', 'md_kodepos.kodedagri_prv', '=', 'md_provinsi.kodedagri_prv')
                ->leftJoin('md_kabkota', 'md_kodepos.kodedagri_kbk', '=', 'md_kabkota.kodedagri_kbk')
                ->where('md_kodepos.id_kdp', $id)
                ->first();

            return response()->json([
                'success' => true,
                'message' => 'Data kode pos berhasil diperbarui',
                'data' => $updatedKodepos
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
     * API: Delete kodepos (set status to 0)
     */
    public function apiDestroy($id)
    {
        try {
            $kodepos = DB::table('md_kodepos')
                ->where('id_kdp', $id)
                ->where('status_kdp', 1)
                ->first();

            if (!$kodepos) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data kode pos tidak ditemukan',
                    'data' => null
                ], 404);
            }

            // Set status menjadi 0
            DB::table('md_kodepos')
                ->where('id_kdp', $id)
                ->update([
                    'status_kdp' => 0,
                    'updated_at' => Carbon::now()
                ]);

            return response()->json([
                'success' => true,
                'message' => 'Data kode pos berhasil dihapus',
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
            $kodepos = DB::table('md_kodepos')
                ->select('md_kodepos.*', 'md_provinsi.namadagri_prv', 'md_kabkota.namadagri_kbk')
                ->leftJoin('md_provinsi', 'md_kodepos.kodedagri_prv', '=', 'md_provinsi.kodedagri_prv')
                ->leftJoin('md_kabkota', 'md_kodepos.kodedagri_kbk', '=', 'md_kabkota.kodedagri_kbk')
                ->where('md_kodepos.status_kdp', 0)
                ->orderBy('md_kodepos.updated_at', 'desc')
                ->get();

            return response()->json([
                'success' => true,
                'message' => 'Data trash berhasil diambil',
                'data' => $kodepos
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
     * API: Restore kodepos (set status back to 1)
     */
    public function apiRestore($id)
    {
        try {
            $kodepos = DB::table('md_kodepos')
                ->where('id_kdp', $id)
                ->where('status_kdp', 0)
                ->first();

            if (!$kodepos) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data kode pos tidak ditemukan',
                    'data' => null
                ], 404);
            }

            DB::table('md_kodepos')
                ->where('id_kdp', $id)
                ->update([
                    'status_kdp' => 1,
                    'updated_at' => Carbon::now()
                ]);

            $restoredKodepos = DB::table('md_kodepos')
                ->select('md_kodepos.*', 'md_provinsi.namadagri_prv', 'md_kabkota.namadagri_kbk')
                ->leftJoin('md_provinsi', 'md_kodepos.kodedagri_prv', '=', 'md_provinsi.kodedagri_prv')
                ->leftJoin('md_kabkota', 'md_kodepos.kodedagri_kbk', '=', 'md_kabkota.kodedagri_kbk')
                ->where('md_kodepos.id_kdp', $id)
                ->first();

            return response()->json([
                'success' => true,
                'message' => 'Data kode pos berhasil dipulihkan',
                'data' => $restoredKodepos
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
     * API: Get kodepos by province ID
     */
    public function apiGetByProvinsi($provinsiId)
    {
        try {
            $kodepos = DB::table('md_kodepos')
                ->select('*')
                ->where('kodedagri_prv', $provinsiId)
                ->where('status_kdp', 1)
                ->orderBy('kel_kdp', 'asc')
                ->get();

            return response()->json([
                'success' => true,
                'message' => 'Data kode pos berhasil diambil',
                'data' => $kodepos
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
     * API: Get kodepos by kabkota ID
     */
    public function apiGetByKabkota($kabkotaId)
    {
        try {
            $kodepos = DB::table('md_kodepos')
                ->select('*')
                ->where('kodedagri_kbk', $kabkotaId)
                ->where('status_kdp', 1)
                ->orderBy('kel_kdp', 'asc')
                ->get();

            return response()->json([
                'success' => true,
                'message' => 'Data kode pos berhasil diambil',
                'data' => $kodepos
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