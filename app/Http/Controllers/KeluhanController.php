<?php

namespace App\Http\Controllers;

use App\Models\KeluhanModel;
use App\Models\PenggunaJasaModel;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

use Illuminate\Http\Request;

class KeluhanController extends Controller
{
    public function index(){
        $data_keluhan = DB::table('data_keluhan')
            ->join('data_kategori', 'data_keluhan.kategori_id', '=', 'data_kategori.id_kategori')
            ->join('data_pengguna_jasa', 'data_keluhan.id_pengguna', '=', 'data_pengguna_jasa.id_pengguna')
            ->select('data_keluhan.*', 'data_kategori.kategori_keluhan', 'data_pengguna_jasa.nama')
            ->orderBy('tgl_keluhan', 'desc')
            ->get();

        return view('data_keluhan', compact('data_keluhan'));
    }
    public function laporan() {
        $keluhan = DB::table('data_keluhan')
            ->join('data_kategori', 'data_keluhan.kategori_id', '=', 'data_kategori.id_kategori')
            ->join('data_pengguna_jasa', 'data_keluhan.id_pengguna', '=', 'data_pengguna_jasa.id_pengguna')
            ->select('data_keluhan.*', 'data_kategori.kategori_keluhan', 'data_pengguna_jasa.nama')
            ->orderBy('tgl_keluhan', 'desc')
            ->get();
        

        return view('laporan', compact('keluhan'));
    }
    function dashboard()  {
        // Menghitung total keluhan
        $totalKeluhan = KeluhanModel::count();
        $keluhanBaru = DB::table('data_keluhan')
        ->where('status_keluhan', 'menunggu verifikasi')
        ->count();
        $keluhanDiproses = DB::table('data_keluhan')
        ->where('status_keluhan', 'ditangani oleh cs')
        ->orWhere('status_keluhan', 'dialihkan ke cs')
        ->count();
        $keluhanSelesai = DB::table('data_keluhan')
        ->where('status_keluhan', 'selesai')
        ->count();
        date_default_timezone_set('Asia/Makassar');

        // Mendapatkan waktu sekarang
        $today = date('d/m/y');

        // Mengambil data keluhan yang tercatat pada hari ini
        $keluhanHariIni = DB::table('data_keluhan')
        ->whereDate('tgl_keluhan', $today)
        ->get();

        return view('dashboard', compact('totalKeluhan', 'keluhanBaru', 'keluhanDiproses','keluhanSelesai','keluhanHariIni'));
    }
    public function dataPenggunaJasa()
    {
        $data_penggunajasa = DB::table('data_pengguna_jasa')
        ->where('hak_akses', 'pengguna_jasa')
        ->get();

        return view('data_penggunajasa', compact('data_penggunajasa'));
    }
    public function dataCS() {
        $data_cs = DB::table('data_pengguna_jasa')
        ->where('hak_akses', 'customer_service')
        ->get();

        return view('data_cs', compact('data_cs'));
    }
    public function showInputForm(){
        return view('input_keluhan');
    }
    public function formInputDataCS(){
        return view('input_datacs');
    }
    public function inputDataCS(Request $request)
    {
        // Simpan data pelanggan ke dalam database
        $lastCS = DB::table('data_pengguna_jasa')
        ->where('id_pengguna', 'like', "CS%")
        ->orderBy('id_pengguna', 'desc')
        ->value('id_pengguna');

        if ($lastCS) {
            // Jika sudah ada kode keluhan pada bulan dan tahun yang sama, ambil nomor urut terakhir
            $lastNumberCS = (int) substr($lastCS, -1);
            $newNumberCS = str_pad($lastNumberCS + 1, 1, '0', STR_PAD_LEFT);
        } else {
            // Jika belum ada kode keluhan pada bulan dan tahun yang sama, nomor urut dimulai dari 1
            $newNumberCS = '01';
        }
        $newKodeCS = "CS-$newNumberCS";
        // return $newKodeKeluhan;
        $dataPelanggan = [
            'id_pengguna' => $newKodeCS,
            'nama' => $request->input('nama'),
            'username' => $request->input('username'),
            'email' => $request->input('email'),
            'password' => $request->input('password'),
            'no_telepon' => $request->input('no_telepon'),
            'jenis_pengguna' => 'Customer Service',
            'hak_akses' => 'customer_service',
        ];

        DB::table('data_pengguna_jasa')->insert($dataPelanggan);

        // Redirect ke halaman sebelumnya dengan pesan sukses
        return redirect('cs');
    }
    
