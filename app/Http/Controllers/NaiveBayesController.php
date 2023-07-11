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

        // -----------------------------------------------------------------
        // ------PREPROCESSING DATA LATIH-----------------------------------
        // -----------------------------------------------------------------
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
            // Menggabungkan jumlah bobot kata dari setiap kategori
            $totalWordCount = [];
            foreach ($wordCount as $kategori => $kataJumlah) {
                foreach ($kataJumlah as $kata => $jumlah) {
                    if (!isset($totalWordCount[$kata])) {
                        $totalWordCount[$kata] = [
                            'Pembayaran' => 0,
                            'Pengiriman' => 0,
                            'Penerimaan' => 0,
                            'Administrasi' => 0,
                            'Lainnya' => 0,
                            'total' => 0,
                        ];
                    }
                    // Menambahkan bobot kata ke total bobot
                    $totalWordCount[$kata][$kategori] += $jumlah;
                    $totalWordCount[$kata]['total'] += $jumlah;
                }
            }
            // Menyusun data dengan format yang diinginkan
            $formattedTotalWordCount = [];
            $index = 1;
            foreach ($totalWordCount as $kata => $bobot) {
                $formattedTotalWordCount[] = [
                    'index' => $index,
                    'kata' => $kata,
                    'Pembayaran' => $bobot['Pembayaran'],
                    'Pengiriman' => $bobot['Pengiriman'],
                    'Penerimaan' => $bobot['Penerimaan'],
                    'Administrasi' => $bobot['Administrasi'],
                    'Lainnya' => $bobot['Lainnya'],
                    'total' => $bobot['total'],
                ];
                $index++;
            }
        }
        // -----------------------------------------------------------------
        // ---------------------PROBABILITAS PRIOR--------------------------
        // -----------------------------------------------------------------

        // Menghitung jumlah setiap kategori
        $kategoriCount = [];
        $totalKeluhan = count($processedKeluhan);

        foreach ($processedKeluhan as $keluhan) {
            $kategori = $keluhan['kategori_keluhan'];

            if (!isset($kategoriCount[$kategori])) {
                $kategoriCount[$kategori] = 1;
            } else {
                $kategoriCount[$kategori]++;
            }
        }

        // Menghitung jumlah seluruh kategori
        $totalKategori = count($kategoriCount);

        // Menghitung probabilitas
        $probabilitas = [];

        foreach ($kategoriCount as $kategori => $count) {
            $probabilitas[$kategori] = $count / $totalKeluhan;
        }

        // -----------------------------------------------------------------
        // ---------------------PREPROCESSING DATA UJI----------------------
        // -----------------------------------------------------------------

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

        // -----------------------------------------------------------------
        // ----------------------VEKTORISASI DATA UJI-----------------------
        // -----------------------------------------------------------------

        // Menghitung jumlah kata pada data uji yang sama dengan kata pada data latih
        $jumlahKataUji = [];

        foreach ($stemmedTokensUji as $kataUji) {
            $jumlahKataUji[] = [
                'kata' => $kataUji,
                'jumlah_kata_uji' => 1, // Setiap kata pada data uji hanya muncul satu kali
                'jumlah_kata_kategori' => [
                    'Pembayaran' => isset($totalWordCount[$kataUji]['Pembayaran']) ? $totalWordCount[$kataUji]['Pembayaran'] : 0,
                    'Pengiriman' => isset($totalWordCount[$kataUji]['Pengiriman']) ? $totalWordCount[$kataUji]['Pengiriman'] : 0,
                    'Penerimaan' => isset($totalWordCount[$kataUji]['Penerimaan']) ? $totalWordCount[$kataUji]['Penerimaan'] : 0,
                    'Administrasi' => isset($totalWordCount[$kataUji]['Administrasi']) ? $totalWordCount[$kataUji]['Administrasi'] : 0,
                    'Lainnya' => isset($totalWordCount[$kataUji]['Lainnya']) ? $totalWordCount[$kataUji]['Lainnya'] : 0,
                ],
            ];
            
        }
        // Inisialisasi variabel untuk menyimpan total bobot kata untuk setiap kategori
        $totalBobotKataKategori = [
            'Pembayaran' => 0,
            'Pengiriman' => 0,
            'Penerimaan' => 0,
            'Administrasi' => 0,
            'Lainnya' => 0,
        ];
        // Iterasi melalui setiap kata pada data latih
        foreach ($formattedTotalWordCount as $kata) {
            $totalBobotKataKategori['Pembayaran'] += $kata['Pembayaran'];
            $totalBobotKataKategori['Pengiriman'] += $kata['Pengiriman'];
            $totalBobotKataKategori['Penerimaan'] += $kata['Penerimaan'];
            $totalBobotKataKategori['Administrasi'] += $kata['Administrasi'];
            $totalBobotKataKategori['Lainnya'] += $kata['Lainnya'];
        }
        // Menghitung total bobot kata pada data latih
        $totalBobotKataDataLatih = array_sum($totalBobotKataKategori);

// BELUM FIX
        // foreach ($jumlahKataUji as $ujidata) {
        //     $probabilitas_pembayaran = ($ujidata['jumlah_kata_kategori']['Pembayaran'] + 1) / ($totalBobotKataKategori['Pembayaran'] + $totalBobotKataDataLatih);
        // }
        // 
        // $likehood = [
        //     'Pembayaran' => 0,
        //     'Pengiriman' => 0,
        //     'Penerimaan' => 0,
        //     'Administrasi' => 0,
        //     'Lainnya' => 0,
        // ];
        // Iterasi melalui setiap kata pada data latih
        // foreach ($formattedTotalWordCount as $kata) {
        //     $likehood['Pembayaran'] += $kata['Pembayaran'];
        //     $likehood['Pengiriman'] += $kata['Pengiriman'];
        //     $likehood['Penerimaan'] += $kata['Penerimaan'];
        //     $likehood['Administrasi'] += $kata['Administrasi'];
        //     $likehood['Lainnya'] += $kata['Lainnya'];
        // }

        // // Menampilkan hasil klasifikasi
        // if (!empty($klasifikasi)) {
        //     $hasilKlasifikasi = $klasifikasi[1];
        // } else {
        //     $hasilKlasifikasi = 'Tidak Diketahui';
        // }
 

        return view('perhitungan_naivebayes', 
        compact(
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
                'hasilKlasifikasi',
                // 'probabilitas_pembayaran',
        ));
    }

    public function showForm()
    {
        return view('perhitungan_naivebayes');
    }
}
