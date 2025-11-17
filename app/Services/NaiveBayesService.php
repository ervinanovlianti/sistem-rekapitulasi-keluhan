<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Sastrawi\StopWordRemover\StopWordRemoverFactory;
use Sastrawi\Stemmer\StemmerFactory;

class NaiveBayesService
{
    /**
     * Ambil data latih keluhan beserta kategori.
     */
    public function getTrainingData()
    {
        return DB::table('data_keluhan')
            ->join('data_kategori', 'data_keluhan.kategori_id', '=', 'data_kategori.id_kategori')
            ->select('data_keluhan.*', 'data_kategori.kategori_keluhan')
            ->get();
    }

    /**
     * Preprocess seluruh data latih menjadi array token per entri.
     */
    public function preprocessTrainingData($textKeluhan)
    {
        $processed = [];
        foreach ($textKeluhan as $keluhan) {
            $tokens = $this->preprocessText($keluhan->uraian_keluhan);
            $processed[] = [
                'uraian_keluhan' => $keluhan->uraian_keluhan,
                'tokens' => $tokens,
                'kategori_keluhan' => $keluhan->kategori_keluhan,
            ];
        }
        return $processed;
    }

    /**
     * Preprocess single text (case folding, stopword removal, cleaning, stemming)
     */
    public function preprocessText(string $text): array
    {
        $text = strtolower($text);
        $stopwordRemoverFactory = new StopWordRemoverFactory();
        $stopwordRemover = $stopwordRemoverFactory->createStopWordRemover();
        $textWithoutStopwords = $stopwordRemover->remove($text);
        $cleanedText = preg_replace('/[^\p{L}\s]/u', '', $textWithoutStopwords);
        $cleanedText = preg_replace('/\d+/', '', $cleanedText);
        $stemmerFactory = new StemmerFactory();
        $stemmer = $stemmerFactory->createStemmer();
        $stemmedText = $stemmer->stem($cleanedText);
        $tokens = array_filter(explode(' ', $stemmedText));
        return array_values($tokens);
    }

    /**
     * Hitung word count per kategori dan total per kata.
     */
    public function calculateWordCounts(array $processed): array
    {
        $wordCount = [];
        foreach ($processed as $row) {
            $kategori = $row['kategori_keluhan'];
            if (!isset($wordCount[$kategori])) {
                $wordCount[$kategori] = [];
            }
            foreach ($row['tokens'] as $token) {
                if ($token === '') continue;
                $wordCount[$kategori][$token] = ($wordCount[$kategori][$token] ?? 0) + 1;
            }
        }

        $totalWordCount = [];
        foreach ($wordCount as $kategori => $tokens) {
            foreach ($tokens as $kata => $jumlah) {
                if (!isset($totalWordCount[$kata])) {
                    $totalWordCount[$kata] = [
                        'Pembayaran' => 0,
                        'Pengiriman' => 0,
                        'Penerimaan' => 0,
                        'Administrasi' => 0,
                        'Lainnya' => 0,
                    ];
                }
                $totalWordCount[$kata][$kategori] = $jumlah; // overwrite counts per kategori
            }
        }

        // Format mirip struktur sebelumnya untuk tampilan jika diperlukan
        $formatted = [];
        $i = 1;
        foreach ($totalWordCount as $kata => $bobot) {
            $formatted[] = [
                'index' => $i++,
                'kata' => $kata,
                'Pembayaran' => $bobot['Pembayaran'] ?? 0,
                'Pengiriman' => $bobot['Pengiriman'] ?? 0,
                'Penerimaan' => $bobot['Penerimaan'] ?? 0,
                'Administrasi' => $bobot['Administrasi'] ?? 0,
                'Lainnya' => $bobot['Lainnya'] ?? 0,
                'total' => array_sum($bobot),
            ];
        }

        return [
            'wordCount' => $wordCount,
            'totalWordCount' => $totalWordCount,
            'formattedTotalWordCount' => $formatted,
        ];
    }

    /**
     * Probabilitas prior kategori.
     */
    public function calculateCategoryProbabilities(array $processed): array
    {
        $kategoriCount = [];
        foreach ($processed as $row) {
            $kategoriCount[$row['kategori_keluhan']] = ($kategoriCount[$row['kategori_keluhan']] ?? 0) + 1;
        }
        $total = count($processed);
        if ($total === 0) return [];
        $prob = [];
        foreach ($kategoriCount as $kategori => $count) {
            $prob[$kategori] = $count / $total;
        }
        return $prob;
    }