    public function detailKeluhan($id) {
        $keluhan = DB::table('data_keluhan')
        ->join('data_kategori', 'data_keluhan.kategori_id', '=', 'data_kategori.id_kategori')
        ->join('data_pengguna_jasa', 'data_keluhan.id_pengguna', '=', 'data_pengguna_jasa.id_pengguna')
        ->select('data_keluhan.*', 'data_kategori.kategori_keluhan', 'data_pengguna_jasa.nama')
        ->where('data_keluhan.id_keluhan', $id)
        ->first();

        return view('detail_keluhan', compact('keluhan'));
    }
    public function verifikasiKeluhan($id){
        // Cari data keluhan berdasarkan ID
        $keluhan = DB::table('data_keluhan')->where('id_keluhan', $id)->first();

        // Jika data keluhan ditemukan
        if ($keluhan) {
            // Lakukan update status keluhan menjadi "Terverifikasi"
            DB::table('data_keluhan')->where('id_keluhan', $id)->update(['status_keluhan' => 'dialihkan ke cs']);

            // Redirect kembali ke halaman data keluhan dengan pesan sukses
            return redirect('keluhan')->with('success', 'Keluhan telah diverifikasi.');
        } else {
            // Jika data keluhan tidak ditemukan, redirect kembali ke halaman data keluhan dengan pesan error
            return redirect('keluhan')->with('error', 'Keluhan tidak ditemukan.');
        }
    }
    public function terimaKeluhan($id){
        // Cari data keluhan berdasarkan ID
        $keluhan = DB::table('data_keluhan')->where('id_keluhan', $id)->first();

        // Jika data keluhan ditemukan
        if ($keluhan) {
            // Lakukan update status keluhan menjadi "Terverifikasi"
            DB::table('data_keluhan')
            ->where('id_keluhan', $id)
            ->update([
                'status_keluhan' => 'ditangani oleh cs',
                'penanggungjawab' => 'CS 1',
            ]);

            // Redirect kembali ke halaman data keluhan dengan pesan sukses
            return redirect('keluhan')->with('success', 'Keluhan telah ditangan CS.');
        } else {
            // Jika data keluhan tidak ditemukan, redirect kembali ke halaman data keluhan dengan pesan error
            return redirect('keluhan')->with('error', 'Keluhan tidak ditemukan.');
        }
    }
    public function keluhanSelesai($id){
        // Cari data keluhan berdasarkan ID
        $keluhan = DB::table('data_keluhan')->where('id_keluhan', $id)->first();

        // Jika data keluhan ditemukan
        if ($keluhan) {
            // Lakukan update status keluhan menjadi "Terverifikasi"
            DB::table('data_keluhan')
            ->where('id_keluhan', $id)
            ->update([
                'status_keluhan' => 'selesai',
                'waktu_penyelesaian' => Carbon::now(),
            ]);

            // Redirect kembali ke halaman data keluhan dengan pesan sukses
            return redirect('keluhan')->with('success', 'Keluhan telah ditangan CS.');
        } else {
            // Jika data keluhan tidak ditemukan, redirect kembali ke halaman data keluhan dengan pesan error
            return redirect('keluhan')->with('error', 'Keluhan tidak ditemukan.');
        }
    }
}