@extends('layouts.main')
@section('content')
<div class="row">
<div class="col-md-12">

    <h2 class="h4 mb-1">Data Latih</h2>
    <div class="card shadow mb-5">
            <div class="card-body">
            <!-- table -->
            <table class="table table-hover table-borderless border-v">
                <thead class="thead-dark">
                    <?php $no=1; ?>
                <tr class="text-center">
                    <th>No</th>
                    <th>Sebelum</th>
                    <th>Setelah</th>
                    <th>Kategori</th>
                </tr>
                </thead>
                <tbody>
                    @foreach ($processedKeluhan as $keluhan)
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ $keluhan['uraian_keluhan'] }}</td>
                        <td>{{ $keluhan['preprocessed_tokens'] }}</td>
                        <td>{{ $keluhan['kategori_keluhan'] }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <h2 class="h4 mb-1 ">Menghitung Bobot Kata Untuk Setiap Kategori</h2>
    <div class="card shadow mb-5">
        <div class="card-body">
            <table class="table table-hover table-borderless border-v">
                <thead class="thead-dark">
                    <tr class="text-center">
                        <th>No</th>
                        <th>Kata</th>
                        <th>Pembayaran</th>
                        <th>Pengiriman</th>
                        <th>Penerimaan</th>
                        <th>Administrasi</th>
                        <th>Lainnya</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($formattedTotalWordCount as $data)
                    <tr>
                        <td>{{ $data['index'] }}</td>
                        <td>{{ $data['kata'] }}</td>
                        <td>{{ $data['Pembayaran'] }}</td>
                        <td>{{ $data['Pengiriman'] }}</td>
                        <td>{{ $data['Penerimaan'] }}</td>
                        <td>{{ $data['Administrasi'] }}</td>
                        <td>{{ $data['Lainnya'] }}</td>
                        <td>{{ $data['total'] }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
    </div>

    <h2 class="h4 mb-1">Masukkan Data Uji</h2>
    <div class="card shadow mb-5">
        <div class="card-body">
            <form method="post" action="/perhitungan-naive-bayes">
                @csrf
                <label for="data_uji">Data Uji</label>
                <textarea id="data_uji" name="data_uji" class="form-control mb-4" rows="2" cols="50"></textarea>
                <button type="submit" class="btn btn-primary">Proses</button>
            </form>

        </div>
    </div>

    <h2 class="h4 mb-1">Preprocessing Text Data Uji</h2>
    <div class="card shadow mb-5">
        <div class="card-body">
            <table class="table table-hover table-borderless border-v">
                <thead class="thead-dark">
                <tr class="text-center">
                    <th>Teks Asli</th>
                    <th>Case Folding</th>
                    <th>Tokenisasi</th>
                    <th>Stopword</th>
                    <th>Stemming</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>{{ $dataUji }}</td>
                    <td>{{ $textUji }}</td>
                    <td>{{ $tokenUji }}</td>
                    <td>{{ $cleanedTextUji }}</td>
                    <td>{{ $stemmedTextUji }}</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>

    <h2 class="h4 mb-1 ">Probabilitas likehood setiap kategori </h2>
    <div class="card shadow mb-5">
        <div class="card-body">
            <table class="table table-hover table-borderless border-v">
                <thead class="thead-dark">
                    <tr class="text-center">
                            <th rowspan="2">No</th>
                            <th rowspan="2">Kata</th>
                            <th colspan="3">Pembayaran</th>
                            <th colspan="3">Pengiriman</th>
                            <th colspan="3">Penerimaan</th>
                            <th colspan="3">Administrasi</th>
                            <th colspan="3">Lainnya</th>
                        </tr>
                        <tr role="row">
                            {{-- Pembayaran --}}
                            <th>ni</th>
                            <th>n</th>
                            <th>kosakata</th>
                            {{-- Pengiriman --}}
                            <th>ni</th>
                            <th>n</th>
                            <th>kosakata</th>
                            {{-- Penerimaan --}}
                            <th>ni</th>
                            <th>n</th>
                            <th>kosakata</th>
                            {{-- Administrasi --}}
                            <th></th>
                            <th>n</th>
                            <th>kosakata</th>
                            {{-- Lainnya --}}
                            <th>ni</th>
                            <th>n</th>
                            <th>kosakata</th>
                        </tr>
                </thead>
                <tbody>
                    <?php $no=1; 
                    ?>
                    @foreach ($jumlahKataUji as $data)
                <tr>
                   
                    <td>{{ $no++ }}</td>
                    <td>{{ $data['kata'] }}</td>

                    <td>{{ $data['jumlah_kata_kategori']['Pembayaran'] }}</td>
                    <td>{{ $totalBobotKategori['Pembayaran'] }}</td>
                    <td>{{ $totalBobotDataLatih }}</td>

                    <td>{{ $data['jumlah_kata_kategori']['Pengiriman'] }}</td>
                    <td>{{ $totalBobotKategori['Pengiriman'] }}</td>
                    <td>{{ $totalBobotDataLatih }}</td>

                    <td>{{ $data['jumlah_kata_kategori']['Penerimaan'] }}</td>
                    <td>{{ $totalBobotKategori['Penerimaan'] }}</td>
                    <td>{{ $totalBobotDataLatih }}</td>

                    <td>{{ $data['jumlah_kata_kategori']['Administrasi'] }}</td>
                    <td>{{ $totalBobotKategori['Administrasi'] }}</td>
                    <td>{{ $totalBobotDataLatih }}</td>

                    <td>{{ $data['jumlah_kata_kategori']['Lainnya'] }}</td>
                    <td>{{ $totalBobotKategori['Lainnya'] }}</td>
                    <td>{{ $totalBobotDataLatih }}</td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    
    <h2 class="h4 mb-1 ">Tahap 1: Menghitung Probabilitas Setiap Kategori</h2>
    <div class="card shadow mb-5">
        <div class="card-body">
        <table class="table table-hover table-borderless border-v">
            <thead class="thead-dark">
            <tr>
                <th>No</th>
                <th>Kategori</th>
                <th>Jumlah Kategori</th>
                <th>Jumlah Seluruh data</th>
                <th>Probabilitas</th>
            </tr>
            </thead>
            <tbody>
                <?php $no=1; ?>
                @foreach ($probabilitas as $kategori => $prob)
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ $kategori }}</td>
                        <td>{{ $kategoriCount[$kategori] }}</td>
                        <td>{{ $totalKeluhan }}</td>
                        <td>{{ $prob }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        </div>
    </div>
    
    <h2 class="h4 mb-1 ">Tahap 2: Perhitungan Probabilitas kata yang sama pada kategori yang sama (likehood)</h2>
    <div class="card shadow mb-5">
        <div class="card-body">
        <!-- table -->
        <table class="table table-hover table-bordered border-v">
            <thead class="thead-dark">
            <tr>
                <th>No</th>
                <th>Kata</th>
                <th>Pembayaran</th>
                <th>Pengiriman</th>
                <th>Penerimaan</th>
                <th>Administrasi</th>
                <th>Lainnya</th>
            </tr>
            </thead>
            <tbody>
                <?php $no=1; ?>
                    @foreach ($jumlahKataUji as $data)
                     <?php 
                        $probs_pembayaran = ($data['jumlah_kata_kategori']['Pembayaran']+1)/($totalBobotKategori['Pembayaran']+ $totalBobotDataLatih );
                        $probs_pengiriman = ($data['jumlah_kata_kategori']['Pengiriman']+1)/($totalBobotKategori['Pengiriman']+ $totalBobotDataLatih );
                        $probs_penerimaan = ($data['jumlah_kata_kategori']['Penerimaan']+1)/($totalBobotKategori['Penerimaan']+ $totalBobotDataLatih );
                        $probs_administrasi = ($data['jumlah_kata_kategori']['Administrasi']+1)/($totalBobotKategori['Administrasi']+ $totalBobotDataLatih );
                        $probs_lainnya = ($data['jumlah_kata_kategori']['Lainnya']+1)/($totalBobotKategori['Lainnya']+ $totalBobotDataLatih );

                        $likehood_pembayaran = $probs_pembayaran;
                        $likehood_pengiriman = $probs_pengiriman;
                        $likehood_penerimaan = $probs_penerimaan;
                        $likehood_administrasi = $probs_administrasi;
                        $likehood_lainnya = $probs_lainnya;

                        // Lakukan perkalian probabilitas dengan nilai probabilitas kategori yang sesuai
                        $likehood_pembayaran *= $probs_pembayaran;
                        $likehood_pengiriman *= $probs_pengiriman;
                        $likehood_penerimaan *= $probs_penerimaan;
                        $likehood_administrasi *= $probs_administrasi;
                        $likehood_lainnya *= $probs_lainnya;
                    ?>
                <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{ $data['kata'] }}</td>
                    <td>{{ number_format($probs_pembayaran, 9) }}</td>
                    <td>{{ number_format($probs_pengiriman , 9) }}</td>
                    <td>{{ number_format($probs_penerimaan, 9) }}</td>
                    <td>{{ number_format($probs_administrasi, 9) }}</td>
                    <td>{{ number_format($probs_lainnya, 9)  }}</td>
                </tr>
                @endforeach
            </tbody>

            <tbody>
                <tr>
                    <td colspan="2">Likehood</td>
                    <td>{{ $likehood_pembayaran }}</td>
                    <td>{{ $likehood_pengiriman }}</td>
                    <td>{{ $likehood_penerimaan }}</td>
                    <td>{{ $likehood_administrasi }}</td>
                    <td>{{ $likehood_lainnya }}</td>
                </tr>
                {{-- <tr>
                    <td>{{ number_format($likehood_pembayaran, 20) }}</td>
                    <td>{{ number_format($likehood_pengiriman, 20) }}</td>
                    <td>{{ number_format($likehood_penerimaan, 20) }}</td>
                    <td>{{ number_format($likehood_administrasi, 20) }}</td>
                    <td>{{ number_format($likehood_lainnya, 20) }}</td> --}}

                </tr>
            </tbody>
           
        </table>
        
        </div>
    </div>
    <h2 class="h4 mb-1 ">Tahap 3: Perhitungan </h2>
    <div class="card shadow mb-5">
        <div class="card-body">
            <table class="table table-hover table-borderless border-v">
                <thead class="thead-dark">
                <tr>
                    <th>No</th>
                    <th>Kategori</th>
                    <th>Posterior</th>
                    
                </tr>
                </thead>
                <tbody>
                    <?php 
                        $no=1;
                        // $posterior_pembayaran = $probs_pembayaran * $likehood_pembayaran;
                        // $posterior_pengiriman = $probs_pengiriman * $likehood_pengiriman;
                        // $posterior_penerimaan = $probs_penerimaan * $likehood_penerimaan;
                        // $posterior_administrasi = $probs_administrasi* $likehood_administrasi;
                        // $posterior_lainnya =   $probs_lainnya * $likehood_lainnya;
                    ?>
                    {{-- <tr>
                        <td>{{ $no++ }}</td>
                        <td>Pembayaran</td>
                        <td>{{ $posterior_pembayaran }}</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>Pengiriman</td>
                        <td>{{ $posterior_pengiriman }}</td>
                    </tr>
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>Penerimaan</td>
                        <td>{{ $posterior_penerimaan }}</td>
                    </tr>
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>Administrasi</td>
                        <td>{{ $posterior_administrasi }}</td>
                    </tr>
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>Lainnya</td>
                        <td>{{ $posterior_lainnya }}</td>
                    </tr> --}}
                </tbody>
            </table>
        
        </div>
    </div>
    
</div>
</div> 
@endsection