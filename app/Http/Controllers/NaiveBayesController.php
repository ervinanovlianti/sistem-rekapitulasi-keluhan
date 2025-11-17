<?php

namespace App\Http\Controllers;

use App\Models\KeluhanModel;
use App\Models\UserModel;
use Sastrawi\StopWordRemover\StopWordRemoverFactory;
use Sastrawi\Stemmer\StemmerFactory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;


use Illuminate\Support\Str;
use Carbon\Carbon;

class NaiveBayesController extends Controller
{
    public function preprocessing(Request $request)
    {
        parent::preprocessing($request);
        $textkeluhan = DB::table('data_keluhan')
            ->join('data_kategori', 'data_keluhan.kategori_id', '=', 'data_kategori.id_kategori')
            ->select('data_keluhan.*', 'data_kategori.kategori_keluhan')
            ->get();

        // --------------PREPROCESSING DATA LATIH--------------------
        $processedKeluhan = [];
        foreach ($textkeluhan as $keluhan) {
            $uraianKeluhan = $keluhan->uraian_keluhan;

            $text = strtolower($uraianKeluhan);
            $stopwordRemoverFactory = new StopWordRemoverFactory();
            $stopwordRemover = $stopwordRemoverFactory->createStopWordRemover();
            $textWithoutStopwords = $stopwordRemover->remove($text);
            $cleanedText = preg_replace('/[^\p{L}\s]/u', '', $textWithoutStopwords);

            // Stemming
            $stemmerFactory = new StemmerFactory();
            $stemmer = $stemmerFactory->createStemmer();
            $stemmedText = $stemmer->stem($cleanedText);
            $stemmedTokens = explode(' ', $stemmedText);

            $processedKeluhan[] = [
                'uraian_keluhan' => $uraianKeluhan,
                'preprocessed_tokens' => $stemmedText,
                'tokens' => $stemmedTokens,
                'kategori_keluhan' => $keluhan->kategori_keluhan,
            ];

            $wordCount = [];
            foreach ($processedKeluhan as $keluhan) {
                $kategori = $keluhan['kategori_keluhan'];
                $tokens = $keluhan['tokens'];
                if (!isset($wordCount[$kategori])) {
                    $wordCount[$kategori] = [];
                }
                foreach ($tokens as $token) {
                    if (!isset($wordCount[$kategori][$token])) {
                        $wordCount[$kategori][$token] = 1;
                    } else {
                        $wordCount[$kategori][$token]++;
                    }
                }
            }

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
                    $totalWordCount[$kata][$kategori] += $jumlah;
                    $totalWordCount[$kata]['total'] += $jumlah;
                }
            }
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

        // --------------PROBABILITAS PRIOR--------------------------
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
        $probabilitas = [];
        foreach ($kategoriCount as $kategori => $count) {
            $probabilitas[$kategori] = $count / $totalKeluhan;
        }

        // -----------------PREPROCESSING DATA UJI------------------
        $bulanTahun = date('my');
        $lastCode = DB::table('data_keluhan')
            ->where('id_keluhan', 'like', "KEL-$bulanTahun%")
            ->orderBy('id_keluhan', 'desc')
            ->value('id_keluhan');

        if ($lastCode) {
            $lastNumber = (int)substr($lastCode, -5);
            $newNumber = str_pad($lastNumber + 1, 5, '0', STR_PAD_LEFT);
        } else {
            $newNumber = '00001';
        }
        $newKodeKeluhan = "KEL-{$bulanTahun}-{$newNumber}";

        $kodePJ = DB::table('users')
            ->where('id', 'like', "2%")
            ->orderBy('id', 'desc')
            ->value('id');
        if ($kodePJ) {
            $lastNumberPJ = (int)substr($kodePJ, -4);
            $newNumberPJ = str_pad($lastNumberPJ + 1, 4, '0', STR_PAD_LEFT);
        } else {
            $newNumberPJ = '0001';
        }
        $newKodePJ = "2$newNumberPJ";

