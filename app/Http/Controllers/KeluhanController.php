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
            ->select('data_keluhan.*', 'data_kategori.kategori_keluhan')
            ->get();

        return view('data_keluhan', compact('data_keluhan'));
    }
    public function showInputForm()
    {
        return view('input_keluhan');
    }
    function store(Request $request) {
        $dataKeluhan = KeluhanModel::create([
            'tgl_keluhan' => $request->input('tgl_keluhan'),
            'id_pengguna'    => $request->input('id_pengguna'),
            'via_keluhan'     => $request->input('via_keluhan'),
            'uraian_keluhan'   => $request->input('uraian_keluhan'),
            // 'jenis_costumer'  => $request->input('jenis_costumer'),
            // 'nama_perusahaan' => $request->input('nama_perusahaan'),
            // 'nomor_telepon'   => $request->input('nomor_telepon'),
        ]);
        // simpan gambar jika ada
        // if ($request->hasFile('file_gambar')) {
        //     $file = $request->file('file_gambar');
            
        //     // simpan gambar ke dalam storage dengan nama unik
        //     $path = $file->store('public/gambar');

        //     // simpan path gambar ke dalam database
        //     $dataKeluhan->file_gambar= $path;
        //     $dataKeluhan->save();
        // }

        return redirect('keluhan')->with('success', 'Data keluhan berhasil disimpan!');
    }
}
