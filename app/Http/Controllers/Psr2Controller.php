<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class PsrController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = DB::table('md_psr')
            ->select('md_psr.*', 'md_kodepos.kodepos_kdp', 'md_kodepos.kel_kdp', 'md_kodepos.kec_kdp', 
                     'md_provinsi.namadagri_prv', 'md_kabkota.namadagri_kbk')
            ->leftJoin('md_kodepos', 'md_psr.id_kdp', '=', 'md_kodepos.id_kdp')
            ->leftJoin('md_provinsi', 'md_kodepos.kodedagri_prv', '=', 'md_provinsi.kodedagri_prv')
            ->leftJoin('md_kabkota', 'md_kodepos.kodedagri_kbk', '=', 'md_kabkota.kodedagri_kbk')
            ->where('md_psr.status_psr', 1)
            ->orderBy('md_psr.id_psr', 'desc');

        // Search functionality
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('md_psr.cbg_psr', 'ILIKE', "%{$search}%")
                  ->orWhere('md_psr.alamat_psr', 'ILIKE', "%{$search}%")
                  ->orWhere('md_kodepos.kel_kdp', 'ILIKE', "%{$search}%")
                  ->orWhere('md_kodepos.kec_kdp', 'ILIKE', "%{$search}%");
            });
        }

        $psr = $query->paginate(10);

        return view('psr.index', compact('psr'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kodepos = DB::table('md_kodepos')
            ->select('md_kodepos.*', 'md_provinsi.namadagri_prv', 'md_kabkota.namadagri_kbk')
            ->leftJoin('md_provinsi', 'md_kodepos.kodedagri_prv', '=', 'md_provinsi.kodedagri_prv')
            ->leftJoin('md_kabkota', 'md_kodepos.kodedagri_kbk', '=', 'md_kabkota.kodedagri_kbk')
            ->where('md_kodepos.status_kdp', 1)
            ->orderBy('md_kodepos.kec_kdp', 'asc')
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
        // Gunakan raw SQL untuk menghindari "returning id"
        $sql = "INSERT INTO md_psr (id_kdp, cbg_psr, alamat_psr, longitude_psr, latitude_psr, updated_at) VALUES (?, ?, ?, ?, ?, ?)";
        
        DB::statement($sql, [
            $request->id_kdp,
            trim($request->cbg_psr),
            trim($request->alamat_psr),
            $request->longitude_psr ? (float)$request->longitude_psr : null,
            $request->latitude_psr ? (float)$request->latitude_psr : null,
            Carbon::now()
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
            ->select('md_psr.*', 'md_kodepos.kodepos_kdp', 'md_kodepos.kel_kdp', 'md_kodepos.kec_kdp', 
                     'md_provinsi.namadagri_prv', 'md_kabkota.namadagri_kbk')
            ->leftJoin('md_kodepos', 'md_psr.id_kdp', '=', 'md_kodepos.id_kdp')
            ->leftJoin('md_provinsi', 'md_kodepos.kodedagri_prv', '=', 'md_provinsi.kodedagri_prv')
            ->leftJoin('md_kabkota', 'md_kodepos.kodedagri_kbk', '=', 'md_kabkota.kodedagri_kbk')
            ->where('md_psr.id_psr', $id)
            ->where('md_psr.status_psr', 1)
            ->first();

        if (!$psr) {
            return redirect()->route('psr.index')
                ->with('error', 'Data panic button tidak ditemukan');
        }

        return view('psr.show', compact('psr'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $psr = DB::table('md_psr')
            ->where('id_psr', $id)
            ->where('status_psr', 1)
            ->first();

        if (!$psr) {
            return redirect()->route('psr.index')
                ->with('error', 'Data panic button tidak ditemukan');
        }

        $kodepos = DB::table('md_kodepos')
            ->select('md_kodepos.*', 'md_provinsi.namadagri_prv', 'md_kabkota.namadagri_kbk')
            ->leftJoin('md_provinsi', 'md_kodepos.kodedagri_prv', '=', 'md_provinsi.kodedagri_prv')
            ->leftJoin('md_kabkota', 'md_kodepos.kodedagri_kbk', '=', 'md_kabkota.kodedagri_kbk')
            ->where('md_kodepos.status_kdp', 1)
            ->orderBy('md_kodepos.kec_kdp', 'asc')
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
            $psr = DB::table('md_psr')
                ->where('id_psr', $id)
                ->where('status_psr', 1)
                ->first();

            if (!$psr) {
                return redirect()->route('psr.index')
                    ->with('error', 'Data panic button tidak ditemukan');
            }

            DB::table('md_psr')
                ->where('id_psr', $id)
                ->update([
                    'id_kdp' => $request->id_kdp,
                    'cbg_psr' => $request->cbg_psr,
                    'alamat_psr' => $request->alamat_psr,
                    'longitude_psr' => $request->longitude_psr,
                    'latitude_psr' => $request->latitude_psr,
                    'updated_at' => Carbon::now()
                ]);

            return redirect()->route('psr.index')
                ->with('success', 'Panic Button berhasil diperbarui');
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
                ->where('id_psr', $id)
                ->where('status_psr', 1)
                ->first();

            if (!$psr) {
                return redirect()->route('psr.index')
                    ->with('error', 'Data panic button tidak ditemukan');
            }

            DB::table('md_psr')
                ->where('id_psr', $id)
                ->update([
                    'status_psr' => 0,
                    'updated_at' => Carbon::now()
                ]);

            return redirect()->route('psr.index')
                ->with('success', 'Panic Button berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Get all psr data for API or AJAX
     */
    public function getData()
    {
        $psr = DB::table('md_psr')
            ->select('md_psr.*', 'md_kodepos.kodepos_kdp', 'md_kodepos.kel_kdp', 'md_kodepos.kec_kdp', 
                     'md_provinsi.namadagri_prv', 'md_kabkota.namadagri_kbk')
            ->leftJoin('md_kodepos', 'md_psr.id_kdp', '=', 'md_kodepos.id_kdp')
            ->leftJoin('md_provinsi', 'md_kodepos.kodedagri_prv', '=', 'md_provinsi.kodedagri_prv')
            ->leftJoin('md_kabkota', 'md_kodepos.kodedagri_kbk', '=', 'md_kabkota.kodedagri_kbk')
            ->where('md_psr.status_psr', 1)
            ->orderBy('md_psr.id_psr', 'desc')
            ->get();

        return response()->json($psr);
    }

    /**
     * Restore psr (Set status back to 1)
     */
    public function restore($id)
    {
        try {
            $psr = DB::table('md_psr')
                ->where('id_psr', $id)
                ->where('status_psr', 0)
                ->first();

            if (!$psr) {
                return redirect()->route('psr.trash')
                    ->with('error', 'Data panic button tidak ditemukan');
            }

            DB::table('md_psr')
                ->where('id_psr', $id)
                ->update([
                    'status_psr' => 1,
                    'updated_at' => Carbon::now()
                ]);

            return redirect()->route('psr.trash')
                ->with('success', 'Panic Button berhasil dipulihkan');
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
        $psr = DB::table('md_psr')
            ->select('md_psr.*', 'md_kodepos.kodepos_kdp', 'md_kodepos.kel_kdp', 'md_kodepos.kec_kdp', 
                     'md_provinsi.namadagri_prv', 'md_kabkota.namadagri_kbk')
            ->leftJoin('md_kodepos', 'md_psr.id_kdp', '=', 'md_kodepos.id_kdp')
            ->leftJoin('md_provinsi', 'md_kodepos.kodedagri_prv', '=', 'md_provinsi.kodedagri_prv')
            ->leftJoin('md_kabkota', 'md_kodepos.kodedagri_kbk', '=', 'md_kabkota.kodedagri_kbk')
            ->where('md_psr.status_psr', 0)
            ->orderBy('md_psr.updated_at', 'desc')
            ->paginate(10);

        return view('psr.trash', compact('psr'));
    }

    /**
     * Permanent delete psr
     */
    public function forceDelete($id)
    {
        try {
            if (!is_numeric($id)) {
                return redirect()->route('psr.trash')
                    ->with('error', 'ID panic button tidak valid');
            }

            $psr = DB::table('md_psr')
                ->where('id_psr', $id)
                ->where('status_psr', 0)
                ->first();

            if (!$psr) {
                return redirect()->route('psr.trash')
                    ->with('error', 'Data panic button tidak ditemukan');
            }

            DB::table('md_psr')
                ->where('id_psr', $id)
                ->delete();

            return redirect()->route('psr.trash')
                ->with('success', 'Panic Button berhasil dihapus permanen');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Panic Button Activation - Store emergency report
     */
    public function activatePanicButton(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_psr' => 'required|integer|exists:md_psr,id_psr',
            'user_id' => 'nullable|integer',
            'jenis_laporan' => 'required|string|max:50',
            'deskripsi_laporan' => 'nullable|string',
            'koordinat_lat' => 'nullable|numeric|between:-90,90',
            'koordinat_lng' => 'nullable|numeric|between:-180,180'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Insert laporan darurat
            $laporanId = DB::table('tb_laporan_darurat')->insertGetId([
            'id_psr' => $request->id_psr,
            'user_id' => $request->user_id,
            'jenis_laporan' => $request->jenis_laporan,
            'deskripsi_laporan' => $request->deskripsi_laporan,
            'koordinat_lat' => $request->koordinat_lat,
            'koordinat_lng' => $request->koordinat_lng,
            'status_laporan' => 'AKTIF',
            // 'tanggal_laporan' => Carbon::now(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
            ]);

            // Get psr data with location details
            $psrData = DB::table('md_psr')
            ->select('md_psr.*', 'md_kodepos.*', 'md_provinsi.namadagri_prv', 'md_kabkota.namadagri_kbk')
            ->leftJoin('md_kodepos', 'md_psr.id_kdp', '=', 'md_kodepos.id_kdp')
            ->leftJoin('md_provinsi', 'md_kodepos.kodedagri_prv', '=', 'md_provinsi.kodedagri_prv')
            ->leftJoin('md_kabkota', 'md_kodepos.kodedagri_kbk', '=', 'md_kabkota.kodedagri_kbk')
            ->where('md_psr.id_psr', $request->id_psr)
            ->first();

            return response()->json([
            'success' => true,
            'message' => 'Laporan darurat berhasil dikirim',
            'data' => [
                'laporan_id' => $laporanId,
                'psr_info' => $psrData,
                'timestamp' => Carbon::now()->toDateTimeString()
            ]
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
     * API: Delete psr (set status to 0)
     */
    public function apiDestroy($id)
    {
        try {
            $psr = DB::table('md_psr')
                ->where('id_psr', $id)
                ->where('status_psr', 1)
                ->first();

            if (!$psr) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data panic button tidak ditemukan',
                    'data' => null
                ], 404);
            }

            DB::table('md_psr')
                ->where('id_psr', $id)
                ->update([
                    'status_psr' => 0,
                    'updated_at' => Carbon::now()
                ]);

            return response()->json([
                'success' => true,
                'message' => 'Panic Button berhasil dihapus',
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
            $psr = DB::table('md_psr')
                ->select('md_psr.*', 'md_kodepos.kodepos_kdp', 'md_kodepos.kel_kdp', 'md_kodepos.kec_kdp', 
                         'md_provinsi.namadagri_prv', 'md_kabkota.namadagri_kbk')
                ->leftJoin('md_kodepos', 'md_psr.id_kdp', '=', 'md_kodepos.id_kdp')
                ->leftJoin('md_provinsi', 'md_kodepos.kodedagri_prv', '=', 'md_provinsi.kodedagri_prv')
                ->leftJoin('md_kabkota', 'md_kodepos.kodedagri_kbk', '=', 'md_kabkota.kodedagri_kbk')
                ->where('md_psr.status_psr', 0)
                ->orderBy('md_psr.updated_at', 'desc')
                ->get();

            return response()->json([
                'success' => true,
                'message' => 'Data trash berhasil diambil',
                'data' => $psr
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
     * API: Restore psr (set status back to 1)
     */
   public function apiRestore($id)
{
    try {
        $psr = DB::table('md_psr')
            ->where('id_psr', $id)
            ->where('status_psr', 0)
            ->first();

        if (!$psr) {
            return response()->json([
                'success' => false,
                'message' => 'Data panic button tidak ditemukan',
                'data' => null
            ], 404);
        }

        DB::table('md_psr')
            ->where('id_psr', $id)
            ->update([
                'status_psr' => 1,
                'updated_at' => Carbon::now()
            ]);

        $restoredPsr = DB::table('md_psr')
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
            ->first();

        return response()->json([
            'success' => true,
            'message' => 'Panic Button berhasil dipulihkan',
            'data' => $restoredPsr
        ], 200);

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
            'data' => null
        ], 500);
    }
}

public function apiActivate(Request $request)
{
    try {
        // Validasi input jika diperlukan
        $psr = DB::table('md_psr')
            ->where('id_psr', $request->id_psr)
            ->where('status_psr', 1)
            ->first();

        if (!$psr) {
            return response()->json([
                'success' => false,
                'message' => 'Data panic button tidak ditemukan atau sudah tidak aktif',
                'data' => null
            ], 404);
        }

        // Insert laporan atau logic aktivasi panic button
        $laporanId = DB::table('laporan_darurat')->insertGetId([
            'id_psr' => $request->id_psr,
            'waktu_laporan' => Carbon::now(),
            'status_laporan' => 'aktif',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        // Ambil data PSR dengan join
        $psrData = DB::table('md_psr')
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
            ->where('md_psr.id_psr', $request->id_psr)
            ->first();

        return response()->json([
            'success' => true,
            'message' => 'Panic Button berhasil diaktifkan. Laporan darurat telah dikirim!',
            'data' => [
                'laporan_id' => $laporanId,
                'psr_info' => $psrData,
                'timestamp' => Carbon::now()->toDateTimeString()
            ]
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
     * Get nearby panic buttons by coordinates
     */
    public function getNearbyPanicButtons(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'radius' => 'nullable|numeric|min:0|max:50' // radius in km, max 50km
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        $latitude = $request->latitude;
        $longitude = $request->longitude;
        $radius = $request->radius ?? 10; // default 10km

        try {
            $nearbyPsr = DB::table('md_psr')
                ->select('md_psr.*', 'md_kodepos.kodepos_kdp', 'md_kodepos.kel_kdp', 'md_kodepos.kec_kdp',
                         'md_provinsi.namadagri_prv', 'md_kabkota.namadagri_kbk',
                         DB::raw("(6371 * acos(cos(radians($latitude)) * cos(radians(latitude_psr)) * 
                                  cos(radians(longitude_psr) - radians($longitude)) + 
                                  sin(radians($latitude)) * sin(radians(latitude_psr)))) AS distance"))
                ->leftJoin('md_kodepos', 'md_psr.id_kdp', '=', 'md_kodepos.id_kdp')
                ->leftJoin('md_provinsi', 'md_kodepos.kodedagri_prv', '=', 'md_provinsi.kodedagri_prv')
                ->leftJoin('md_kabkota', 'md_kodepos.kodedagri_kbk', '=', 'md_kabkota.kodedagri_kbk')
                ->where('md_psr.status_psr', 1)
                ->whereNotNull('md_psr.latitude_psr')
                ->whereNotNull('md_psr.longitude_psr')
                ->havingRaw("distance <= $radius")
                ->orderBy('distance', 'asc')
                ->get();

            return response()->json([
                'success' => true,
                'message' => 'Data panic button terdekat berhasil diambil',
                'data' => $nearbyPsr,
                'search_params' => [
                    'latitude' => $latitude,
                    'longitude' => $longitude,
                    'radius_km' => $radius
                ]
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
 