@extends('layouts.main')
@section('content')
<div class="row">
    <div class="col-md-12">
        @if (!empty($dataUji))
        <p>
            <button class="btn btn-sm btn-outline-primary" type="button" data-bs-toggle="collapse"
                data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
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
                            <?php $no=1; ?>
                            @foreach($formattedTotalWordCount as $data)
                            <tr>
                                <td>{{ $no++ }}</td>
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
        @elseif(empty($dataUji))
    <h2 class="h4 mb-1">Masukkan Data Uji (Data Keluhan)</h2>
    <div class="card shadow mb-4 ">
        <div class="card-body">
            <form method="post" action="/perhitungan-naive-bayes" id="dataForm" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            {{-- <input type="hidden" class="form-control" name="tgl_keluhan" id=""
                                aria-describedby="" value="{{ date(" Y-m-d h:i:sa") }}"> --}}
                            <label for="" class="form-label">Nama Pelapor</label>
                            <input type="text" class="form-control" id="" name="nama" placeholder="Nama Anda" value="{{ old('nama') }}"
                                required>
                            @error('nama')
                            <div style="color: red;">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label for="" class="form-label">No. Telepon</label>
                            <input type="text" class="form-control" name="no_telepon" id="" placeholder="+62 " value="{{ old('no_telepon') }}"
                                required>
                            @error('no_telepon')
                            <div style="color: red;">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label for="" class="form-label">Alamat Email</label>
                            <input type="text" class="form-control" id="" name="email"
                                placeholder="email@gmail.com" value="{{ old('email') }}" required>
                            @error('email')
                            <div style="color: red;">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group mv-3">
                            <label for="nama_perusahaan">Nama Perusahaan</label>
                            <input type="text" class="form-control" name="jenis_pengguna" placeholder="PT ..." value="{{ old('jenis_pengguna') }}"
                                required>
                            @error('jenis_pengguna')
                            <div style="color: red;">{{ $message }}</div>
                            @enderror
                        </div>
                    </div> <!-- /.col -->
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="example-select">Via Keluhan</label>
                            <select class="form-control" name="via_keluhan"  required>
                                <option selected value="{{ old('via_keluhan') }}">--Pilih--</option>
                                <option value="Visit">Visit</option>
                                <option value="Wa/Hp">Wa/Hp</option>
                                <option value="Walkie Talkie">Walkie Talkie</option>
                            </select>
                            @error('via_keluhan')
                                <div style="color: red;">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group mv-3">
                            <label for="uraian_keluhan">Uraian Keluhan</label>
                            <textarea id="uraian_keluhan" name="uraian_keluhan" class="form-control mb-4"
                                rows="6" cols="50" maxlength="300"
                                placeholder="Uraikan keluhan anda dengan bahasa yang mudah dipahami" value=""
                                required>{{ old('uraian_keluhan') }}</textarea>
                            @error('uraian_keluhan')
                                <div style="color: red;">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">Proses</button>
                        <button type="close" class="btn btn-secondary">Close</button>
                    </div>
                </div>
            </form>
            {{--
        </div> --}}
    </div> 
    @endif

    @if (!empty($dataUji))
    <div class="card shadow mb-5">
        <div class="card-body">
            <table class="table table-hover table-borderless border-v">
                <thead class="thead-dark">
                    <th colspan="2" class="text-center">Preprocessing Text Data Uji</th>
                </thead>
                <tbody>
                    <tr>
                        <th>Data Uji</th>
                        <td>{{ $dataUji }}</td>
                    </tr>
                    <tr>
                        <th>Case Folding</th>
                        <td>{{ $textUji }}</td>
                    </tr>
                    <tr>
                        <th>Tokenisasi</th>
                        <td>{{ $tokenUji }}</td>
                    </tr>
                    <tr>
                        <th>Stopword</th>
                        <td>{{ $cleanedTextUji }}</td>
                    </tr>
                    <tr>
                        <th>Stemming</th>
                        <td>{{ $stemmedTextUji }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <h2 class="h4 mb-1 ">Tahap 1: Menghitung Probabilitas Setiap Kategori (Prior Probability)</h2>
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

    <h2 class="h4 mb-1 ">Probabilitas Likelihood Setiap Kategori </h2>
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
                    <?php $no=1; ?>
                    @foreach ($jumlahKataUji as $data)
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ $data['kata'] }}</td>
                        <td>{{ $data['jumlah_kata_kategori']['Pembayaran'] }}</td>
                        <td>{{ $totalBobotKataKategori['Pembayaran'] }}</td>
                        <td>{{ $totalBobotKataDataLatih }}</td>
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

    <h2 class="h4 mb-1 ">Tahap 2: Perhitungan Probabilitas Kata yang Sama pada Kategori yang Sama (Likelihood)
    </h2>
    <div class="card shadow mb-5">
        <div class="card-body">
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
                    @foreach($likelihoodKategori as $index => $data)
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ $data['kata'] }}</td>
                        <td>{{ number_format($data['Pembayaran'], 9) }}</td>
                        <td>{{ number_format($data['Pengiriman'], 9) }}</td>
                        <td>{{ number_format($data['Penerimaan'], 9) }}</td>
                        <td>{{ number_format($data['Administrasi'], 9) }}</td>
                        <td>{{ number_format($data['Lainnya'], 9) }}</td>
                    </tr>
                    @endforeach
                    <tr>
                        <td colspan="2">Likelihood</td>
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
                        <th>Likelihood</th>
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
            <p>Jadi Keluhan <strong>"{{ $dataUji }}" </strong> termasuk kategori <strong>{{ $kategoriTerbesar
                    }}</strong></p>
        </div>
    </div>

    <h2 class="h4 mb-1">Preview Data Keluhan</h2>
    <div class="card shadow mb-5" id="previewKeluhan">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-hover">
                        <thead class="thead-dark">
                            <th colspan="2">Identitas Pengguna Jasa</th>
                        </thead>
                        <tbody>
                            <tr>
                                <th>Id Pelanggan</th>
                                <td>{{ $idPengguna }}</td>
                            </tr>
                            <tr>
                                <th>Nama Lengkap</th>
                                <td>{{ $namaPengguna }}</td>
                            </tr>
                            <tr>
                                <th>Alamat Email</th>
                                <td>{{ $email }}</td>
                            </tr>
                            <tr>
                                <th>No. Telepon</th>
                                <td>{{ $noTelepon }}</td>
                            </tr>
                            <tr>
                                <th>Jenis Customer</th>
                                <td>{{ $jenisPengguna }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-md-6">
                    <table class="table table-hover">
                        <thead class="thead-dark">
                            <th colspan="2">Data Keluhan</th>
                        </thead>
                        <tbody>
                            <tr>
                                <th>Id Keluhan</th>
                                <td>{{ $idKeluhan }}</td>
                            </tr>
                            <tr>
                                <th>Tanggal Keluhan</th>
                                <td>{{ $tglKeluhan }}</td>
                            </tr>
                            <tr>
                                <th>Uraian Keluhan</th>
                                <td>{{ $dataUji }}</td>
                            </tr>
                            <tr>
                                <th>Kategori Keluhan</th>
                                <td>{{ $kategoriTerbesar }}</td>
                            </tr>
                            <tr>
                                <th>Status Keluhan</th>
                                <td>{{ $statusKeluhan }}</td>
                            </tr>
                            <tr>
                                <td>
                                    <form action="/simpan-ke-database" method="post">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $idPengguna }}">
                                        <input type="hidden" name="nama" value="{{ $namaPengguna }}">
                                        <input type="hidden" name="email" value="{{ $email }}">
                                        <input type="hidden" name="no_telepon" value="{{ $noTelepon }}">
                                        <input type="hidden" name="jenis_pengguna" value="{{ $jenisPengguna }}">
                                        <input type="hidden" name="hak_akses" value="pengguna_jasa">
                                        <input type="hidden" name="id_keluhan" value="{{ $idKeluhan }}">
                                        {{-- <input type="hidden" name="tgl_keluhan" value="{{ $tglKeluhan }}">
                                        --}}
                                        <input type="hidden" name="via_keluhan" value="{{ $viaKeluhan }}">
                                        <input type="hidden" name="uraian_keluhan" value="{{ $dataUji }}">
                                        <input type="hidden" name="status_keluhan" value="menunggu verifikasi">
                                        <?php 
                                        if ($kategoriTerbesar == "Pembayaran") {
                                            $kategori_id = 1;
                                        } else if ($kategoriTerbesar == "Pengiriman") {
                                            $kategori_id = 2;
                                        } else if ($kategoriTerbesar == "Penerimaan") {
                                            $kategori_id = 3;
                                        } else if ($kategoriTerbesar == "Administrasi") {
                                            $kategori_id = 4;
                                        } else {
                                            $kategori_id = 5;
                                        }
                                    ?>
                                        <input type="hidden" name="" value="{{ $kategoriTerbesar }}">
                                        <input type="hidden" name="kategori_id" value="{{ $kategori_id }}">
                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                    </form>
                                </td>
                            </tr>
                        </tbody>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection