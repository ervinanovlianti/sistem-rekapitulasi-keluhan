<?php

namespace App\Http\Controllers;

use App\Models\KeluhanModel;
use Carbon\Carbon;
use Sastrawi\StopWordRemover\StopWordRemoverFactory;
use Sastrawi\Stemmer\StemmerFactory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function index()
    {
        parent::index();
        $idPengguna = Auth::id();
        $dataKeluhan = KeluhanModel::where('id_pengguna', $idPengguna)->orderBy('tgl_keluhan', 'desc')->paginate(10);
        return view('pengguna_jasa/keluhan', compact('dataKeluhan'));
    }

    public function dashboard()
    {
        $idPengguna = Auth::id();

        // Menghitung total keluhan
        $totalKeluhan = KeluhanModel::where('id_pengguna', $idPengguna)->count();

        $keluhanBaru = KeluhanModel::where('id_pengguna', $idPengguna)
            ->where('status_keluhan', 'dialihkan ke cs')
            // ->where('status_keluhan', 'menunggu verifikasi')
            ->count();

        $keluhanDiproses = KeluhanModel::where('id_pengguna', $idPengguna)
            ->where('status_keluhan', 'ditangani oleh cs')
            ->count();

        $keluhanSelesai = KeluhanModel::where('id_pengguna', $idPengguna)
            ->where('status_keluhan', 'selesai')
            ->count();

        date_default_timezone_set("Asia/Makassar");
        $today = date("Y-d-m H:i:s");

        $keluhanHariIni = KeluhanModel::where('id_pengguna', $idPengguna)
            ->whereDate('tgl_keluhan', $today)
            ->get();

        return view('pengguna_jasa/dashboard_pj', compact('totalKeluhan', 'keluhanBaru', 'keluhanDiproses', 'keluhanSelesai', 'keluhanHariIni'));
    }

    public function formInput()
    {
        return view('pengguna_jasa/input_keluhan');
    }

    public function inputKeluhan(Request $request)
    {
        $textkeluhan = DB::table('data_keluhan')
            ->join('data_kategori', 'data_keluhan.kategori_id', '=', 'data_kategori.id_kategori')
            ->select('data_keluhan.*', 'data_kategori.kategori_keluhan')
            ->get();

        // --------------PREPROCESSING DATA LATIH---------------------------
        $processedKeluhan = [];
        foreach ($textkeluhan as $keluhan) {
            $uraianKeluhan = $keluhan->uraian_keluhan;

            // Case Folding
            $text = strtolower($uraianKeluhan);
            $kata = explode(' ', $text); // Memecah kalimat menjadi array kata
            $stopwordRemoverFactory = new StopWordRemoverFactory();
            $stopwordRemover = $stopwordRemoverFactory->createStopWordRemover();
            $textWithoutStopwords = $stopwordRemover->remove($text);
            $cleanedText = preg_replace('/[^\p{L}\s]/u', '', $textWithoutStopwords);
            $cleanedText = preg_replace('/\d+/', '', $cleanedText);
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

        $newKodeKeluhan = "KEL-$bulanTahun-$newNumber";
        $kodePJ = DB::table('users')
            ->where('id', 'like', "CUST%")
            ->orderBy('id', 'desc')
            ->value('id');

        if ($kodePJ) {
            $lastNumberPJ = (int)substr($kodePJ, -4);
            $newNumberPJ = str_pad($lastNumberPJ + 1, 4, '0', STR_PAD_LEFT);
        } else {
            $newNumberPJ = '0001';
        }
        $newKodePJ = "CUST-$newNumberPJ";

        $idKeluhan = $newKodeKeluhan;
        $dataUji = $request->input('uraian_keluhan');

        $textUji = strtolower($dataUji);
        $kataUji = explode(' ', $textUji); // Memecah kalimat menjadi array kata
        $tokenUji = "'" . implode("','", $kataUji) . "'"; // Menggabungkan kata dengan tanda kutip
        $stopwordRemoverFactory = new StopWordRemoverFactory();
        $stopwordRemover = $stopwordRemoverFactory->createStopWordRemover();
        $textWithoutStopwordsUji = $stopwordRemover->remove($textUji);
        $cleanedTextUji = preg_replace('/[^a-zA-Z\s]/', '', $textWithoutStopwordsUji);
        $stemmerFactory = new StemmerFactory();
        $stemmer = $stemmerFactory->createStemmer();
        $stemmedTextUji = $stemmer->stem($cleanedTextUji);
        $stemmedTokensUji = explode(' ', $stemmedTextUji);

        // -----------VEKTORISASI DATA UJI------------
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

        $likehoodKategori = [];

        foreach ($jumlahKataUji as $data) {
            $kata = $data['kata'];
            $likehood_pembayaran = ($data['jumlah_kata_kategori']['Pembayaran'] + 1) / ($totalBobotKataKategori['Pembayaran'] + $totalBobotKataDataLatih);
            $likehood_pengiriman = ($data['jumlah_kata_kategori']['Pengiriman'] + 1) / ($totalBobotKataKategori['Pengiriman'] + $totalBobotKataDataLatih);
            $likehood_penerimaan = ($data['jumlah_kata_kategori']['Penerimaan'] + 1) / ($totalBobotKataKategori['Penerimaan'] + $totalBobotKataDataLatih);
            $likehood_administrasi = ($data['jumlah_kata_kategori']['Administrasi'] + 1) / ($totalBobotKataKategori['Administrasi'] + $totalBobotKataDataLatih);
            $likehood_lainnya = ($data['jumlah_kata_kategori']['Lainnya'] + 1) / ($totalBobotKataKategori['Lainnya'] + $totalBobotKataDataLatih);

            $likehoodKategori[] = [
                'kata' => $kata,
                'Pembayaran' => $likehood_pembayaran,
                'Pengiriman' => $likehood_pengiriman,
                'Penerimaan' => $likehood_penerimaan,
                'Administrasi' => $likehood_administrasi,
                'Lainnya' => $likehood_lainnya,
            ];
            $hasil_perkalian_probabilitas_pembayaran = 1;
            $hasil_perkalian_probabilitas_pengiriman = 1;
            $hasil_perkalian_probabilitas_penerimaan = 1;
            $hasil_perkalian_probabilitas_administrasi = 1;
            $hasil_perkalian_probabilitas_lainnya = 1;
            foreach ($likehoodKategori as $data) {
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

        foreach ($likehoodKategori as $data) {
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
        // Mencari kategori dengan nilai terbesar (hasil akhir maksimum)
        $kategoriTerbesar = '';
        $nilaiTerbesar = 0;
        foreach ($hasilAkhir as $kategori => $hasil) {
            if ($hasil > $nilaiTerbesar) {
                $kategoriTerbesar = $kategori;
                $nilaiTerbesar = $hasil;
            }
        }
        if ($kategoriTerbesar == 'Pembayaran') {
            $idKategori = '1';
        } elseif ($kategoriTerbesar == 'Pengiriman') {
            $idKategori = '2';
        } elseif ($kategoriTerbesar == 'Penerimaan') {
            $idKategori = '3';
        } elseif ($kategoriTerbesar == 'Administrasi') {
            $idKategori = '4';
        } elseif ($kategoriTerbesar == 'Lainnya') {
            $idKategori = '5';
        }

        $request->validate([
            'uraian_keluhan' => 'required|max:280',
            'gambar' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        if ($request->hasFile('gambar')) {
            $gambarKeluhan = $request->file('gambar');
            $gambarName = time() . '_' . $gambarKeluhan->getClientOriginalName();
            $gambarKeluhan->move(public_path('gambar_keluhan'), $gambarName);
        } else {
            $gambarName = null;
        }
        date_default_timezone_set("Asia/Makassar");
        $idPengguna = Auth::id();
        $dataKeluhan = [
            'id_keluhan' => $idKeluhan,
            'tgl_keluhan' => date("Y-m-d H:i:s"),
            'id_pengguna' => $idPengguna,
            'via_keluhan' => 'Web',
            'uraian_keluhan' => $request->input('uraian_keluhan'),
            'kategori_id' => $idKategori,
            'status_keluhan' => 'menunggu verifikasi',
            'gambar' => $gambarName,
        ];
        DB::table('data_keluhan')->insert($dataKeluhan);

        return redirect('data-keluhan');
    }
}
