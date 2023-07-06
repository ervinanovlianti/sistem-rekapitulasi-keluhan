<?php

namespace App\Http\Controllers;

use Sastrawi\StopWordRemover\StopWordRemoverFactory;
use Sastrawi\StopWordRemover\StopWordRemoverFactoryInterface;


use Illuminate\Http\Request;

class ExampleController extends Controller
{
    public function index()
    {
        $kalimatTanpaStopword = $this->removeStopwords();

        return view('example', compact('kalimatTanpaStopword'));
    }

    public function removeStopwords()
    {
        $kalimat = "Pembayaran sudah lunas tapi pada saat e-ticket muncul pesan error 'failed to confirm payment'";

        $stopwordRemoverFactory = new StopWordRemoverFactory();
        $stopwordRemover = $stopwordRemoverFactory->createStopWordRemover();

        $kalimatTanpaStopword = $stopwordRemover->remove($kalimat);

        return $kalimatTanpaStopword;
    }
    // public function processComplaint($complaintText)
    // {
    //     // Panggil metode preprocessText()
    //     $preprocessedText = $this->preprocessText($complaintText);

        
    //     // Lakukan proses selanjutnya sesuai kebutuhan Anda
    //     return view('complaint', [
    //         'complaintText' => $complaintText,
    //         'caseFoldedText' => $caseFoldedText,
    //         'tokens' => $tokens,
    //         'filteredTokens' => $filteredTokens,
    //         'stemmedTokens' => $stemmedTokens,
    //     ]);
    // }

    function logic() {
        $keluhan = "Pembayaran Sudah Lunas tapi pada saat e-ticket muncul pesan error 'failed to confirm payment'";
        $keluhanLower = strtolower($keluhan); // Mengubah kalimat menjadi huruf kecil
        $kata = explode(' ', $keluhanLower); // Memecah kalimat menjadi array kata
        $kataTerkutip = "'" . implode("','", $kata) . "'"; // Menggabungkan kata dengan tanda kutip

    }
    

}
