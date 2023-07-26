@extends('layouts.main')
@section('content')
<div class="row">
    <!-- Striped rows -->
    <div class="col-md-12">
        <h2 class="h4 mb-1 text-center">Rekapitulasi Keluhan Pengguna Jasa Berdasarkan Kategori</h2>
        <div class="card shadow">
        <div class="card-body">
            <!-- keluhan.rekapitulasi.blade.php -->

        
            <table class="table table-hover table-borderless border-v ">
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
                            <th>HP/Wa</th>
                            <th>Web</th>
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
                        <td>{{ $jumlahPembayaran2 }}</td>
                        <td>{{ $jumlahPembayaran3 }}</td>
                        <td>{{ $statusKeluhanPembayaran1 }}</td>
                        <td>{{ $statusKeluhanPembayaran2 }}</td>
                        <td>{{ $statusKeluhanPembayaran3 }}</td>
                    </tr>
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>Pengiriman</td>
                        <td>{{ $jumlahPengiriman }}</td>
                        <td>{{ $jumlahPengiriman1 }}</td>
                        <td>{{ $jumlahPengiriman2 }}</td>
                        <td>{{ $jumlahPengiriman3 }}</td>
                    </tr>
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>Penerimaan</td>
                        <td>{{ $jumlahPenerimaan }}</td>
                        <td>{{ $jumlahPenerimaan1 }}</td>
                        <td>{{ $jumlahPenerimaan2 }}</td>
                        <td>{{ $jumlahPenerimaan3 }}</td>
                    </tr>
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>Administrasi</td>
                        <td>{{ $jumlahAdministrasi }}</td>
                        <td>{{ $jumlahAdministrasi1 }}</td>
                        <td>{{ $jumlahAdministrasi2 }}</td>
                        <td>{{ $jumlahAdministrasi3 }}</td>
                    </tr>
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>Lainnya</td>
                        <td>{{ $jumlahLainnya }}</td>
                        <td>{{ $jumlahLainnya1 }}</td>
                        <td>{{ $jumlahLainnya2 }}</td>
                        <td>{{ $jumlahLainnya3 }}</td>
                    </tr>
                </tbody>
            </table> 
        </div>
        </div>
    </div>
    </div>
@endsection