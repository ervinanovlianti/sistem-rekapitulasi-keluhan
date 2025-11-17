<?php

namespace App\Http\Controllers;

use App\Models\Keluhan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CSController extends Controller
{
    public function index()
    {
        parent::index();
        $idCS = Auth::id();
        $dataKeluhan = Keluhan::where('penanggungjawab', $idCS)
            ->join('data_kategori', 'data_keluhan.kategori_id', '=', 'data_kategori.id_kategori')
            ->join('users', 'data_keluhan.id_pengguna', '=', 'users.id')
            ->select('data_keluhan.*', 'data_kategori.kategori_keluhan', 'users.*')
            ->orderBy('tgl_keluhan', 'desc')
            ->paginate(10);

        return view('cs/keluhan', compact('dataKeluhan'));
    }

    public function dashboard(): View
    {
        $idCS = Auth::id();
        $totalKeluhan = Keluhan::where('penanggungjawab', $idCS)->count();
        $keluhanBaru = DB::table('data_keluhan')
            ->where('penanggungjawab', $idCS)
            ->where('status_keluhan', 'dialihkan ke cs')
            ->count();
        $keluhanDiproses = Keluhan::where('penanggungjawab', $idCS)
            ->where('status_keluhan', 'ditangani oleh cs')
            ->count();
        $keluhanSelesai = DB::table('data_keluhan')
            ->where('penanggungjawab', $idCS)
            ->where('status_keluhan', 'selesai')
            ->count();
        date_default_timezone_set('Asia/Makassar');
        $keluhanHariIni = DB::table('data_keluhan')
            ->where('penanggungjawab', $idCS)
            ->where('status_keluhan', 'dialihkan ke cs')
            ->get();

        return view('cs/dashboard_cs', compact('totalKeluhan', 'keluhanBaru', 'keluhanDiproses', 'keluhanSelesai', 'keluhanHariIni'));
    }
}
