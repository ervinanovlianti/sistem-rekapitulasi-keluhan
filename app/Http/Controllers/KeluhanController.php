<?php

namespace App\Http\Controllers;

use App\Models\KeluhanModel;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

class KeluhanController extends Controller
{
    public function index()
    {
        $data_keluhan = DB::table('data_keluhan')
            ->join('data_kategori', 'data_keluhan.kategori_id', '=', 'data_kategori.id_kategori')
            ->join('data_pengguna_jasa', 'data_keluhan.id_pengguna', '=', 'data_pengguna_jasa.id_pengguna')
            ->select('data_keluhan.*', 'data_kategori.kategori_keluhan', 'data_pengguna_jasa.nama')
            ->orderBy('tgl_keluhan', 'desc')
            ->get();

        return view('data_keluhan', compact('data_keluhan'));
    }
    public function dataPenggunaJasa()
    {
        $data_penggunajasa = DB::table('data_pengguna_jasa')
        ->where('hak_akses', 'pengguna_jasa')
        ->get();

        return view('data_penggunajasa', compact('data_penggunajasa'));
    }
    public function dataCS()
    {
        $data_cs = DB::table('data_pengguna_jasa')
        ->where('hak_akses', 'customer_service')
        ->get();

        return view('data_cs', compact('data_cs'));
    }
    public function showInputForm()
    {
        return view('input_keluhan');
    }
    
    public function detailKeluhan($id)
    {
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
            DB::table('data_keluhan')->where('id_keluhan', $id)->update(['status_keluhan' => 'ditangani oleh cs']);

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
            DB::table('data_keluhan')->where('id_keluhan', $id)->update(['status_keluhan' => 'selesai']);

            // Redirect kembali ke halaman data keluhan dengan pesan sukses
            return redirect('keluhan')->with('success', 'Keluhan telah ditangan CS.');
        } else {
            // Jika data keluhan tidak ditemukan, redirect kembali ke halaman data keluhan dengan pesan error
            return redirect('keluhan')->with('error', 'Keluhan tidak ditemukan.');
        }
    }
}