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

            // Ambil data keluhan yang telah diproses
            // $processedKeluhan = $stemmedTokens;

            // Inisialisasi variabel untuk menyimpan jumlah kata dalam setiap kategori
            $wordCount = [];

            // Iterasi melalui setiap keluhan yang telah diproses
            foreach ($processedKeluhan as $keluhan) {
                $kategori = $keluhan['kategori_keluhan'];
                $tokens = $keluhan['tokens'];

                // Periksa apakah kategori sudah ada dalam $wordCount
                if (!isset($wordCount[$kategori])) {
                    $wordCount[$kategori] = [];
                }

                // Iterasi melalui setiap token dalam keluhan dan tingkatkan jumlah kata
                foreach ($tokens as $token) {
                    if (!isset($wordCount[$kategori][$token])) {
                        $wordCount[$kategori][$token] = 1;
                    } else {
                        $wordCount[$kategori][$token]++;
                    }
                }
            }

            // Menyusun data dengan format yang diinginkan
            $formattedData = [];
            foreach ($wordCount as $kategori => $kataJumlah) {
                $index = 1;
                foreach ($kataJumlah as $kata => $jumlah) {
                    $formattedData[] = [
                        'kategori' => $kategori,
                        'kata' => $kata,
                        'jumlah' => $jumlah,
                        'index' => $index,
                    ];
                    $index++;
                }
            }

            // Tampilkan hasil perhitungan jumlah kata dalam setiap kategori
            // dd($wordCount);
        }
        return view('perhitungan_naivebayes', compact('processedKeluhan','formattedData'));
    }

 public function calculateWordCount()
    {
        // Ambil dataset yang telah diproses dan dikategorikan
        $dataset = DB::table('data_keluhan')
        ->join('data_kategori', 'data_keluhan.kategori_id', '=', 'data_kategori.id_kategori')
        ->select('data_keluhan.id_keluhan', 'data_keluhan.uraian_keluhan', 'data_kategori.kategori_keluhan')
        ->get();

        // Inisialisasi variabel untuk menyimpan jumlah kata dalam setiap kategori
        $wordCount = [];

        // Iterasi melalui setiap keluhan dalam dataset
        foreach ($dataset as $keluhan) {
            $kategori = $keluhan->kategori_keluhan;
            $tokens = explode(' ', $keluhan->uraian_keluhan);

            // Periksa apakah kategori sudah ada dalam $wordCount
            if (!isset($wordCount[$kategori])) {
                $wordCount[$kategori] = [];
            }

            // Iterasi melalui setiap token dalam keluhan dan tingkatkan jumlah kata
            foreach ($tokens as $token) {
                if (!isset($wordCount[$kategori][$token])) {
                    $wordCount[$kategori][$token] = 1;
                } else {
                    $wordCount[$kategori][$token]++;
                }
            }
        }

        // Tampilkan hasil perhitungan jumlah kata dalam setiap kategori
        dd($wordCount);
    }
    
}
