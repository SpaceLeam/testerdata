<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = DB::table('md_menu')
            ->select('*')
            ->where('status_mnu', 1) // Hanya tampilkan data dengan status aktif
            ->orderBy('id_mnu', 'desc');

        // Search functionality
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_mnu', 'ILIKE', "%{$search}%")
                  ->orWhere('akses_mnu', 'ILIKE', "%{$search}%")
                  ->orWhere('id_mnu', 'ILIKE', "%{$search}%");
            });
        }

        $menu = $query->paginate(10);

        return view('menu.index', compact('menu'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('menu.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_mnu' => 'required|string|max:255',
            'akses_mnu' => 'required|string|max:255'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            DB::table('md_menu')->insert([
                'nama_mnu' => $request->nama_mnu,
                'akses_mnu' => $request->akses_mnu,
                'status_mnu' => 1, // Status aktif saat dibuat
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);

            return redirect()->route('menu.index')
                ->with('success', 'Menu berhasil ditambahkan');
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
        $menu = DB::table('md_menu')
            ->where('id_mnu', $id)
            ->where('status_mnu', 1)
            ->first();

        if (!$menu) {
            return redirect()->route('menu.index')
                ->with('error', 'Data menu tidak ditemukan');
        }

        return view('menu.show', compact('menu'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $menu = DB::table('md_menu')
            ->where('id_mnu', $id)
            ->where('status_mnu', 1)
            ->first();

        if (!$menu) {
            return redirect()->route('menu.index')
                ->with('error', 'Data menu tidak ditemukan');
        }

        return view('menu.edit', compact('menu'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama_mnu' => 'required|string|max:255',
            'akses_mnu' => 'required|string|max:255'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $menu = DB::table('md_menu')
                ->where('id_mnu', $id)
                ->where('status_mnu', 1)
                ->first();

            if (!$menu) {
                return redirect()->route('menu.index')
                    ->with('error', 'Data menu tidak ditemukan');
            }

            DB::table('md_menu')
                ->where('id_mnu', $id)
                ->update([
                    'nama_mnu' => $request->nama_mnu,
                    'akses_mnu' => $request->akses_mnu,
                    'updated_at' => Carbon::now()
                ]);

            return redirect()->route('menu.index')
                ->with('success', 'Menu berhasil diperbarui');
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
            $menu = DB::table('md_menu')
                ->where('id_mnu', $id)
                ->where('status_mnu', 1)
                ->first();

            if (!$menu) {
                return redirect()->route('menu.index')
                    ->with('error', 'Data menu tidak ditemukan');
            }

            // Set status menjadi 0 (tidak aktif/dihapus)
            DB::table('md_menu')
                ->where('id_mnu', $id)
                ->update([
                    'status_mnu' => 0,
                    'updated_at' => Carbon::now()
                ]);

            return redirect()->route('menu.index')
                ->with('success', 'Menu berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Get all menu data for API or AJAX
     */
    public function getData()
    {
        $menu = DB::table('md_menu')
            ->select('*')
            ->where('status_mnu', 1)
            ->orderBy('id_mnu', 'desc')
            ->get();

        return response()->json($menu);
    }

    /**
     * Restore menu (Set status back to 1)
     */
    public function restore($id)
    {
        try {
            $menu = DB::table('md_menu')
                ->where('id_mnu', $id)
                ->where('status_mnu', 0)
                ->first();

            if (!$menu) {
                return redirect()->route('menu.trash')
                    ->with('error', 'Data menu tidak ditemukan');
            }

            DB::table('md_menu')
                ->where('id_mnu', $id)
                ->update([
                    'status_mnu' => 1,
                    'updated_at' => Carbon::now()
                ]);

            return redirect()->route('menu.trash')
                ->with('success', 'Menu berhasil dipulihkan');
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
        $menu = DB::table('md_menu')
            ->select('*')
            ->where('status_mnu', 0)
            ->orderBy('updated_at', 'desc')
            ->paginate(10);

        return view('menu.trash', compact('menu'));
    }

    /**
     * Permanent delete menu
     */
    public function forceDelete($id)
    {
        try {
            // Validasi ID
            if (!is_numeric($id)) {
                return redirect()->route('menu.trash')
                    ->with('error', 'ID menu tidak valid');
            }

            $menu = DB::table('md_menu')
                ->where('id_mnu', $id)
                ->where('status_mnu', 0)
                ->first();

            if (!$menu) {
                return redirect()->route('menu.trash')
                    ->with('error', 'Data menu tidak ditemukan');
            }

            DB::table('md_menu')
                ->where('id_mnu', $id)
                ->delete();

            return redirect()->route('menu.trash')
                ->with('success', 'Menu berhasil dihapus permanen');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }


    /**
 * Empty all trash (delete all menu with status 0)
 */
public function emptyTrash()
{
    try {
        $deletedCount = DB::table('md_menu')
            ->where('status_mnu', 0)
            ->delete();

        if ($deletedCount > 0) {
            return redirect()->route('menu.trash')
                ->with('success', "Successfully deleted {$deletedCount} menu items permanently");
        } else {
            return redirect()->route('menu.trash')
                ->with('error', 'No items found in trash');
        }
    } catch (\Exception $e) {
        return redirect()->back()
            ->with('error', 'Error occurred: ' . $e->getMessage());
    }
}   

    // ===== REST API METHODS =====

    /**
     * API: Get all menu data
     */
    public function apiIndex(Request $request)
    {
        try {
            $query = DB::table('md_menu')
                ->select('*')
                ->where('status_mnu', 1)
                ->orderBy('id_mnu', 'desc');

            // Search functionality
            if ($request->has('search') && !empty($request->search)) {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->where('nama_mnu', 'ILIKE', "%{$search}%")
                      ->orWhere('akses_mnu', 'ILIKE', "%{$search}%")
                      ->orWhere('id_mnu', 'ILIKE', "%{$search}%");
                });
            }

            $menu = $query->get();

            return response()->json([
                'success' => true,
                'message' => 'Data menu berhasil diambil',
                'data' => $menu
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
     * API: Get menu by ID
     */
    public function apiShow($id)
    {
        try {
            $menu = DB::table('md_menu')
                ->where('id_mnu', $id)
                ->where('status_mnu', 1)
                ->first();

            if (!$menu) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data menu tidak ditemukan',
                    'data' => null
                ], 404);
            }

            return response()->json([
                'success' => true,
                'message' => 'Data menu berhasil diambil',
                'data' => $menu
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
     * API: Store new menu
     */
    public function apiStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_mnu' => 'required|string|max:255',
            'akses_mnu' => 'required|string|max:255'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $id = DB::table('md_menu')->insertGetId([
                'nama_mnu' => $request->nama_mnu,
                'akses_mnu' => $request->akses_mnu,
                'status_mnu' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);

            // Get the inserted record
            $menu = DB::table('md_menu')
                ->where('id_mnu', $id)
                ->first();

            return response()->json([
                'success' => true,
                'message' => 'Menu berhasil ditambahkan',
                'data' => $menu
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
     * API: Update menu
     */
    public function apiUpdate(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama_mnu' => 'required|string|max:255',
            'akses_mnu' => 'required|string|max:255'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $menu = DB::table('md_menu')
                ->where('id_mnu', $id)
                ->where('status_mnu', 1)
                ->first();

            if (!$menu) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data menu tidak ditemukan',
                    'data' => null
                ], 404);
            }

            DB::table('md_menu')
                ->where('id_mnu', $id)
                ->update([
                    'nama_mnu' => $request->nama_mnu,
                    'akses_mnu' => $request->akses_mnu,
                    'updated_at' => Carbon::now()
                ]);

            $updatedMenu = DB::table('md_menu')
                ->where('id_mnu', $id)
                ->first();

            return response()->json([
                'success' => true,
                'message' => 'Menu berhasil diperbarui',
                'data' => $updatedMenu
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
     * API: Delete menu (set status to 0)
     */
    public function apiDestroy($id)
    {
        try {
            $menu = DB::table('md_menu')
                ->where('id_mnu', $id)
                ->where('status_mnu', 1)
                ->first();

            if (!$menu) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data menu tidak ditemukan',
                    'data' => null
                ], 404);
            }

            // Set status menjadi 0
            DB::table('md_menu')
                ->where('id_mnu', $id)
                ->update([
                    'status_mnu' => 0,
                    'updated_at' => Carbon::now()
                ]);

            return response()->json([
                'success' => true,
                'message' => 'Menu berhasil dihapus',
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
            $menu = DB::table('md_menu')
                ->select('*')
                ->where('status_mnu', 0)
                ->orderBy('updated_at', 'desc')
                ->get();

            return response()->json([
                'success' => true,
                'message' => 'Data trash berhasil diambil',
                'data' => $menu
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
     * API: Restore menu (set status back to 1)
     */
    public function apiRestore($id)
    {
        try {
            $menu = DB::table('md_menu')
                ->where('id_mnu', $id)
                ->where('status_mnu', 0)
                ->first();

            if (!$menu) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data menu tidak ditemukan',
                    'data' => null
                ], 404);
            }

            DB::table('md_menu')
                ->where('id_mnu', $id)
                ->update([
                    'status_mnu' => 1,
                    'updated_at' => Carbon::now()
                ]);

            $restoredMenu = DB::table('md_menu')
                ->where('id_mnu', $id)
                ->first();

            return response()->json([
                'success' => true,
                'message' => 'Menu berhasil dipulihkan',
                'data' => $restoredMenu
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