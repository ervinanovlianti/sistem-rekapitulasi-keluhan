<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Services\NaiveBayesService;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function index()
    {
        $data_keluhan = DB::table('data_keluhan')
            ->join('data_kategori', 'data_keluhan.kategori_id', '=', 'data_kategori.id_kategori')
            ->select('data_keluhan.*', 'data_kategori.kategori_keluhan')
            ->get();

        return view('data_keluhan', compact('data_keluhan'));
    }

    public function preprocessing(Request $request)
    {
        $dataUji = $request->input('data_uji');
        if (!$dataUji) {
            return view('perhitungan_naivebayes')->with('error', 'Data uji belum diisi');
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
        $kategoriCount = [];
        foreach ($processedKeluhan as $keluhan) {
            $kategori = $keluhan['kategori_keluhan'];
            $kategoriCount[$kategori] = ($kategoriCount[$kategori] ?? 0) + 1;
        }
        $totalKeluhan = count($processedKeluhan);

        $hasilProbabilitas = $probabilitas;
        $hasilPerkalianProbabilitas = [];
        foreach ($hasilAkhir as $kategori => $nilai) {
            $hasilPerkalianProbabilitas[$kategori] = $nilai / ($probabilitas[$kategori] ?: 1);
        }
        $kategoriList = array_keys($probabilitas);

        $textUji = strtolower($dataUji);
        $tokenUji = "'" . implode("','", explode(' ', $textUji)) . "'";
        $cleanedTextUji = $textUji;
        $stemmedTextUji = implode(' ', $stemmedTokensUji);
        $jumlahKataUji = $likehoodKategori;

        return view('perhitungan_naivebayes', compact(
            'processedKeluhan',
            'formattedTotalWordCount',
            'dataUji',
            'textUji',
            'tokenUji',
            'cleanedTextUji',
            'stemmedTextUji',
            'stemmedTokensUji',
            'probabilitas',
            'kategoriCount',
            'totalKeluhan',
            'jumlahKataUji',
            'totalBobotKataKategori',
            'totalBobotKataDataLatih',
            'likehoodKategori',
            'hasilPerkalianProbabilitas',
            'hasilAkhir',
            'kategoriTerbesar',
            'kategoriList',
            'hasilProbabilitas'
        ));
    }

    public function showForm()
    {
        return view('perhitungan_naivebayes');
    }
}
