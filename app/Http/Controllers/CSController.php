<?php

namespace App\Http\Controllers;

use App\Models\KeluhanModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class CSController extends Controller
{
    public function index()
    {
        // Ambil ID pengguna yang sedang login
        $idCS = Auth::id();
        // Ambil data keluhan berdasarkan ID pengguna yang login
        $dataKeluhan = KeluhanModel::where('penanggungjawab', $idCS)
            ->join('data_kategori', 'data_keluhan.kategori_id', '=', 'data_kategori.id_kategori')
            ->join('users', 'data_keluhan.id_pengguna', '=', 'users.id')
            ->select('data_keluhan.*', 'data_kategori.kategori_keluhan', 'users.*')
            ->orderBy('tgl_keluhan', 'desc')
            ->paginate(10);
        // Kirim data ke view untuk ditampilkan
        return view('cs/keluhan', compact('dataKeluhan'));
    }
    function dashboard()
    {
        $idCS = Auth::id();

        // Menghitung total keluhan
        $totalKeluhan = KeluhanModel::where('penanggungjawab', $idCS)->count();
        $keluhanBaru = DB::table('data_keluhan')
            ->where('id_pengguna', $idCS)
            ->where('status_keluhan', 'menunggu verifikasi')
            ->count();
        $keluhanDiproses = KeluhanModel::where('penanggungjawab', $idCS)
            ->where('status_keluhan', 'ditangani oleh cs')
            ->where('status_keluhan', 'dialihkan ke cs')
            ->count();

        $keluhanSelesai = DB::table('data_keluhan')
            ->where('penanggungjawab', $idCS)
            ->where('status_keluhan', 'selesai')
            ->count();
        date_default_timezone_set('Asia/Makassar');

        // Mendapatkan waktu sekarang
        $today = date("Y-m-d H:i:s");

        // Mengambil data keluhan yang tercatat pada hari ini
        $keluhanHariIni = DB::table('data_keluhan')
            ->where('penanggungjawab', $idCS)
            ->where('status_keluhan', 'menunggu verifikasi')
            ->whereDate('tgl_keluhan', $today)
            ->get();

        return view('cs/dashboard_cs', compact('totalKeluhan', 'keluhanBaru', 'keluhanDiproses', 'keluhanSelesai', 'keluhanHariIni'));
    }
    public function detailKeluhan($id)
    {
        $keluhan = DB::table('data_keluhan')
            ->join('data_kategori', 'data_keluhan.kategori_id', '=', 'data_kategori.id_kategori')
            ->join('users', 'data_keluhan.id_pengguna', '=', 'users.id')
            ->select('data_keluhan.*', 'data_kategori.kategori_keluhan', 'users.*')
            ->where('data_keluhan.id_keluhan', $id)
            ->first();
        $cs = DB::table('users')
            ->where('hak_akses', 'customer_service')
            ->get();

        return view('detail_keluhan', compact('keluhan', 'cs'));
    }
    public function terimaKeluhan($id)
    {
        $keluhan = DB::table('data_keluhan')->where('id_keluhan', $id)->first();
        if ($keluhan) {
            DB::table('data_keluhan')
                ->where('id_keluhan', $id)
                ->update([
                    'status_keluhan' => 'ditangani oleh cs',
                    'penanggungjawab' => 'CS 1',
                ]);
            return redirect()->back()->with('success', 'Keluhan sedang ditangan CS.');
        } else {
            return redirect()->back()->with('error', 'Keluhan tidak ditemukan.');
        }
    }
}
