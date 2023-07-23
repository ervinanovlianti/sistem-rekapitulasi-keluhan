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
        $data_penggunajasa = DB::table('data_pengguna_jasa')->get();

        return view('data_penggunajasa', compact('data_penggunajasa'));
    }
    public function showInputForm()
    {
        return view('input_keluhan');
    }
}
