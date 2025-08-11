<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

    class KabkotaController extends Controller
    {
        /**
         * Display a listing of the resource.
         */
        public function index(Request $request)
        {
            $query = DB::table('md_kabkota')
                ->select('md_kabkota.*', 'md_provinsi.namadagri_prv')
                ->leftJoin('md_provinsi', 'md_kabkota.kodedagri_prv', '=', 'md_provinsi.kodedagri_prv')
                ->where('md_kabkota.status_kbk', 1) // Hanya tampilkan data dengan status aktif
                ->orderBy('md_kabkota.kodedagri_kbk', 'desc');    

            // Search functionality
            if ($request->has('search') && !empty($request->search)) {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->where('md_kabkota.namadagri_kbk', 'ILIKE', "%{$search}%")
                    ->orWhere('md_kabkota.namabps_kbk', 'ILIKE', "%{$search}%")
                    ->orWhere('md_kabkota.kodedagri_kbk', 'ILIKE', "%{$search}%")
                    ->orWhere('md_provinsi.namadagri_prv', 'ILIKE', "%{$search}%");
                });
            }

            // Filter by province
            if ($request->has('provinsi') && !empty($request->provinsi)) {
                $query->where('md_kabkota.kodedagri_prv', $request->provinsi);
            }

            // Pagination dengan append query parameters
           $kabkota = $query->paginate(10)->withQueryString();

            // Get provinces for filter dropdown
            $provinsi = DB::table('md_provinsi')
                ->select('kodedagri_prv', 'namadagri_prv')
                ->where('status_prv', 1)
                ->orderBy('namadagri_prv', 'asc')
                ->get();

            return view('kabkota.index', compact('kabkota', 'provinsi'));
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

            return view('kabkota.create', compact('provinsi'));
        }

        /**
         * Store a newly created resource in storage.
         */
        public function store(Request $request)
        {
            $validator = Validator::make($request->all(), [
                'kodedagri_kbk' => 'required|integer|unique:md_kabkota,kodedagri_kbk',
                'kodedagri_prv' => 'required|integer|exists:md_provinsi,kodedagri_prv',
                'namadagri_kbk' => 'required|string|max:100',
                'kodebps_kbk' => 'required|integer',
                'namabps_kbk' => 'required|string|max:100',
            ]);

            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }

            try {
                DB::table('md_kabkota')->insert([
                    'kodedagri_kbk' => $request->kodedagri_kbk,
                    'kodedagri_prv' => $request->kodedagri_prv,
                    'namadagri_kbk' => $request->namadagri_kbk,
                    'kodebps_kbk' => $request->kodebps_kbk,
                    'namabps_kbk' => $request->namabps_kbk,
                    'status_kbk' => 1, // Status aktif saat dibuat
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]);

                return redirect()->route('kabkota.index')
                    ->with('success', 'Kabupaten/Kota berhasil ditambahkan');
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
            $kabkota = DB::table('md_kabkota')
                ->select('md_kabkota.*', 'md_provinsi.namadagri_prv')
                ->leftJoin('md_provinsi', 'md_kabkota.kodedagri_prv', '=', 'md_provinsi.kodedagri_prv')
                ->where('md_kabkota.kodedagri_kbk', $id)
                ->where('md_kabkota.status_kbk', 1)
                ->first();

            if (!$kabkota) {
                return redirect()->route('kabkota.index')
                    ->with('error', 'Data kabupaten/kota tidak ditemukan');
            }

            return view('kabkota.show', compact('kabkota'));
        }

        /**
         * Show the form for editing the specified resource.
         */
        public function edit($id)
        {
            $kabkota = DB::table('md_kabkota')
                ->where('kodedagri_kbk', $id)
                ->where('status_kbk', 1)
                ->first();

            if (!$kabkota) {
                return redirect()->route('kabkota.index')
                    ->with('error', 'Data kabupaten/kota tidak ditemukan');
            }

            // Get provinces for dropdown
            $provinsi = DB::table('md_provinsi')
                ->select('kodedagri_prv', 'namadagri_prv')
                ->where('status_prv', 1)
                ->orderBy('namadagri_prv', 'asc')
                ->get();

            return view('kabkota.edit', compact('kabkota', 'provinsi'));
        }

        /**
         * Update the specified resource in storage.
         */
        public function update(Request $request, $id)
        {
            $validator = Validator::make($request->all(), [
                'kodedagri_kbk' => 'required|integer|unique:md_kabkota,kodedagri_kbk,' . $id . ',kodedagri_kbk',
                'kodedagri_prv' => 'required|integer|exists:md_provinsi,kodedagri_prv',
                'namadagri_kbk' => 'required|string|max:100',
                'kodebps_kbk' => 'required|integer',
                'namabps_kbk' => 'required|string|max:100',
            ]);

            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }

            try {
                $kabkota = DB::table('md_kabkota')
                    ->where('kodedagri_kbk', $id)
                    ->where('status_kbk', 1)
                    ->first();

                if (!$kabkota) {
                    return redirect()->route('kabkota.index')
                        ->with('error', 'Data kabupaten/kota tidak ditemukan');
                }

                DB::table('md_kabkota')
                    ->where('kodedagri_kbk', $id)
                    ->update([
                        'kodedagri_kbk' => $request->kodedagri_kbk,
                        'kodedagri_prv' => $request->kodedagri_prv,
                        'namadagri_kbk' => $request->namadagri_kbk,
                        'kodebps_kbk' => $request->kodebps_kbk,
                        'namabps_kbk' => $request->namabps_kbk,
                        // 'tanggalubah_kbk' => Carbon::now(),
                        'updated_at' => Carbon::now()
                    ]);

                return redirect()->route('kabkota.index')
                    ->with('success', 'Kabupaten/Kota berhasil diperbarui');
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
                $kabkota = DB::table('md_kabkota')
                    ->where('kodedagri_kbk', $id)
                    ->where('status_kbk', 1)
                    ->first();

                if (!$kabkota) {
                    return redirect()->route('kabkota.index')
                        ->with('error', 'Data kabupaten/kota tidak ditemukan');
                }

                // Set status menjadi 0 (tidak aktif/dihapus)
                DB::table('md_kabkota')
                    ->where('kodedagri_kbk', $id)
                    ->update([
                        'status_kbk' => 0,
                        // 'tanggalubah_kbk' => Carbon::now(),
                        'updated_at' => Carbon::now()
                    ]);

                return redirect()->route('kabkota.index')
                    ->with('success', 'Kabupaten/Kota berhasil dihapus');
            } catch (\Exception $e) {
                return redirect()->back()
                    ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
            }
        }

        /**
         * Get all kabkota data for API or AJAX
         */
        public function getData(Request $request)
        {
            $query = DB::table('md_kabkota')
                ->select('md_kabkota.*', 'md_provinsi.namadagri_prv')
                ->leftJoin('md_provinsi', 'md_kabkota.kodedagri_prv', '=', 'md_provinsi.kodedagri_prv')
                ->where('md_kabkota.status_kbk', 1)
                ->orderBy('md_kabkota.kodedagri_kbk', 'desc');

            // Filter by province if provided
            if ($request->has('provinsi') && !empty($request->provinsi)) {
                $query->where('md_kabkota.kodedagri_prv', $request->provinsi);
            }

            $kabkota = $query->get();

            return response()->json($kabkota);
        }

        /**
         * Get kabkota by province ID
         */
        public function getByProvinsi($provinsiId)
        {
            $kabkota = DB::table('md_kabkota')
                ->select('*')
                ->where('kodedagri_prv', $provinsiId)
                ->where('status_kbk', 1)
                ->orderBy('namadagri_kbk', 'asc')
                ->get();

            return response()->json($kabkota);
        }

        /**
         * Restore kabkota (Set status back to 1)
         */
        
        public function restore($id)
        {
            try {
                $kabkota = DB::table('md_kabkota')
                    ->where('kodedagri_kbk', $id)
                    ->where('status_kbk', 0)
                    ->first();

                if (!$kabkota) {
                    return redirect()->route('kabkota.trash')
                        ->with('error', 'Data kabupaten/kota tidak ditemukan');
                }

                DB::table('md_kabkota')
                    ->where('kodedagri_kbk', $id)
                    ->update([
                        'status_kbk' => 1,
                        // 'tanggalubah_kbk' => Carbon::now(),
                        'updated_at' => Carbon::now()
                    ]);

                return redirect()->route('kabkota.trash')
                    ->with('success', 'Kabupaten/Kota berhasil dipulihkan');
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
            $query = DB::table('md_kabkota')
                ->select('md_kabkota.*', 'md_provinsi.namadagri_prv')
                ->leftJoin('md_provinsi', 'md_kabkota.kodedagri_prv', '=', 'md_provinsi.kodedagri_prv')
                ->where('md_kabkota.status_kbk', 0) // Ubah ke 0 untuk status deleted
                ->orderBy('md_kabkota.updated_at', 'desc');

            // Search functionality
            if ($request->has('search') && !empty($request->search)) {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->where('md_kabkota.namadagri_kbk', 'ILIKE', "%{$search}%")
                    ->orWhere('md_kabkota.namabps_kbk', 'ILIKE', "%{$search}%")
                    ->orWhere('md_kabkota.kodedagri_kbk', 'ILIKE', "%{$search}%")
                    ->orWhere('md_provinsi.namadagri_prv', 'ILIKE', "%{$search}%");
                });
            }

            $kabkota = $query->paginate(10);
            $kabkota->appends($request->query());

            return view('kabkota.trash', compact('kabkota'));
        }
        
        /**
         * Permanent delete kabkota
         */
        public function forceDelete($id)
        {
            try {
                // Validasi ID
                if (!is_numeric($id)) {
                    return redirect()->route('kabkota.trash')
                        ->with('error', 'ID kabupaten/kota tidak valid');
                }

                $kabkota = DB::table('md_kabkota')
                    ->where('kodedagri_kbk', $id)
                    ->where('status_kbk', 0)
                    ->first();

                if (!$kabkota) {
                    return redirect()->route('kabkota.trash')
                        ->with('error', 'Data kabupaten/kota tidak ditemukan');
                }

                DB::table('md_kabkota')
                    ->where('kodedagri_kbk', $id)
                    ->delete();

                return redirect()->route('kabkota.trash')
                    ->with('success', 'Kabupaten/Kota berhasil dihapus permanen');
            } catch (\Exception $e) {
                return redirect()->back()
                    ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
            }
        }
    
        // ===== REST API METHODS =====

        /**
         * API: Get all kabkota data
         */
        public function apiIndex(Request $request)
        {
            try {
                $query = DB::table('md_kabkota')
                    ->select('md_kabkota.*', 'md_provinsi.namadagri_prv')
                    ->leftJoin('md_provinsi', 'md_kabkota.kodedagri_prv', '=', 'md_provinsi.kodedagri_prv')
                    ->where('md_kabkota.status_kbk', 1)
                    ->orderBy('md_kabkota.kodedagri_kbk', 'desc');

                // Search functionality
                if ($request->has('search') && !empty($request->search)) {
                    $search = $request->search;
                    $query->where(function($q) use ($search) {
                        $q->where('md_kabkota.namadagri_kbk', 'ILIKE', "%{$search}%")
                        ->orWhere('md_kabkota.namabps_kbk', 'ILIKE', "%{$search}%")
                        ->orWhere('md_kabkota.kodedagri_kbk', 'ILIKE', "%{$search}%")
                        ->orWhere('md_provinsi.namadagri_prv', 'ILIKE', "%{$search}%");
                    });
                }

                // Filter by province
                if ($request->has('provinsi') && !empty($request->provinsi)) {
                    $query->where('md_kabkota.kodedagri_prv', $request->provinsi);
                }

                $kabkota = $query->get();

                return response()->json([
                    'success' => true,
                    'message' => 'Data kabupaten/kota berhasil diambil',
                    'data' => $kabkota
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
         * API: Get kabkota by ID
         */
        public function apiShow($id)
        {
            try {
                $kabkota = DB::table('md_kabkota')
                    ->select('md_kabkota.*', 'md_provinsi.namadagri_prv')
                    ->leftJoin('md_provinsi', 'md_kabkota.kodedagri_prv', '=', 'md_provinsi.kodedagri_prv')
                    ->where('md_kabkota.kodedagri_kbk', $id)
                    ->where('md_kabkota.status_kbk', 1)
                    ->first();

                if (!$kabkota) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Data kabupaten/kota tidak ditemukan',
                        'data' => null
                    ], 404);
                }

                return response()->json([
                    'success' => true,
                    'message' => 'Data kabupaten/kota berhasil diambil',
                    'data' => $kabkota
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
         * API: Store new kabkota
         */
        public function apiStore(Request $request)
        {
            $validator = Validator::make($request->all(), [
                'kodedagri_kbk' => 'required|integer|unique:md_kabkota,kodedagri_kbk',
                'kodedagri_prv' => 'required|integer|exists:md_provinsi,kodedagri_prv',
                'namadagri_kbk' => 'required|string|max:100',
                'kodebps_kbk' => 'required|integer',
                'namabps_kbk' => 'required|string|max:100',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validasi gagal',
                    'errors' => $validator->errors()
                ], 422);
            }

            try {
                DB::table('md_kabkota')->insert([
                    'kodedagri_kbk' => $request->kodedagri_kbk,
                    'kodedagri_prv' => $request->kodedagri_prv,
                    'namadagri_kbk' => $request->namadagri_kbk,
                    'kodebps_kbk' => $request->kodebps_kbk,
                    'namabps_kbk' => $request->namabps_kbk,
                    'status_kbk' => 1,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]);

                // Get the last inserted record
                $kabkota = DB::table('md_kabkota')
                    ->select('md_kabkota.*', 'md_provinsi.namadagri_prv')
                    ->leftJoin('md_provinsi', 'md_kabkota.kodedagri_prv', '=', 'md_provinsi.kodedagri_prv')
                    ->where('md_kabkota.kodedagri_kbk', $request->kodedagri_kbk)
                    ->where('md_kabkota.status_kbk', 1)
                    ->first();

                return response()->json([
                    'success' => true,
                    'message' => 'Kabupaten/Kota berhasil ditambahkan',
                    'data' => $kabkota
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
         * API: Update kabkota
         */
        public function apiUpdate(Request $request, $id)
        {
            $validator = Validator::make($request->all(), [
                'kodedagri_kbk' => 'required|integer|unique:md_kabkota,kodedagri_kbk,' . $id . ',kodedagri_kbk',
                'kodedagri_prv' => 'required|integer|exists:md_provinsi,kodedagri_prv',
                'namadagri_kbk' => 'required|string|max:100',
                'kodebps_kbk' => 'required|integer',
                'namabps_kbk' => 'required|string|max:100',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validasi gagal',
                    'errors' => $validator->errors()
                ], 422);
            }

            try {
                $kabkota = DB::table('md_kabkota')
                    ->where('kodedagri_kbk', $id)
                    ->where('status_kbk', 1)
                    ->first();

                if (!$kabkota) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Data kabupaten/kota tidak ditemukan',
                        'data' => null
                    ], 404);
                }

                DB::table('md_kabkota')
                    ->where('kodedagri_kbk', $id)
                    ->update([
                        'kodedagri_kbk' => $request->kodedagri_kbk,
                        'kodedagri_prv' => $request->kodedagri_prv,
                        'namadagri_kbk' => $request->namadagri_kbk,
                        'kodebps_kbk' => $request->kodebps_kbk,
                        'namabps_kbk' => $request->namabps_kbk,
                        // 'tanggalubah_kbk' => Carbon::now(),
                        'updated_at' => Carbon::now()
                    ]);

                $updatedKabkota = DB::table('md_kabkota')
                    ->select('md_kabkota.*', 'md_provinsi.namadagri_prv')
                    ->leftJoin('md_provinsi', 'md_kabkota.kodedagri_prv', '=', 'md_provinsi.kodedagri_prv')
                    ->where('md_kabkota.kodedagri_kbk', $request->kodedagri_kbk)
                    ->first();

                return response()->json([
                    'success' => true,
                    'message' => 'Kabupaten/Kota berhasil diperbarui',
                    'data' => $updatedKabkota
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
         * API: Delete kabkota (set status to 0)
         */
        public function apiDestroy($id)
        {
            try {
                $kabkota = DB::table('md_kabkota')
                    ->where('kodedagri_kbk', $id)
                    ->where('status_kbk', 1)
                    ->first();

                if (!$kabkota) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Data kabupaten/kota tidak ditemukan',
                        'data' => null
                    ], 404);
                }

                // Set status menjadi 0
                DB::table('md_kabkota')
                    ->where('kodedagri_kbk', $id)
                    ->update([
                        'status_kbk' => 0,
                        // 'tanggalubah_kbk' => Carbon::now(),
                        'updated_at' => Carbon::now()
                    ]);

                return response()->json([
                    'success' => true,
                    'message' => 'Kabupaten/Kota berhasil dihapus',
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
                $kabkota = DB::table('md_kabkota')
                    ->select('md_kabkota.*', 'md_provinsi.namadagri_prv')
                    ->leftJoin('md_provinsi', 'md_kabkota.kodedagri_prv', '=', 'md_provinsi.kodedagri_prv')
                    ->where('md_kabkota.status_kbk', 0)
                    ->orderBy('md_kabkota.updated_at', 'desc')
                    ->get();

                return response()->json([
                    'success' => true,
                    'message' => 'Data trash berhasil diambil',
                    'data' => $kabkota
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
         * API: Restore kabkota (set status back to 1)
         */
        public function apiRestore($id)
        {
            try {
                $kabkota = DB::table('md_kabkota')
                    ->where('kodedagri_kbk', $id)
                    ->where('status_kbk', 0)
                    ->first();

                if (!$kabkota) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Data kabupaten/kota tidak ditemukan',
                        'data' => null
                    ], 404);
                }

                DB::table('md_kabkota')
                    ->where('kodedagri_kbk', $id)
                    ->update([
                        'status_kbk' => 1,
                        // 'tanggalubah_kbk' => Carbon::now(),
                        'updated_at' => Carbon::now()
                    ]);

                $restoredKabkota = DB::table('md_kabkota')
                    ->select('md_kabkota.*', 'md_provinsi.namadagri_prv')
                    ->leftJoin('md_provinsi', 'md_kabkota.kodedagri_prv', '=', 'md_provinsi.kodedagri_prv')
                    ->where('md_kabkota.kodedagri_kbk', $id)
                    ->first();

                return response()->json([
                    'success' => true,
                    'message' => 'Kabupaten/Kota berhasil dipulihkan',
                    'data' => $restoredKabkota
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
         * API: Get kabkota by province ID
         */
        public function apiGetByProvinsi($provinsiId)
        {
            try {
                $kabkota = DB::table('md_kabkota')
                    ->select('*')
                    ->where('kodedagri_prv', $provinsiId)
                    ->where('status_kbk', 1)
                    ->orderBy('namadagri_kbk', 'asc')
                    ->get();

                return response()->json([
                    'success' => true,
                    'message' => 'Data kabupaten/kota berhasil diambil',
                    'data' => $kabkota
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