<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use App\Models\Psr;


class PsrController extends Controller
{   
    /**
     * Display a listing of the resource.
     */ 
    public function index(Request $request)
    {
        $query = DB::table('md_psr')
            ->select(
                'md_psr.*', 
                'md_kodepos.kodepos_kdp', 
                'md_kodepos.kel_kdp', 
                'md_kodepos.kec_kdp',
                'md_provinsi.namadagri_prv', 
                'md_kabkota.namadagri_kbk'
            )
            ->leftJoin('md_kodepos', 'md_psr.id_kdp', '=', 'md_kodepos.id_kdp')
            ->leftJoin('md_provinsi', 'md_kodepos.kodedagri_prv', '=', 'md_provinsi.kodedagri_prv')
            ->leftJoin('md_kabkota', 'md_kodepos.kodedagri_kbk', '=', 'md_kabkota.kodedagri_kbk')
            ->where('md_psr.status_psr', 1) // Hanya tampilkan data dengan status aktif
            ->orderBy('md_psr.id_psr', 'desc');

        // Search functionality
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('md_psr.cbg_psr', 'ILIKE', "%{$search}%")
                ->orWhere('md_psr.alamat_psr', 'ILIKE', "%{$search}%")
                ->orWhere('md_kodepos.kodepos_kdp', 'ILIKE', "%{$search}%")
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

        // Filter by kodepos
        if ($request->has('kodepos') && !empty($request->kodepos)) {
            $query->where('md_psr.id_kdp', $request->kodepos);
        }

        $psr = $query->paginate(10);

        // Get provinces for filter dropdown
        $provinsi = DB::table('md_provinsi')
            ->select('kodedagri_prv', 'namadagri_prv')
            ->where('status_prv', 1)
            ->orderBy('namadagri_prv', 'asc')
            ->get();

        // Get kabkota for filter dropdown
        $kabkota = DB::table('md_kabkota')
            ->select('kodedagri_kbk', 'namadagri_kbk', 'kodedagri_prv')
            ->where('status_kbk', 1)
            ->orderBy('namadagri_kbk', 'asc')
            ->get();

        // Get kodepos for filter dropdown
        $kodepos = DB::table('md_kodepos')
            ->select('id_kdp', 'kodepos_kdp', 'kel_kdp', 'kec_kdp', 'kodedagri_prv', 'kodedagri_kbk')
            ->where('status_kdp', 1)
            ->orderBy('kel_kdp', 'asc')
            ->get();

        return view('psr.index', compact('psr', 'provinsi', 'kabkota', 'kodepos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Get kodepos with related data for dropdown - simplified version
        $kodepos = DB::table('md_kodepos')
            ->select(
                'md_kodepos.id_kdp', 
                'md_kodepos.kodepos_kdp', 
                'md_kodepos.kel_kdp', 
                'md_kodepos.kec_kdp',
                'md_provinsi.namadagri_prv', 
                'md_kabkota.namadagri_kbk'
            )
            ->leftJoin('md_provinsi', 'md_kodepos.kodedagri_prv', '=', 'md_provinsi.kodedagri_prv')
            ->leftJoin('md_kabkota', 'md_kodepos.kodedagri_kbk', '=', 'md_kabkota.kodedagri_kbk')
            ->where('md_kodepos.status_kdp', 1)
            ->orderBy('md_provinsi.namadagri_prv', 'asc')
            ->orderBy('md_kabkota.namadagri_kbk', 'asc')
            ->orderBy('md_kodepos.kel_kdp', 'asc')
            ->get();

        return view('psr.create', compact('kodepos'));
    }

    /**
     * Store a newly created resource in storage.
     */

public function store(Request $request)
{
    $validator = Validator::make($request->all(), [
        'id_kdp' => 'required|integer|exists:md_kodepos,id_kdp',
        'cbg_psr' => 'required|string|max:100',
        'alamat_psr' => 'required|string',
        'longitude_psr' => 'nullable|numeric|between:-180,180',
        'latitude_psr' => 'nullable|numeric|between:-90,90'
    ]);

    if ($validator->fails()) {
        return redirect()->back()
            ->withErrors($validator)
            ->withInput();
    }

    try {
        Psr::create([
            'id_kdp' => $request->id_kdp,
            'cbg_psr' => trim($request->cbg_psr),
            'alamat_psr' => trim($request->alamat_psr),
            'longitude_psr' => $request->longitude_psr ? (float)$request->longitude_psr : null,
            'latitude_psr' => $request->latitude_psr ? (float)$request->latitude_psr : null
        ]);

        return redirect()->route('psr.index')
            ->with('success', 'Data PSR berhasil ditambahkan');
            
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
        $psr = DB::table('md_psr')
            ->select(
                'md_psr.*', 
                'md_kodepos.kodepos_kdp', 
                'md_kodepos.kel_kdp', 
                'md_kodepos.kec_kdp',
                'md_provinsi.namadagri_prv', 
                'md_kabkota.namadagri_kbk'
            )
            ->leftJoin('md_kodepos', 'md_psr.id_kdp', '=', 'md_kodepos.id_kdp')
            ->leftJoin('md_provinsi', 'md_kodepos.kodedagri_prv', '=', 'md_provinsi.kodedagri_prv')
            ->leftJoin('md_kabkota', 'md_kodepos.kodedagri_kbk', '=', 'md_kabkota.kodedagri_kbk')
            ->where('md_psr.id_psr', $id)
            ->where('md_psr.status_psr', 1)
            ->first();

        if (!$psr) {
            return redirect()->route('psr.index')
                ->with('error', 'Data PSR tidak ditemukan');
        }

        return view('psr.show', compact('psr'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $psr = DB::table('md_psr')
            ->select(
                'md_psr.*', 
                'md_kodepos.kodepos_kdp', 
                'md_kodepos.kel_kdp', 
                'md_kodepos.kec_kdp',
                'md_provinsi.namadagri_prv', 
                'md_kabkota.namadagri_kbk'
            )
            ->leftJoin('md_kodepos', 'md_psr.id_kdp', '=', 'md_kodepos.id_kdp')
            ->leftJoin('md_provinsi', 'md_kodepos.kodedagri_prv', '=', 'md_provinsi.kodedagri_prv')
            ->leftJoin('md_kabkota', 'md_kodepos.kodedagri_kbk', '=', 'md_kabkota.kodedagri_kbk')
            ->where('md_psr.id_psr', $id)
            ->where('md_psr.status_psr', 1)
            ->first();

        if (!$psr) {
            return redirect()->route('psr.index')
                ->with('error', 'Data PSR tidak ditemukan');
        }

        // Get kodepos with related data for dropdown
        $kodepos = DB::table('md_kodepos')
            ->select(
                'md_kodepos.id_kdp', 
                'md_kodepos.kodepos_kdp', 
                'md_kodepos.kel_kdp', 
                'md_kodepos.kec_kdp',
                'md_provinsi.namadagri_prv', 
                'md_kabkota.namadagri_kbk'
            )
            ->leftJoin('md_provinsi', 'md_kodepos.kodedagri_prv', '=', 'md_provinsi.kodedagri_prv')
            ->leftJoin('md_kabkota', 'md_kodepos.kodedagri_kbk', '=', 'md_kabkota.kodedagri_kbk')
            ->where('md_kodepos.status_kdp', 1)
            ->orderBy('md_provinsi.namadagri_prv', 'asc')
            ->orderBy('md_kabkota.namadagri_kbk', 'asc')
            ->orderBy('md_kodepos.kel_kdp', 'asc')
            ->get();

        return view('psr.edit', compact('psr', 'kodepos'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'id_kdp' => 'required|integer|exists:md_kodepos,id_kdp',
            'cbg_psr' => 'required|string|max:100',
            'alamat_psr' => 'required|string|max:500',
            'longitude_psr' => 'nullable|numeric|between:-180,180',
            'latitude_psr' => 'nullable|numeric|between:-90,90',
        ], [
            'id_kdp.required' => 'Kodepos harus dipilih',
            'id_kdp.exists' => 'Kodepos tidak valid',
            'cbg_psr.required' => 'Cabang PSR harus diisi',
            'cbg_psr.max' => 'Cabang PSR maksimal 100 karakter',
            'alamat_psr.required' => 'Alamat harus diisi',
            'alamat_psr.max' => 'Alamat maksimal 500 karakter',
            'longitude_psr.between' => 'Longitude harus antara -180 sampai 180',
            'latitude_psr.between' => 'Latitude harus antara -90 sampai 90',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $psr = DB::table('md_psr')
                ->where('id_psr', $id)
                ->where('status_psr', 1)
                ->first();

            if (!$psr) {
                return redirect()->route('psr.index')
                    ->with('error', 'Data PSR tidak ditemukan');
            }

            // Validasi kodepos exists dan ambil data terkait
            $kodepos = DB::table('md_kodepos')
                ->select('kodedagri_prv', 'kodedagri_kbk', 'kodepos_kdp', 'kel_kdp', 'kec_kdp')
                ->where('id_kdp', $request->id_kdp)
                ->where('status_kdp', 1)
                ->first();

            if (!$kodepos) {
                return redirect()->back()
                    ->with('error', 'Kodepos tidak ditemukan atau tidak aktif')
                    ->withInput();
            }

            // Check if PSR with same name already exists in same kodepos (exclude current PSR)
            $existingPsr = DB::table('md_psr')
                ->where('cbg_psr', $request->cbg_psr)
                ->where('id_kdp', $request->id_kdp)
                ->where('id_psr', '!=', $id)
                ->where('status_psr', 1)
                ->exists();

            if ($existingPsr) {
                return redirect()->back()
                    ->with('error', 'PSR dengan nama yang sama sudah ada di kodepos ini')
                    ->withInput();
            }

            // Update data PSR
            DB::table('md_psr')
                ->where('id_psr', $id)
                ->update([
                    'id_kdp' => $request->id_kdp,
                    'cbg_psr' => trim($request->cbg_psr),
                    'alamat_psr' => trim($request->alamat_psr),
                    'longitude_psr' => $request->longitude_psr ? (float)$request->longitude_psr : null,
                    'latitude_psr' => $request->latitude_psr ? (float)$request->latitude_psr : null,
                    'updated_at' => Carbon::now()
                ]);

            return redirect()->route('psr.index')
                ->with('success', "Data PSR '{$request->cbg_psr}' berhasil diperbarui");

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
            $psr = DB::table('md_psr')
                ->select('md_psr.cbg_psr')
                ->where('id_psr', $id)
                ->where('status_psr', 1)
                ->first();

            if (!$psr) {
                return redirect()->route('psr.index')
                    ->with('error', 'Data PSR tidak ditemukan');
            }

            // Set status menjadi 0 (tidak aktif/dihapus)
            DB::table('md_psr')
                ->where('id_psr', $id)
                ->update([
                    'status_psr' => 0,
                    'updated_at' => Carbon::now()
                ]);

            return redirect()->route('psr.index')
                ->with('success', "Data PSR '{$psr->cbg_psr}' berhasil dihapus");

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Get all PSR data for API or AJAX
     */
    public function getData(Request $request)
    {
        $query = DB::table('md_psr')
            ->select(
                'md_psr.*', 
                'md_kodepos.kodepos_kdp', 
                'md_kodepos.kel_kdp', 
                'md_kodepos.kec_kdp',
                'md_provinsi.namadagri_prv', 
                'md_kabkota.namadagri_kbk'
            )
            ->leftJoin('md_kodepos', 'md_psr.id_kdp', '=', 'md_kodepos.id_kdp')
            ->leftJoin('md_provinsi', 'md_kodepos.kodedagri_prv', '=', 'md_provinsi.kodedagri_prv')
            ->leftJoin('md_kabkota', 'md_kodepos.kodedagri_kbk', '=', 'md_kabkota.kodedagri_kbk')
            ->where('md_psr.status_psr', 1)
            ->orderBy('md_psr.id_psr', 'desc');

        // Filter by province if provided
        if ($request->has('provinsi') && !empty($request->provinsi)) {
            $query->where('md_kodepos.kodedagri_prv', $request->provinsi);
        }

        // Filter by kabkota if provided
        if ($request->has('kabkota') && !empty($request->kabkota)) {
            $query->where('md_kodepos.kodedagri_kbk', $request->kabkota);
        }

        // Filter by kodepos if provided
        if ($request->has('kodepos') && !empty($request->kodepos)) {
            $query->where('md_psr.id_kdp', $request->kodepos);
        }

        // Search functionality
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('md_psr.cbg_psr', 'ILIKE', "%{$search}%")
                ->orWhere('md_psr.alamat_psr', 'ILIKE', "%{$search}%")
                ->orWhere('md_kodepos.kodepos_kdp', 'ILIKE', "%{$search}%")
                ->orWhere('md_kodepos.kel_kdp', 'ILIKE', "%{$search}%")
                ->orWhere('md_kodepos.kec_kdp', 'ILIKE', "%{$search}%");
            });
        }

        $psr = $query->get();

        return response()->json([
            'success' => true,
            'data' => $psr,
            'total' => $psr->count()
        ]);
    }

    /**
     * Get kodepos data for AJAX dropdown
     */
    public function getKodepos(Request $request)
    {
        $query = DB::table('md_kodepos')
            ->select(
                'md_kodepos.id_kdp', 
                'md_kodepos.kodepos_kdp', 
                'md_kodepos.kel_kdp', 
                'md_kodepos.kec_kdp',
                'md_provinsi.namadagri_prv', 
                'md_kabkota.namadagri_kbk'
            )
            ->leftJoin('md_provinsi', 'md_kodepos.kodedagri_prv', '=', 'md_provinsi.kodedagri_prv')
            ->leftJoin('md_kabkota', 'md_kodepos.kodedagri_kbk', '=', 'md_kabkota.kodedagri_kbk')
            ->where('md_kodepos.status_kdp', 1);

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

        $kodepos = $query->orderBy('md_provinsi.namadagri_prv', 'asc')
                        ->orderBy('md_kabkota.namadagri_kbk', 'asc')
                        ->orderBy('md_kodepos.kel_kdp', 'asc')
                        ->get();

        return response()->json([
            'success' => true,
            'data' => $kodepos,
            'total' => $kodepos->count()
        ]);
    }

    /**
     * Bulk delete PSR data
     */
    public function bulkDelete(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ids' => 'required|array|min:1',
            'ids.*' => 'integer|exists:md_psr,id_psr'
        ], [
            'ids.required' => 'Pilih minimal satu data PSR',
            'ids.array' => 'Data tidak valid',
            'ids.min' => 'Pilih minimal satu data PSR',
            'ids.*.exists' => 'Data PSR tidak valid'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ], 422);
        }

        try {
            $deletedCount = DB::table('md_psr')
                ->whereIn('id_psr', $request->ids)
                ->where('status_psr', 1)
                ->update([
                    'status_psr' => 0,
                    'updated_at' => Carbon::now()
                ]);

            return response()->json([
                'success' => true,
                'message' => "Berhasil menghapus {$deletedCount} data PSR"
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Bulk restore PSR data
     */
    public function bulkRestore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ids' => 'required|array|min:1',
            'ids.*' => 'integer|exists:md_psr,id_psr'
        ], [
            'ids.required' => 'Pilih minimal satu data PSR',
            'ids.array' => 'Data tidak valid',
            'ids.min' => 'Pilih minimal satu data PSR',
            'ids.*.exists' => 'Data PSR tidak valid'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ], 422);
        }

        try {
            $restoredCount = DB::table('md_psr')
                ->whereIn('id_psr', $request->ids)
                ->where('status_psr', 0)
                ->update([
                    'status_psr' => 1,
                    'updated_at' => Carbon::now()
                ]);

            return response()->json([
                'success' => true,
                'message' => "Berhasil memulihkan {$restoredCount} data PSR"
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Permanent delete PSR data
     */
    public function permanentDelete($id)
    {
        try {
            $psr = DB::table('md_psr')
                ->select('cbg_psr')
                ->where('id_psr', $id)
                ->where('status_psr', 0)
                ->first();

            if (!$psr) {
                return redirect()->route('psr.trash')
                    ->with('error', 'Data PSR tidak ditemukan di trash');
            }

            // Permanent delete
            DB::table('md_psr')->where('id_psr', $id)->delete();

            return redirect()->route('psr.trash')
                ->with('success', "Data PSR '{$psr->cbg_psr}' berhasil dihapus permanen");

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Get statistics for dashboard
     */
    public function getStatistics()
    {
        try {
            $stats = [
                'total_active' => DB::table('md_psr')
                    ->where('status_psr', 1)
                    ->count(),
                
                'total_deleted' => DB::table('md_psr')
                    ->where('status_psr', 0)
                    ->count(),
                
                'with_coordinates' => DB::table('md_psr')
                    ->where('status_psr', 1)
                    ->whereNotNull('latitude_psr')
                    ->whereNotNull('longitude_psr')
                    ->count(),
                
                'by_province' => DB::table('md_psr')
                    ->select('md_provinsi.namadagri_prv', DB::raw('count(*) as total'))
                    ->leftJoin('md_kodepos', 'md_psr.id_kdp', '=', 'md_kodepos.id_kdp')
                    ->leftJoin('md_provinsi', 'md_kodepos.kodedagri_prv', '=', 'md_provinsi.kodedagri_prv')
                    ->where('md_psr.status_psr', 1)
                    ->groupBy('md_provinsi.namadagri_prv')
                    ->orderBy('total', 'desc')
                    ->limit(5)
                    ->get(),
                
                'recent_created' => DB::table('md_psr')
                    ->select('cbg_psr', 'created_at')
                    ->where('status_psr', 1)
                    ->orderBy('created_at', 'desc')
                    ->limit(5)
                    ->get()
            ];

            return response()->json([
                'success' => true,
                'data' => $stats
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Export PSR data to CSV
     */
    public function exportCsv(Request $request)
    {
        try {
            $query = DB::table('md_psr')
                ->select(
                    'md_psr.id_psr',
                    'md_psr.cbg_psr', 
                    'md_psr.alamat_psr',
                    'md_kodepos.kodepos_kdp', 
                    'md_kodepos.kel_kdp', 
                    'md_kodepos.kec_kdp',
                    'md_provinsi.namadagri_prv', 
                    'md_kabkota.namadagri_kbk',
                    'md_psr.latitude_psr',
                    'md_psr.longitude_psr',
                    'md_psr.created_at',
                    'md_psr.updated_at'
                )
                ->leftJoin('md_kodepos', 'md_psr.id_kdp', '=', 'md_kodepos.id_kdp')
                ->leftJoin('md_provinsi', 'md_kodepos.kodedagri_prv', '=', 'md_provinsi.kodedagri_prv')
                ->leftJoin('md_kabkota', 'md_kodepos.kodedagri_kbk', '=', 'md_kabkota.kodedagri_kbk')
                ->where('md_psr.status_psr', 1)
                ->orderBy('md_psr.id_psr', 'desc');

            // Apply filters if provided
            if ($request->has('provinsi') && !empty($request->provinsi)) {
                $query->where('md_kodepos.kodedagri_prv', $request->provinsi);
            }
            if ($request->has('kabkota') && !empty($request->kabkota)) {
                $query->where('md_kodepos.kodedagri_kbk', $request->kabkota);
            }
            if ($request->has('search') && !empty($request->search)) {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->where('md_psr.cbg_psr', 'ILIKE', "%{$search}%")
                    ->orWhere('md_psr.alamat_psr', 'ILIKE', "%{$search}%")
                    ->orWhere('md_kodepos.kodepos_kdp', 'ILIKE', "%{$search}%")
                    ->orWhere('md_kodepos.kel_kdp', 'ILIKE', "%{$search}%")
                    ->orWhere('md_kodepos.kec_kdp', 'ILIKE', "%{$search}%");
                });
            }

            $data = $query->get();

            $filename = 'data_psr_' . date('Y-m-d_H-i-s') . '.csv';

            $headers = [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => "attachment; filename=\"{$filename}\"",
                'Pragma' => 'no-cache',
                'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
                'Expires' => '0'
            ];

            $callback = function() use ($data) {
                $file = fopen('php://output', 'w');
                
                // Add BOM for proper UTF-8 encoding in Excel
                fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
                
                // CSV Headers
                fputcsv($file, [
                    'ID PSR',
                    'Cabang PSR',
                    'Alamat',
                    'Kodepos',
                    'Kelurahan',
                    'Kecamatan',
                    'Provinsi',
                    'Kabupaten/Kota',
                    'Latitude',
                    'Longitude',
                    'Dibuat Pada',
                    'Diperbarui Pada'
                ]);

                // CSV Data
                foreach ($data as $row) {
                    fputcsv($file, [
                        $row->id_psr,
                        $row->cbg_psr,
                        $row->alamat_psr,
                        $row->kodepos_kdp,
                        $row->kel_kdp,
                        $row->kec_kdp,
                        $row->namadagri_prv,
                        $row->namadagri_kbk,
                        $row->latitude_psr,
                        $row->longitude_psr,
                        $row->created_at,
                        $row->updated_at
                    ]);
                }

                fclose($file);
            };

            return response()->stream($callback, 200, $headers);

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat export: ' . $e->getMessage());
        }
    }


    /**
     * Get PSR by province ID
     */
    public function getByProvinsi($provinsiId)
    {
        $psr = DB::table('md_psr')
            ->select(
                'md_psr.*', 
                'md_kodepos.kodepos_kdp', 
                'md_kodepos.kel_kdp', 
                'md_kodepos.kec_kdp'
            )
            ->leftJoin('md_kodepos', 'md_psr.id_kdp', '=', 'md_kodepos.id_kdp')
            ->where('md_kodepos.kodedagri_prv', $provinsiId)
            ->where('md_psr.status_psr', 1)
            ->orderBy('md_psr.cbg_psr', 'asc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $psr,
            'total' => $psr->count()
        ]);
    }

    /**
     * Get PSR by kabkota ID
     */
    public function getByKabkota($kabkotaId)
    {
        $psr = DB::table('md_psr')
            ->select(
                'md_psr.*', 
                'md_kodepos.kodepos_kdp', 
                'md_kodepos.kel_kdp', 
                'md_kodepos.kec_kdp'
            )
            ->leftJoin('md_kodepos', 'md_psr.id_kdp', '=', 'md_kodepos.id_kdp')
            ->where('md_kodepos.kodedagri_kbk', $kabkotaId)
            ->where('md_psr.status_psr', 1)
            ->orderBy('md_psr.cbg_psr', 'asc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $psr,
            'total' => $psr->count()
        ]);
    }

    /**
     * Get PSR by kodepos ID
     */
    public function getByKodepos($kodeposId)
    {
        $psr = DB::table('md_psr')
            ->select('md_psr.*')
            ->where('id_kdp', $kodeposId)
            ->where('status_psr', 1)
            ->orderBy('cbg_psr', 'asc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $psr,
            'total' => $psr->count()
        ]);
    }

    /**
     * Restore PSR (Set status back to 1)
     */
    public function restore($id)
    {
        try {
            $psr = DB::table('md_psr')
                ->select('cbg_psr')
                ->where('id_psr', $id)
                ->where('status_psr', 0)
                ->first();

            if (!$psr) {
                return redirect()->route('psr.trash')
                    ->with('error', 'Data PSR tidak ditemukan di trash');
            }

            DB::table('md_psr')
                ->where('id_psr', $id)
                ->update([
                    'status_psr' => 1,
                    'updated_at' => Carbon::now()
                ]);

            return redirect()->route('psr.trash')
                ->with('success', "Data PSR '{$psr->cbg_psr}' berhasil dipulihkan");

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
        $query = DB::table('md_psr')
            ->select(
                'md_psr.*', 
                'md_kodepos.kodepos_kdp', 
                'md_kodepos.kel_kdp', 
                'md_kodepos.kec_kdp',
                'md_provinsi.namadagri_prv', 
                'md_kabkota.namadagri_kbk'
            )
            ->leftJoin('md_kodepos', 'md_psr.id_kdp', '=', 'md_kodepos.id_kdp')
            ->leftJoin('md_provinsi', 'md_kodepos.kodedagri_prv', '=', 'md_provinsi.kodedagri_prv')
            ->leftJoin('md_kabkota', 'md_kodepos.kodedagri_kbk', '=', 'md_kabkota.kodedagri_kbk')
            ->where('md_psr.status_psr', 0) // Status deleted
            ->orderBy('md_psr.updated_at', 'desc');

        // Search functionality
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('md_psr.cbg_psr', 'ILIKE', "%{$search}%")
                ->orWhere('md_psr.alamat_psr', 'ILIKE', "%{$search}%")
                ->orWhere('md_kodepos.kodepos_kdp', 'ILIKE', "%{$search}%")
                ->orWhere('md_kodepos.kel_kdp', 'ILIKE', "%{$search}%")
                ->orWhere('md_kodepos.kec_kdp', 'ILIKE', "%{$search}%");
            });
        }

        $psr = $query->paginate(10);

        return view('psr.trash', compact('psr'));
    }

    /**
     * Get PSR data with coordinates for mapping
     */
    public function getForMap(Request $request)
    {
        $query = DB::table('md_psr')
            ->select(
                'md_psr.*', 
                'md_kodepos.kodepos_kdp', 
                'md_kodepos.kel_kdp', 
                'md_kodepos.kec_kdp',
                'md_provinsi.namadagri_prv', 
                'md_kabkota.namadagri_kbk'
            )
            ->leftJoin('md_kodepos', 'md_psr.id_kdp', '=', 'md_kodepos.id_kdp')
            ->leftJoin('md_provinsi', 'md_kodepos.kodedagri_prv', '=', 'md_provinsi.kodedagri_prv')
            ->leftJoin('md_kabkota', 'md_kodepos.kodedagri_kbk', '=', 'md_kabkota.kodedagri_kbk')
            ->where('md_psr.status_psr', 1)
            ->whereNotNull('md_psr.latitude_psr')
            ->whereNotNull('md_psr.longitude_psr')
            ->orderBy('md_psr.id_psr', 'desc');

        // Filter by bounds if provided (for map viewport)
        if ($request->has('bounds')) {
            $bounds = $request->bounds;
            $query->whereBetween('md_psr.latitude_psr', [$bounds['south'], $bounds['north']])
                  ->whereBetween('md_psr.longitude_psr', [$bounds['west'], $bounds['east']]);
        }

        $psr = $query->get();

        return response()->json([
            'success' => true,
            'data' => $psr,
            'total' => $psr->count()
        ]);
    }

}