        date_default_timezone_set('Asia/Makassar');
        $idKeluhan = $newKodeKeluhan;
        $tglKeluhan = date('d/m/y H:i:s');
        $idPengguna = $newKodePJ;
        $namaPengguna = $request->input('nama');
        $email = $request->input('email');
        $noTelepon = $request->input('no_telepon');
        $jenisPengguna = $request->input('jenis_pengguna');
        $hakAkses = 'pengguna_jasa';
        $statusKeluhan = 'menunggu verifikasi admin';
        $viaKeluhan = $request->input('via_keluhan');
        $dataUji = $request->input('uraian_keluhan');

        // --------PREPROCESSING DATA UJI-------------
        // 1. Case Folding
        $textUji = strtolower($dataUji);
        // 2. Tokenizing
        $kataUji = explode(' ', $textUji);
        $tokenUji = "'" . implode("','", $kataUji) . "'";
        // 3. Menghapus Stopword
        $stopwordRemoverFactory = new StopWordRemoverFactory();
        $stopwordRemover = $stopwordRemoverFactory->createStopWordRemover();
        $textWithoutStopwordsUji = $stopwordRemover->remove($textUji);
        $cleanedTextUji = preg_replace('/[^a-zA-Z\s]/', '', $textWithoutStopwordsUji);
        // 4. Stemming
        $stemmerFactory = new StemmerFactory();
        $stemmer = $stemmerFactory->createStemmer();
        $stemmedTextUji = $stemmer->stem($cleanedTextUji);
        $stemmedTokensUji = explode(' ', $stemmedTextUji);

        // -----------VEKTORISASI DATA UJI------------
        $jumlahKataUji = [];

        foreach ($stemmedTokensUji as $kataUji) {
            $jumlahKataUji[] = [
                'kata' => $kataUji,
                'jumlah_kata_uji' => 1,
                'jumlah_kata_kategori' => [
                    'Pembayaran' => isset($totalWordCount[$kataUji]['Pembayaran']) ? $totalWordCount[$kataUji]['Pembayaran'] : 0,
                    'Pengiriman' => isset($totalWordCount[$kataUji]['Pengiriman']) ? $totalWordCount[$kataUji]['Pengiriman'] : 0,
                    'Penerimaan' => isset($totalWordCount[$kataUji]['Penerimaan']) ? $totalWordCount[$kataUji]['Penerimaan'] : 0,
                    'Administrasi' => isset($totalWordCount[$kataUji]['Administrasi']) ? $totalWordCount[$kataUji]['Administrasi'] : 0,
                    'Lainnya' => isset($totalWordCount[$kataUji]['Lainnya']) ? $totalWordCount[$kataUji]['Lainnya'] : 0,
                ],
            ];
        }
        $totalBobotKataKategori = [
            'Pembayaran' => 0,
            'Pengiriman' => 0,
            'Penerimaan' => 0,
            'Administrasi' => 0,
            'Lainnya' => 0,
        ];
        foreach ($formattedTotalWordCount as $kata) {
            $totalBobotKataKategori['Pembayaran'] += $kata['Pembayaran'];
            $totalBobotKataKategori['Pengiriman'] += $kata['Pengiriman'];
            $totalBobotKataKategori['Penerimaan'] += $kata['Penerimaan'];
            $totalBobotKataKategori['Administrasi'] += $kata['Administrasi'];
            $totalBobotKataKategori['Lainnya'] += $kata['Lainnya'];
        }
        $totalBobotKataDataLatih = array_sum($totalBobotKataKategori);

        $likelihoodKategori = [];

