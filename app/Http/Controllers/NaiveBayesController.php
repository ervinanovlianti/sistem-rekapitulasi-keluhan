<?php

namespace App\Http\Controllers;

use App\Models\KeluhanModel;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Services\NaiveBayesService;

class NaiveBayesController extends Controller
{
    public function preprocessing(Request $request)
    {
        $dataUji = $request->input('uraian_keluhan');
        if (!$dataUji) {
            return view('perhitungan_naivebayes')->with('error', 'Uraian keluhan belum diisi');
        }

        $service = new NaiveBayesService();
        $result = $service->classify($dataUji);

        $processedKeluhan = $result['processedKeluhan'];
        $formattedTotalWordCount = $result['formattedTotalWordCount'];
        $probabilitas = $result['probabilitas'];
        $stemmedTokensUji = $result['tokensUji'];
        $totalBobotKataKategori = $result['totalBobotKataKategori'];
        $totalBobotKataDataLatih = $result['totalBobotKataDataLatih'];
        $likehoodKategori = $result['likelihoodKategori'];
        $hasilAkhir = $result['hasilAkhir'];
        $kategoriTerbesar = $result['kategoriTerbesar'];
        $kategoriId = $result['kategoriId'];

        $kategoriCount = [];
        foreach ($processedKeluhan as $keluhan) {
            $kategoriCount[$keluhan['kategori_keluhan']] = ($kategoriCount[$keluhan['kategori_keluhan']] ?? 0) + 1;
        }
        $totalKeluhan = count($processedKeluhan);

        $textUji = strtolower($dataUji);
        $tokenUji = "'" . implode("','", explode(' ', $textUji)) . "'";
        $stemmedTextUji = implode(' ', $stemmedTokensUji);
        $cleanedTextUji = $textUji; // sudah dibersihkan di service
        $jumlahKataUji = $likehoodKategori;

        return view('perhitungan_naivebayes', compact(
            'processedKeluhan',
            'formattedTotalWordCount',
            'probabilitas',
            'kategoriCount',
            'totalKeluhan',
            'dataUji',
            'textUji',
            'tokenUji',
            'stemmedTextUji',
            'stemmedTokensUji',
            'cleanedTextUji',
            'totalBobotKataKategori',
            'totalBobotKataDataLatih',
            'likehoodKategori',
            'jumlahKataUji',
            'hasilAkhir',
            'kategoriTerbesar',
            'kategoriId'
        ));
    }

    public function saveDataToDatabase(Request $request)
    {
        $request->validate([
            'nama' => 'required|string',
            'email' => 'required|unique:users|email',
            'no_telepon' => 'required',
            'jenis_pengguna' => 'required|string',
            'via_keluhan' => 'required',
            'uraian_keluhan' => 'required|max:280',
        ]);

        UserModel::create([
            'id' => $request->input('id'),
            'nama' => $request->input('nama'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('nama')),
            'no_telepon' => $request->input('no_telepon'),
            'jenis_pengguna' => $request->input('jenis_pengguna'),
            'hak_akses' => $request->input('hak_akses')
        ]);

        date_default_timezone_set('Asia/Makassar');
        $tglKeluhan = date('Y-m-d H:i:s');
        KeluhanModel::create([
            'id_keluhan' => $request->input('id_keluhan'),
            'tgl_keluhan' => $tglKeluhan,
            'id_pengguna' => $request->input('id'),
            'via_keluhan' => $request->input('via_keluhan'),
            'uraian_keluhan' => $request->input('uraian_keluhan'),
            'kategori_id' => $request->input('kategori_id'),
            'status_keluhan' => $request->input('status_keluhan'),
        ]);

        return redirect('keluhan');
    }

    public function showForm()
    {
        return view('perhitungan_naivebayes');
    }
}
