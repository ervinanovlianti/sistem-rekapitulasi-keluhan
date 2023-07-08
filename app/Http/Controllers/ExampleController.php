<?php

namespace App\Http\Controllers;

use Sastrawi\StopWordRemover\StopWordRemoverFactory;
use Sastrawi\StopWordRemover\StopWordRemoverFactoryInterface;

use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

class ExampleController extends Controller
{
    public function processKeluhan()
    {
        // Ambil data keluhan yang telah diproses
        $processedKeluhan = $this->preprocessKeluhan();

        // Inisialisasi variabel untuk menyimpan jumlah kata dalam setiap kategori
        $wordCount = [];

        // Iterasi melalui setiap keluhan yang telah diproses
        foreach ($processedKeluhan as $keluhan) {
            $kategori = $keluhan['kategori'];
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

        // Tampilkan hasil perhitungan jumlah kata dalam setiap kategori
        dd($wordCount);
    }

    
}