        foreach ($jumlahKataUji as $data) {
            $kata = $data['kata'];
            $likelihood_pembayaran = ($data['jumlah_kata_kategori']['Pembayaran'] + 1) / ($totalBobotKataKategori['Pembayaran'] + $totalBobotKataDataLatih);
            $likelihood_pengiriman = ($data['jumlah_kata_kategori']['Pengiriman'] + 1) / ($totalBobotKataKategori['Pengiriman'] + $totalBobotKataDataLatih);
            $likelihood_penerimaan = ($data['jumlah_kata_kategori']['Penerimaan'] + 1) / ($totalBobotKataKategori['Penerimaan'] + $totalBobotKataDataLatih);
            $likelihood_administrasi = ($data['jumlah_kata_kategori']['Administrasi'] + 1) / ($totalBobotKataKategori['Administrasi'] + $totalBobotKataDataLatih);
            $likelihood_lainnya = ($data['jumlah_kata_kategori']['Lainnya'] + 1) / ($totalBobotKataKategori['Lainnya'] + $totalBobotKataDataLatih);

            $likelihoodKategori[] = [
                'kata' => $kata,
                'Pembayaran' => $likelihood_pembayaran,
                'Pengiriman' => $likelihood_pengiriman,
                'Penerimaan' => $likelihood_penerimaan,
                'Administrasi' => $likelihood_administrasi,
                'Lainnya' => $likelihood_lainnya,
            ];
            $hasil_perkalian_probabilitas_pembayaran = 1;
            $hasil_perkalian_probabilitas_pengiriman = 1;
            $hasil_perkalian_probabilitas_penerimaan = 1;
            $hasil_perkalian_probabilitas_administrasi = 1;
            $hasil_perkalian_probabilitas_lainnya = 1;
            foreach ($likelihoodKategori as $data) {
                $hasil_perkalian_probabilitas_pembayaran *= $data['Pembayaran'];
                $hasil_perkalian_probabilitas_pengiriman *= $data['Pengiriman'];
                $hasil_perkalian_probabilitas_penerimaan *= $data['Penerimaan'];
                $hasil_perkalian_probabilitas_administrasi *= $data['Administrasi'];
                $hasil_perkalian_probabilitas_lainnya *= $data['Lainnya'];
            }
        }

        $kategoriList = array_keys($probabilitas);

        $hasilProbabilitas = [];
        foreach ($probabilitas as $kategori => $prob) {
            $hasilProbabilitas[$kategori] = $prob;
        }

        $hasilPerkalianProbabilitas = [
            'Pembayaran' => 1,
            'Pengiriman' => 1,
            'Penerimaan' => 1,
            'Administrasi' => 1,
            'Lainnya' => 1,
        ];

        foreach ($likelihoodKategori as $data) {
            $kata = $data['kata'];
            $hasilPerkalianProbabilitas['Pembayaran'] *= $data['Pembayaran'];
            $hasilPerkalianProbabilitas['Pengiriman'] *= $data['Pengiriman'];
            $hasilPerkalianProbabilitas['Penerimaan'] *= $data['Penerimaan'];
            $hasilPerkalianProbabilitas['Administrasi'] *= $data['Administrasi'];
            $hasilPerkalianProbabilitas['Lainnya'] *= $data['Lainnya'];
        }

        $hasilAkhir = [];
        foreach ($hasilPerkalianProbabilitas as $kategori => $hasil) {
            $hasilAkhir[$kategori] = $hasil * $probabilitas[$kategori];
        }
        $kategoriTerbesar = '';
        $nilaiTerbesar = 0;
        foreach ($hasilAkhir as $kategori => $hasil) {
            if ($hasil > $nilaiTerbesar) {
                $kategoriTerbesar = $kategori;
                $nilaiTerbesar = $hasil;
            }
        }

        return view('perhitungan_naivebayes',
            compact(
                'processedKeluhan',
                'formattedTotalWordCount',
                'idKeluhan',
                'tglKeluhan',
                'idPengguna',
                'namaPengguna',
                'email',
                'noTelepon',
                'jenisPengguna',
                'hakAkses',
                'viaKeluhan',
                'statusKeluhan',
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
                'likelihoodKategori',
                'hasil_perkalian_probabilitas_pembayaran',
                'hasil_perkalian_probabilitas_pengiriman',
                'hasil_perkalian_probabilitas_penerimaan',
                'hasil_perkalian_probabilitas_administrasi',
                'hasil_perkalian_probabilitas_lainnya',
                'kategoriList', 'hasilProbabilitas', 'hasilPerkalianProbabilitas', 'hasilAkhir',
                'kategoriTerbesar',
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
