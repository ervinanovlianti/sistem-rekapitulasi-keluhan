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
    public function preprocessing(Request $request)
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

        $dataUji = $request->input('data_uji');

        // Case Folding
        $textUji = strtolower($dataUji);

        // Tokenizing
        $kataUji = explode(' ', $textUji); // Memecah kalimat menjadi array kata
        $tokenUji = "'" . implode("','", $kataUji) . "'"; // Menggabungkan kata dengan tanda kutip

        // Stopword Removal
        $stopwordRemoverFactory = new StopWordRemoverFactory();
        $stopwordRemover = $stopwordRemoverFactory->createStopWordRemover();
        $textWithoutStopwordsUji = $stopwordRemover->remove($textUji);

        // Menghapus karakter khusus, simbol, dan angka
        $cleanedTextUji = preg_replace('/[^a-zA-Z\s]/', '', $textWithoutStopwordsUji);

        // Stemming
        $stemmerFactory = new StemmerFactory();
        $stemmer = $stemmerFactory->createStemmer();
        $stemmedTextUji = $stemmer->stem($cleanedTextUji);

        // Memperbarui variabel $stemmedTokens menjadi array
        $stemmedTokensUji = explode(' ', $stemmedTextUji);


        return view('perhitungan_naivebayes', compact('processedKeluhan','formattedData','dataUji','textUji','tokenUji','cleanedTextUji','stemmedTextUji'));
    }

    public function showForm()
    {
        return view('perhitungan_naivebayes');
    }

    public function prosesDataUji(Request $request)
    {
        $dataUji = $request->input('data_uji');

        // Case Folding
        $text = strtolower($dataUji);

        // Tokenizing
        $kata = explode(' ', $text); // Memecah kalimat menjadi array kata
        $kataTerkutip = "'" . implode("','", $kata) . "'"; // Menggabungkan kata dengan tanda kutip

        // Stopword Removal
        $stopwordRemoverFactory = new StopWordRemoverFactory();
        $stopwordRemover = $stopwordRemoverFactory->createStopWordRemover();
        $textWithoutStopwords = $stopwordRemover->remove($text);

        // Menghapus karakter khusus, simbol, dan angka
        $cleanedText = preg_replace('/[^a-zA-Z\s]/', '', $textWithoutStopwords);

        // Stemming
        $stemmerFactory = new StemmerFactory();
        $stemmer = $stemmerFactory->createStemmer();
        $stemmedText = $stemmer->stem($cleanedText);

        // Memperbarui variabel $stemmedTokens menjadi array
        $stemmedTokens = explode(' ', $stemmedText);

        return view('perhitungan_naivebayes', compact('text', 'kataTerkutip','cleanedText', 'stemmedTokens'));
        // Tampilkan hasil
        // dd($stemmedTokens);
    }
}
