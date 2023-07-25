@extends('layouts.main')
@section('content')
<div class="row">
    <!-- Striped rows -->
    <div class="col-md-12">
        <h2 class="h4 mb-1 text-center">Rekapitulasi Keluhan Pengguna Jasa Berdasarkan Kategori</h2>
        <div class="card shadow">
        <div class="card-body">
        <!-- table -->
            {{-- <table class="table table-hover table-borderless border-v ">
                <thead class="thead-dark">
                    <tr class="text-center">
                        <th rowspan="2">No</th>
                        <th rowspan="2">Kategori Keluhan</th>
                        <th colspan="4">Via Keluhan</th>
                        <th colspan="3">Status Keluhan</th>
                        <th rowspan="2" >Total Keluhan</th>
                    </tr>
                    <tr role="row">
                            <th>Visit</th>
                            <th>Web</th>
                            <th>HP/Wa</th>
                            <th>TW</th>
                            <th>Selesai</th>
                            <th>Belum Selesai</th>
                            <th>Tidak Selesai</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no=1 ?>
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>Pembayaran</td>
                        <td>{{ $jumlahPembayaran }}</td>
                        <td>{{ $jumlahPembayaran1 }}</td>
                        
                    </tr>
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>Penerimaan</td>
                        <td>{{ $jumlahPengiriman }}</td>
                        <td>{{ $jumlahPengiriman1 }}</td>
                       
                    </tr>
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>Pengiriman</td>
                        
                        <td>{{ $jumlahPenerimaan }}</td>
                        <td>{{ $jumlahPenerimaan1 }}</td>
                    </tr>
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>Administrasi</td>
                        <td>{{ $jumlahAdministrasi }}</td>
                        <td>{{ $jumlahAdministrasi1 }}</td>
                        
                    </tr>
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>Lainnya</td>
                        <td>{{ $jumlahLainnya }}</td>
                        <td>{{ $jumlahLainnya1 }}</td>
                    </tr>
                </tbody>
            </table> --}}


            <h1>Hasil Perhitungan Jumlah Kategori Keluhan</h1>

    <table>
        <tr>
            <th>Kategori Keluhan</th>
            <th>Jumlah</th>
        </tr>
        @foreach ($jumlahKategoriKeluhan as $data)
        <tr>
            {{-- <td>{{ $data->kategori_id }}</td> --}}
            <td>{{ $data->jumlah_kategori }}</td>
        </tr>
        @endforeach
        @foreach ($jumlahKategoriKeluhan1 as $data1)
        <tr>
            <td>{{ $data1->kategori_id }}</td>
            <td>{{ $data1->jumlah_kategori }}</td>
        </tr>
        @endforeach
    </table>
        </div>
        </div>
    </div> <!-- simple table -->
    </div> <!-- end section -->
@endsection