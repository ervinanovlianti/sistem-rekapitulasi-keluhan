<?php

namespace App\Http\Controllers;

use App\Models\KeluhanModel;
use Carbon\Carbon;
use Illuminate\Support\Collection as SupportCollection;
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
        $totalKeluhan = $this->getTotalKeluhan($idPengguna);
        $keluhanBaru = $this->getKeluhanBaru($idPengguna);
        $keluhanDiproses = $this->getKeluhanDiproses($idPengguna);
        $keluhanSelesai = $this->getKeluhanSelesai($idPengguna);
        $keluhanHariIni = $this->getKeluhanHariIni($idPengguna);

        return view('pengguna_jasa/dashboard_pj', compact('totalKeluhan', 'keluhanBaru', 'keluhanDiproses', 'keluhanSelesai', 'keluhanHariIni'));
    }

    private function getTotalKeluhan($idPengguna)
    {
        return KeluhanModel::where('id_pengguna', $idPengguna)->count();
    }

    private function getKeluhanBaru($idPengguna)
    {
        return KeluhanModel::where('id_pengguna', $idPengguna)
            ->where('status_keluhan', 'dialihkan ke cs')
            ->count();
    }

    private function getKeluhanDiproses($idPengguna)
    {
        return KeluhanModel::where('id_pengguna', $idPengguna)
            ->where('status_keluhan', 'ditangani oleh cs')
            ->count();
    }

    private function getKeluhanSelesai($idPengguna)
    {
        return KeluhanModel::where('id_pengguna', $idPengguna)
            ->where('status_keluhan', 'selesai')
            ->count();
    }

    private function getKeluhanHariIni($idPengguna)
    {
        date_default_timezone_set("Asia/Makassar");
        $today = date("Y-m-d");

        return KeluhanModel::where('id_pengguna', $idPengguna)
            ->whereDate('tgl_keluhan', $today)
            ->get();
    }

    public function formInput()
    {
        return view('pengguna_jasa/input_keluhan');
    }

    public function inputKeluhan(Request $request)
    {
        $request->validate([
            'uraian_keluhan' => 'required|max:280',
            'gambar' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $trainingData = $this->getTrainingData();
        $processedKeluhan = $this->preprocessTrainingData($trainingData);
        $wordCountData = $this->calculateWordCounts($processedKeluhan);
        $probabilitas = $this->calculateCategoryProbabilities($processedKeluhan);
        $stemmedTokens = $this->preprocessText($request->input('uraian_keluhan'));
        $idKategori = $this->classifyComplaint($stemmedTokens, $wordCountData, $probabilitas);
        $idKeluhan = $this->generateKeluhanId();
        $gambarName = $this->handleImageUpload($request);

        $this->saveComplaintData($idKeluhan, $request->input('uraian_keluhan'), $idKategori, $gambarName);

        return redirect('data-keluhan');
    }

    private function getTrainingData(): SupportCollection
    {
        return DB::table('data_keluhan')
            ->join('data_kategori', 'data_keluhan.kategori_id', '=', 'data_kategori.id_kategori')
            ->select('data_keluhan.*', 'data_kategori.kategori_keluhan')
            ->get();
    }

    /**
     * Preprocess training data
     */
    private function preprocessTrainingData($textkeluhan)
    {
        $processedKeluhan = [];

        foreach ($textkeluhan as $keluhan) {
            $stemmedTokens = $this->preprocessText($keluhan->uraian_keluhan);

            $processedKeluhan[] = [
                'uraian_keluhan' => $keluhan->uraian_keluhan,
                'tokens' => $stemmedTokens,
                'kategori_keluhan' => $keluhan->kategori_keluhan,
            ];
        }

        return $processedKeluhan;
    }

    /**
     * Preprocess text: case folding, stopword removal, cleaning, and stemming
     */
    private function preprocessText($text)
    {
        // Case folding
        $text = strtolower($text);

        // Stopword removal
        $stopwordRemoverFactory = new StopWordRemoverFactory();
        $stopwordRemover = $stopwordRemoverFactory->createStopWordRemover();
        $textWithoutStopwords = $stopwordRemover->remove($text);

        // Cleaning: remove special characters and numbers
        $cleanedText = preg_replace('/[^\p{L}\s]/u', '', $textWithoutStopwords);
        $cleanedText = preg_replace('/\d+/', '', $cleanedText);

        // Stemming
        $stemmerFactory = new StemmerFactory();
        $stemmer = $stemmerFactory->createStemmer();
        $stemmedText = $stemmer->stem($cleanedText);

        return explode(' ', $stemmedText);
    }

    /**
     * Calculate word counts per category
     */
    private function calculateWordCounts($processedKeluhan)
    {
        $wordCount = [];

        // Count words per category
        foreach ($processedKeluhan as $keluhan) {
            $kategori = $keluhan['kategori_keluhan'];
            $tokens = $keluhan['tokens'];

            if (!isset($wordCount[$kategori])) {
                $wordCount[$kategori] = [];
            }

            foreach ($tokens as $token) {
                if (empty($token)) continue;

                if (!isset($wordCount[$kategori][$token])) {
                    $wordCount[$kategori][$token] = 0;
                }
                $wordCount[$kategori][$token]++;
            }
        }

        // Format total word count
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
                    ];
                }
                $totalWordCount[$kata][$kategori] = $jumlah;
            }
        }

        return [
            'totalWordCount' => $totalWordCount,
            'wordCount' => $wordCount
        ];
    }

    /**
     * Calculate category probabilities (prior probabilities)
     */
    private function calculateCategoryProbabilities($processedKeluhan)
    {
        $kategoriCount = [];
        $totalKeluhan = count($processedKeluhan);

        foreach ($processedKeluhan as $keluhan) {
            $kategori = $keluhan['kategori_keluhan'];

            if (!isset($kategoriCount[$kategori])) {
                $kategoriCount[$kategori] = 0;
            }
            $kategoriCount[$kategori]++;
        }

        $probabilitas = [];
        foreach ($kategoriCount as $kategori => $count) {
            $probabilitas[$kategori] = $count / $totalKeluhan;
        }

        return $probabilitas;
    }

    /**
     * Classify complaint using Naive Bayes
     */
    private function classifyComplaint($stemmedTokens, $wordCountData, $probabilitas)
    {
        $totalWordCount = $wordCountData['totalWordCount'];

        // Calculate total word count per category
        $totalBobotKataKategori = $this->calculateTotalWordCountPerCategory($totalWordCount);
        $totalBobotKataDataLatih = array_sum($totalBobotKataKategori);

        // Calculate likelihood for each word in test data
        $likelihoodKategori = $this->calculateLikelihood($stemmedTokens, $totalWordCount, $totalBobotKataKategori, $totalBobotKataDataLatih);

        // Calculate final probabilities
        $hasilAkhir = $this->calculateFinalProbabilities($likelihoodKategori, $probabilitas);

        // Find category with highest probability
        $kategoriTerbesar = $this->findMaxCategory($hasilAkhir);

        return $this->mapCategoryToId($kategoriTerbesar);
    }

    /**
     * Calculate total word count per category
     */
    private function calculateTotalWordCountPerCategory($totalWordCount)
    {
        $totalBobotKataKategori = [
            'Pembayaran' => 0,
            'Pengiriman' => 0,
            'Penerimaan' => 0,
            'Administrasi' => 0,
            'Lainnya' => 0,
        ];

        foreach ($totalWordCount as $kata => $bobot) {
            foreach ($totalBobotKataKategori as $kategori => $value) {
                $totalBobotKataKategori[$kategori] += isset($bobot[$kategori]) ? $bobot[$kategori] : 0;
            }
        }

        return $totalBobotKataKategori;
    }

    /**
     * Calculate likelihood for each word and category
     */
    private function calculateLikelihood($stemmedTokens, $totalWordCount, $totalBobotKataKategori, $totalBobotKataDataLatih)
    {
        $likelihoodKategori = [];

        foreach ($stemmedTokens as $kata) {
            if (empty($kata)) continue;

            $likelihoodKategori[] = [
                'kata' => $kata,
                'Pembayaran' => (($totalWordCount[$kata]['Pembayaran'] ?? 0) + 1) / ($totalBobotKataKategori['Pembayaran'] + $totalBobotKataDataLatih),
                'Pengiriman' => (($totalWordCount[$kata]['Pengiriman'] ?? 0) + 1) / ($totalBobotKataKategori['Pengiriman'] + $totalBobotKataDataLatih),
                'Penerimaan' => (($totalWordCount[$kata]['Penerimaan'] ?? 0) + 1) / ($totalBobotKataKategori['Penerimaan'] + $totalBobotKataDataLatih),
                'Administrasi' => (($totalWordCount[$kata]['Administrasi'] ?? 0) + 1) / ($totalBobotKataKategori['Administrasi'] + $totalBobotKataDataLatih),
                'Lainnya' => (($totalWordCount[$kata]['Lainnya'] ?? 0) + 1) / ($totalBobotKataKategori['Lainnya'] + $totalBobotKataDataLatih),
            ];
        }

        return $likelihoodKategori;
    }

    /**
     * Calculate final probabilities by multiplying likelihoods with prior probabilities
     */
    private function calculateFinalProbabilities($likelihoodKategori, $probabilitas)
    {
        $hasilPerkalianProbabilitas = [
            'Pembayaran' => 1,
            'Pengiriman' => 1,
            'Penerimaan' => 1,
            'Administrasi' => 1,
            'Lainnya' => 1,
        ];

        foreach ($likelihoodKategori as $data) {
            foreach ($hasilPerkalianProbabilitas as $kategori => $value) {
                $hasilPerkalianProbabilitas[$kategori] *= $data[$kategori];
            }
        }

        $hasilAkhir = [];
        foreach ($hasilPerkalianProbabilitas as $kategori => $hasil) {
            $hasilAkhir[$kategori] = $hasil * ($probabilitas[$kategori] ?? 0);
        }

        return $hasilAkhir;
    }

    /**
     * Find category with maximum probability
     */
    private function findMaxCategory($hasilAkhir)
    {
        $kategoriTerbesar = '';
        $nilaiTerbesar = 0;

        foreach ($hasilAkhir as $kategori => $hasil) {
            if ($hasil > $nilaiTerbesar) {
                $kategoriTerbesar = $kategori;
                $nilaiTerbesar = $hasil;
            }
        }

        return $kategoriTerbesar;
    }

    /**
     * Map category name to category ID
     */
    private function mapCategoryToId($kategori)
    {
        $categoryMap = [
            'Pembayaran' => '1',
            'Pengiriman' => '2',
            'Penerimaan' => '3',
            'Administrasi' => '4',
            'Lainnya' => '5',
        ];

        return $categoryMap[$kategori] ?? '5';
    }

    /**
     * Generate new complaint ID
     */
    private function generateKeluhanId()
    {
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

        return "KEL-$bulanTahun-$newNumber";
    }

    /**
     * Handle image upload
     * @return string|null
     */
    private function handleImageUpload(Request $request): ?string
    {
        if ($request->hasFile('gambar')) {
            /** @var \Illuminate\Http\UploadedFile|null $gambarKeluhan */
            $gambarKeluhan = $request->file('gambar');
            if ($gambarKeluhan && $gambarKeluhan->isValid()) {
                $gambarName = time() . '_' . $gambarKeluhan->getClientOriginalName();
                $gambarKeluhan->move(public_path('gambar_keluhan'), $gambarName);
                return $gambarName;
            }
        }

        return null;
    }

    /**
     * Save complaint data to database
     */
    private function saveComplaintData($idKeluhan, $uraianKeluhan, $idKategori, $gambarName)
    {
        date_default_timezone_set("Asia/Makassar");
        $idPengguna = Auth::id();

        $dataKeluhan = [
            'id_keluhan' => $idKeluhan,
            'tgl_keluhan' => date("Y-m-d H:i:s"),
            'id_pengguna' => $idPengguna,
            'via_keluhan' => 'Web',
            'uraian_keluhan' => $uraianKeluhan,
            'kategori_id' => $idKategori,
            'status_keluhan' => 'menunggu verifikasi',
            'gambar' => $gambarName,
        ];

        DB::table('data_keluhan')->insert($dataKeluhan);
    }
}
