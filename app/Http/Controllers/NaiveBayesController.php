<?php

namespace App\Http\Controllers;

use App\Models\KeluhanModel;
use Sastrawi\StopWordRemover\StopWordRemoverFactory;
use Sastrawi\Stemmer\StemmerFactory;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NaiveBayesController extends Controller
{
    public function index()
    {
        $data_keluhan = DB::table('data_keluhan')
        ->join('data_kategori', 'data_keluhan.kategori_id', '=', 'data_kategori.id_kategori')
        ->select('data_keluhan.*', 'data_kategori.kategori_keluhan')
        ->get();

        return view('data_keluhan', compact('data_keluhan'));
    }
    public function preprocessing()
    {
        $textkeluhan = DB::table('data_keluhan')
        ->join('data_kategori', 'data_keluhan.kategori_id', '=', 'data_kategori.id_kategori')
        ->select('data_keluhan.*', 'data_kategori.kategori_keluhan')
        ->get();

        $processedKeluhan = [];

        foreach ($textkeluhan as $keluhan) {
            $uraianKeluhan = $keluhan->uraian_keluhan;

            $complaintText = $uraianKeluhan;
            // Case Folding
            $text = strtolower($complaintText);

            $kata = explode(' ', $text); // Memecah kalimat menjadi array kata
            $kataTerkutip = "'" . implode("','", $kata) . "'"; // Menggabungkan kata dengan tanda kutip


            // Stopword Removal
            $stopwordRemoverFactory = new StopWordRemoverFactory();
            $stopwordRemover = $stopwordRemoverFactory->createStopWordRemover();
            $textWithoutStopwords = $stopwordRemover->remove($text);
            // Menghapus karakter khusus, simbol, dan angka
             $cleanedText = preg_replace('/[^\p{L}\s]/u', '', $textWithoutStopwords);
             $cleanedText = preg_replace('/\d+/', '', $cleanedText);

            // Menghapus angka, karakter khusus, dan simbol
            // $cleanedText = preg_replace('/[^a-zA-Z\s]/', '', $textWithoutStopwords); 

            // Stemming
            $stemmerFactory = new StemmerFactory();
            $stemmer = $stemmerFactory->createStemmer();
            $stemmedText = $stemmer->stem($cleanedText);
            // Memperbarui variabel $stemmedTokens menjadi array
            $stemmedTokens = explode(' ', $stemmedText);

            $processedKeluhan[] = [
                'uraian_keluhan' => $uraianKeluhan,
                'preprocessed_tokens' => $stemmedText,
                'tokens' => $stemmedTokens,
                'kategori_keluhan' => $keluhan->kategori_keluhan,
            ];
        }
        // return $stemmedText;

        return view('perhitungan_naivebayes', compact('processedKeluhan'));
    }


}
