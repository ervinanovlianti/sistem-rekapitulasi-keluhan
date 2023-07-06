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
        <!-- table -->
        <table class="table table-hover table-borderless border-v">
            <thead class="thead-dark">
                <?php $no=1; ?>
            <tr class="text-center">
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
                @php
                    $no = 1;
                @endphp
                @foreach ($processedKeluhan as $keluhan)
                    @foreach ($keluhan['tokens'] as $token)
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{ $token }}</td>
                        </tr>
                    @endforeach
                @endforeach
            </tbody>
        </table>
        </div>
    </div>

<h2 class="h4 mb-1">Preprocessing Text Data Keluhan</h2>
<div class="card shadow mb-5">
        <div class="card-body">
        <!-- table -->
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
                {{-- <td>{{ $complaintText }}</td>
                <td>{{ $caseFoldedText }}</td>
                <td>{{ $tokens }}</td>
                <td>{{ $stopword }}</td>
                <td>{{ $stemmedTokens }}</td> --}}
            </tr>
            </tbody>
        </table>
        </div>
    </div>
<h2 class="h4 mb-1 ">Preprocessing Text Data Keluhan</h2>
<div class="card shadow mb-5">
        <div class="card-body">
        <!-- table -->
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
                {{-- <td>{{ $complaintText }}</td>
                <td>{{ $caseFoldedText }}</td>
                <td>{{ $tokens }}</td>
                <td>{{ $stopword }}</td>
                <td>{{ $stemmedTokens }}</td> --}}
            </tr>
            </tbody>
        </table>
        </div>
    </div>
    <h2 class="h4 mb-1 ">Perhitungan Naive Bayes</h2>
    <div class="card shadow mb-5">
        <div class="card-body">
        <!-- table -->
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
                        {{-- Admi{nist}rasi --}}
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
                <?php $no = 1; $n = 32; $kosakata = 117 ?>
           <?php
                    // $kalimat = "bayar lunas etiket muncul pesan error failed to confirm payment";
                    // $kata = explode(' ', $stemmedTokens); // Memecah kalimat menjadi array kata

                    // foreach ($kata as $index => $value) {
                    //     echo '<tr>';
                    //     echo '<td>' . ($index + 1) . '</td>'; // Menampilkan nomor urutan
                    //     echo '<td>' . $value . '</td>'; // Menampilkan kata
                    //     echo '<td>' . $p = 0 . '</td>'; // Menampilkan kata

                    //     echo '</tr>';
                    // }
                ?> 
            
            </tbody>
            
        </table>
        </div>
    </div>
    <h2 class="h4 mb-1 ">Tahap 1: Menghitung Probabilitas Setiap Kategori</h2>
    <div class="card shadow mb-5">
        <div class="card-body">
        <!-- table -->
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
                <?php
                    $no = 1; $jumlah_kategori = 2; $jumlah_data = 10;
                    $pembayaran = $jumlah_kategori/$jumlah_data;
                ?>
            <tr>
                <td>{{  $no++ }}</td>
                <td>pembayaran</td>
                <td>{{ $jumlah_kategori }}</td>
                <td>{{ $jumlah_data }}</td>
                <td>{{ $pembayaran }}</td>
            </tr>
            <tr>
                <td>{{  $no++ }}</td>
                <td>pengiriman</td>
               <td>{{ $jumlah_kategori }}</td>
                <td>{{ $jumlah_data }}</td>
                <td>{{ $pengiriman = $jumlah_kategori/$jumlah_data  }}</td>
            </tr>
            <tr>
                <td>{{  $no++ }}</td>
                <td>penerimaan</td>
               <td>{{ $jumlah_kategori = 2 }}</td>
                <td>{{ $jumlah_data = 10 }}</td>
                <td>{{ $pembayaran = $jumlah_kategori/$jumlah_data  }}</td>
            </tr>
            
            <tr>
                <td>{{  $no++ }}</td>
                <td>administrasi</td>
               <td>{{ $jumlah_kategori = 2 }}</td>
                <td>{{ $jumlah_data = 10 }}</td>
                <td>{{ $pembayaran = $jumlah_kategori/$jumlah_data  }}</td>
            </tr>
            <tr>
                <td>{{  $no++ }}</td>
                <td>lainnya</td>
               <td>{{ $jumlah_kategori = 2 }}</td>
                <td>{{ $jumlah_data = 10 }}</td>
                <td>{{ $pembayaran = $jumlah_kategori/$jumlah_data  }}</td>
            </tr>
            
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
                <?php $no = 1; ?>
                <?php
                    $kalimat = "bayar lunas etiket muncul pesan error failed to confirm payment";
                    $kata = explode(' ', $kalimat); // Memecah kalimat menjadi array kata

                    foreach ($kata as $index => $value) {
                        echo '<tr>';
                        echo '<td>' . ($index + 1) . '</td>'; // Menampilkan nomor urutan
                        echo '<td>' . $value . '</td>'; // Menampilkan kata
                        echo '<td>' . ($p = (3+1)/(32+117)) . '</td>'; // Menampilkan kata

                        echo '</tr>';
                    }
                ?>                
            </tbody>
            <tbody>
                <tr>
                    <td colspan="2">Likehood</td>
                    <td>{{ $p }}</td>
                    <td>{{ $p }}</td>
                    <td>{{ $p }}</td>
                    <td>{{ $p }}</td>
                    <td>{{ $p }}</td>
                </tr>
            </tbody>
        </table>
        
        </div>
    </div>
    <h2 class="h4 mb-1 ">Tahap 3: Perhitungan Probabilitas kata yang sama pada kategori yang sama (likehood)</h2>
    <div class="card shadow mb-5">
        <div class="card-body">
        <!-- table -->
        <table class="table table-hover table-borderless border-v">
            <thead class="thead-dark">
            <tr>
                <th>No</th>
                <th>Kategori</th>
                <th>Probabilitas Kategori</th>
                <th>Likehood</th>
            </tr>
            </thead>
            <tbody>
                <?php $no = 1; ?>
                <tr>
                    <td>{{  $no++ }}</td>
                    <td>Pembayaran</td>
                    <td>{{ $v_pembayaran = $pembayaran * $p }}</td>
                    
                </tr>
                <tr>
                    <td>{{ $no++ }}</td>
                    <td>Pengiriman</td>
                </tr>
                <tr>
                    <td>{{ $no++ }}</td>
                    <td>Penerimaan</td>
                </tr>
                <tr>
                    <td>{{ $no++ }}</td>
                    <td>Administrasi</td>
                </tr>
                <tr>
                    <td>{{ $no++ }}</td>
                    <td>Lainnya</td>
                </tr>
                
                
                
            </tbody>
        </table>
        
        </div>
    </div>
</div>
</div> <!-- end section -->
@endsection