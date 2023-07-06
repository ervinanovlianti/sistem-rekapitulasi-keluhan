<?php

namespace App\Http\Controllers;

// use Sastrawi\Tokenizer\TokenizerFactory;
// use Sastrawi\Tokenizer\Factory as TokenizerFactory;

use Sastrawi\StopWordRemover\StopWordRemoverFactory;
use Sastrawi\Stemmer\StemmerFactory;

// use Sastrawi\StopWordRemover\StopWordRemoverFactory;
// use Sastrawi\Stemmer\StemmerFactory;


use Illuminate\Http\Request;

class NaiveBayesController extends Controller
{
    


    public function index()
    {
        $complaintText = "Pembayaran Sudah Lunas tapi pada saat e-ticket muncul pesan error 'failed to confirm payment'";

        // Case Folding
        $text = strtolower($complaintText);
        // Hapus karakter atau simbol yang tidak diinginkan
       
        // // Tokenisasi
        // $tokenizerFactory = new TokenizerFactory();
        // $tokenizer = $tokenizerFactory->createDefaultTokenizer();
        // $tokens = $tokenizer->tokenize($text);

        $kata = explode(' ', $text); // Memecah kalimat menjadi array kata
        $kataTerkutip = "'" . implode("','", $kata) . "'"; // Menggabungkan kata dengan tanda kutip
        

        // Stopword Removal
        $stopwordRemoverFactory = new StopWordRemoverFactory();
        $stopwordRemover = $stopwordRemoverFactory->createStopWordRemover();
        $textWithoutStopwords = $stopwordRemover->remove($text);
        $textWithoutStopwords = preg_replace('/[^a-zA-Z0-9\s]/', '', $textWithoutStopwords);

        // Stemming
        $stemmerFactory = new StemmerFactory();
        $stemmer = $stemmerFactory->createStemmer();
        $stemmedText = $stemmer->stem($textWithoutStopwords);

        // return $stemmedText;

        return view('perhitungan_naivebayes', [
            'complaintText' => $complaintText,
            'caseFoldedText' => $text,
            'tokens' => $kataTerkutip,
            'stopword' => $textWithoutStopwords,
            'stemmedTokens' => $stemmedText,
        ]);
    }


}
