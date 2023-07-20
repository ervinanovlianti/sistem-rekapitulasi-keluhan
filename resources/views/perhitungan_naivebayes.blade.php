@extends('layouts.main')
@section('content')
<div class="row">
<div class="col-md-12">
    <p>
        <button class="btn btn-sm btn-outline-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
            Tampilkan Data Latih
        </button>
    </p>
    <div class="collapse" id="collapseExample">
    
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
</div>

    <h2 class="h4 mb-1">Masukkan Data Uji</h2>
    <div class="card shadow mb-5">
        <div class="card-body">
            <form method="post" action="/perhitungan-naive-bayes">
                @csrf
                <label for="data_uji">Data Uji</label>
                <textarea id="data_uji" name="data_uji" class="form-control mb-4" rows="2" cols="50"></textarea>
                <button type="submit" class="btn btn-primary" >Proses</button>
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

    <h2 class="h4 mb-1 ">Tahap 1: Menghitung Probabilitas Setiap Kategori</h2>
    <div class="card shadow mb-5">
        <div class="card-body">
        <table class="table table-hover table-borderless border-v">
            <thead class="thead-dark">
            <tr>
                <th>No</th>
                <th>Kategori</th>
                <th class="text-center">Jumlah Kategori</th>
                <th class="text-center">Jumlah Seluruh data</th>
                <th class="text-center">Probabilitas</th>
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
                    <td>{{ $totalBobotKataKategori['Pembayaran'] }}</td>
                    <td>{{ $totalBobotKataDataLatih }}</td>
                    {{-- <td>{{ $probabilitas_pembayaran }}</td> --}}

                    <td>{{ $data['jumlah_kata_kategori']['Pengiriman'] }}</td>
                    <td>{{ $totalBobotKataKategori['Pengiriman'] }}</td>
                    <td>{{ $totalBobotKataDataLatih }}</td>

                    <td>{{ $data['jumlah_kata_kategori']['Penerimaan'] }}</td>
                    <td>{{ $totalBobotKataKategori['Penerimaan'] }}</td>
                    <td>{{ $totalBobotKataDataLatih }}</td>

                    <td>{{ $data['jumlah_kata_kategori']['Administrasi'] }}</td>
                    <td>{{ $totalBobotKataKategori['Administrasi'] }}</td>
                    <td>{{ $totalBobotKataDataLatih }}</td>

                    <td>{{ $data['jumlah_kata_kategori']['Lainnya'] }}</td>
                    <td>{{ $totalBobotKataKategori['Lainnya'] }}</td>
                    <td>{{ $totalBobotKataDataLatih }}</td>
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
                @foreach($likehoodKategori as $index => $data)
        <tr>
            <td>{{ $index }}</td>
            <td>{{ $data['kata'] }}</td>
            <td>{{ number_format($data['Pembayaran'], 9)  }}</td>
            <td>{{ number_format($data['Pengiriman'], 9) }}</td>
            <td>{{ number_format($data['Penerimaan'], 9) }}</td>
            <td>{{ number_format($data['Administrasi'], 9) }}</td>
            <td>{{ number_format($data['Lainnya'], 9) }}</td>
        </tr>
        @endforeach
        <tr>
            <td colspan="2">Likehood</td>
            <td>{{ $hasil_perkalian_probabilitas_pembayaran }}</td>
            <td>{{ $hasil_perkalian_probabilitas_pengiriman }}</td>
            <td>{{ $hasil_perkalian_probabilitas_penerimaan }}</td>
            <td>{{ $hasil_perkalian_probabilitas_administrasi }}</td>
            <td>{{ $hasil_perkalian_probabilitas_lainnya }}</td>
        </tr>
            </tbody>
        </table>
        </div>
    </div>

    <h2 class="h4 mb-1 ">Tahap 3: Perhitungan Probabilitas Tertinggi </h2>
    <div class="card shadow mb-5">
        <div class="card-body">
            <table class="table table-hover table-borderless border-v">
                <thead class="thead-dark">
                <tr>
                    <th>No</th>
                    <th>Kategori</th>
                    <th>Prior Probabilitas</th>
                    <th>Likehood</th>
                    <th>Posterior</th>
                </tr>
                </thead>
                <tbody>
                    <?php $no=1; ?>
                    @foreach ($hasilAkhir as $kategori => $hasil)
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ $kategori }}</td>
                        <td>{{ $hasilProbabilitas[$kategori] }}</td>
                        <td>{{ $hasilPerkalianProbabilitas[$kategori] }}</td>
                        <td>{{ $hasil }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>

    
        </div>
    </div>

    <h2 class="h4 mb-1 ">Hasil Klasifikasi Kategori</h2>
    <div class="card shadow mb-5">
        <div class="card-body">
            <!-- Menampilkan kategori dengan nilai terbesar -->
            <p>Kategori dengan nilai terbesar adalah: {{ $kategoriTerbesar }}</p>
            <p>Jadi Keluhan <strong>"{{ $dataUji }}" </strong>  termasuk kategori <strong>{{ $kategoriTerbesar }}</strong></p>
        </div>
    </div>

</div>
</div> 
@endsection