    /**
     * Total bobot kata per kategori.
     */
    public function calculateTotalWordCountPerCategory(array $totalWordCount): array
    {
        $total = [
            'Pembayaran' => 0,
            'Pengiriman' => 0,
            'Penerimaan' => 0,
            'Administrasi' => 0,
            'Lainnya' => 0,
        ];
        foreach ($totalWordCount as $kata => $counts) {
            foreach ($total as $kategori => $v) {
                $total[$kategori] += ($counts[$kategori] ?? 0);
            }
        }
        return $total;
    }

    /**
     * Likelihood tiap kata.
     */
    public function calculateLikelihood(array $tokens, array $totalWordCount, array $totalBobotKataKategori, int $totalBobotKataDataLatih): array
    {
        $likelihood = [];
        foreach ($tokens as $kata) {
            $likelihood[] = [
                'kata' => $kata,
                'Pembayaran' => (($totalWordCount[$kata]['Pembayaran'] ?? 0) + 1) / ($totalBobotKataKategori['Pembayaran'] + $totalBobotKataDataLatih),
                'Pengiriman' => (($totalWordCount[$kata]['Pengiriman'] ?? 0) + 1) / ($totalBobotKataKategori['Pengiriman'] + $totalBobotKataDataLatih),
                'Penerimaan' => (($totalWordCount[$kata]['Penerimaan'] ?? 0) + 1) / ($totalBobotKataKategori['Penerimaan'] + $totalBobotKataDataLatih),
                'Administrasi' => (($totalWordCount[$kata]['Administrasi'] ?? 0) + 1) / ($totalBobotKataKategori['Administrasi'] + $totalBobotKataDataLatih),
                'Lainnya' => (($totalWordCount[$kata]['Lainnya'] ?? 0) + 1) / ($totalBobotKataKategori['Lainnya'] + $totalBobotKataDataLatih),
            ];
        }
        return $likelihood;
    }

    /**
     * Final posterior probability.
     */
    public function calculateFinalProbabilities(array $likelihoodKategori, array $prior): array
    {
        $hasilPerkalian = [
            'Pembayaran' => 1,
            'Pengiriman' => 1,
            'Penerimaan' => 1,
            'Administrasi' => 1,
            'Lainnya' => 1,
        ];
        foreach ($likelihoodKategori as $row) {
            foreach ($hasilPerkalian as $kategori => $val) {
                $hasilPerkalian[$kategori] *= $row[$kategori];
            }
        }
        $hasilAkhir = [];
        foreach ($hasilPerkalian as $kategori => $val) {
            $hasilAkhir[$kategori] = $val * ($prior[$kategori] ?? 0);
        }
        return $hasilAkhir;
    }

    /**
     * Ambil kategori dengan nilai maksimum.
     */
    public function findMaxCategory(array $hasilAkhir): string
    {
        $maxKategori = '';
        $maxVal = -1;
        foreach ($hasilAkhir as $kategori => $val) {
            if ($val > $maxVal) {
                $maxVal = $val;
                $maxKategori = $kategori;
            }
        }
        return $maxKategori;
    }

    /**
     * Mapping ke ID.
     */
    public function mapCategoryToId(string $kategori): string
    {
        $map = [
            'Pembayaran' => '1',
            'Pengiriman' => '2',
            'Penerimaan' => '3',
            'Administrasi' => '4',
            'Lainnya' => '5',
        ];
        return $map[$kategori] ?? '5';
    }

    /**
     * Klasifikasi satu teks keluhan - mengembalikan detail lengkap.
     */
    public function classify(string $text): array
    {
        $training = $this->getTrainingData();
        $processed = $this->preprocessTrainingData($training);
        $wordCounts = $this->calculateWordCounts($processed);
        $prior = $this->calculateCategoryProbabilities($processed);
        $tokensUji = $this->preprocessText($text);
        $totalBobotPerKategori = $this->calculateTotalWordCountPerCategory($wordCounts['totalWordCount']);
        $totalBobotDataLatih = array_sum($totalBobotPerKategori);
        $likelihood = $this->calculateLikelihood($tokensUji, $wordCounts['totalWordCount'], $totalBobotPerKategori, $totalBobotDataLatih);
        $hasilAkhir = $this->calculateFinalProbabilities($likelihood, $prior);
        $kategoriTerbesar = $this->findMaxCategory($hasilAkhir);
        $kategoriId = $this->mapCategoryToId($kategoriTerbesar);

        return [
            'processedKeluhan' => $processed,
            'formattedTotalWordCount' => $wordCounts['formattedTotalWordCount'],
            'probabilitas' => $prior,
            'tokensUji' => $tokensUji,
            'totalBobotKataKategori' => $totalBobotPerKategori,
            'totalBobotKataDataLatih' => $totalBobotDataLatih,
            'likelihoodKategori' => $likelihood,
            'hasilAkhir' => $hasilAkhir,
            'kategoriTerbesar' => $kategoriTerbesar,
            'kategoriId' => $kategoriId,
        ];
    }
}

