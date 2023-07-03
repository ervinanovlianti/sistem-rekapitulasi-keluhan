@extends('layouts.main')
@section('content')
<div class="row">
    <!-- Striped rows -->
    <div class="col-md-12">
        <h2 class="h4 mb-1 text-center">Laporan Keluhan Pengguna Jasa Petikemas Kategori ... Per ... </h2>
        <h2 class="h4 mb-1 text-center">PT. Pelindo (Persero) Terminal Petikemas New Makassar</h2>
        <div class="card shadow">
        <div class="card-body">
            <div class="toolbar row mb-3">
            <div class="col">
                <form class="form-inline">
                <div class="form-row">
                    <div class="form-group col-4 mr-4">
                        <label for="search" class="sr-only">Search</label>
                        <input type="text" name="" id="" class="form-control" placeholder="Search">
                        {{-- <input type="text" class="form-control" id="search" value="" placeholder="Search"> --}}
                    </div>
                    <div class="form-group col-3">
                        {{-- <label class="my-1 mr-2 sr-only" for="inlineFormCustomSelectPref">Status</label> --}}
                        <select class="custom-select my-1 mr-sm-2" id="inlineFormCustomSelectPref">
                            <option selected>Pilih Bulan...</option>
                            <option value="1">Juni 2023</option>
                            <option value="2">July 2023</option>
                        </select>
                    </div>
                    <div class="form-group col-3">
                        {{-- <label class="my-1 mr-2 sr-only" for="inlineFormCustomSelectPref">Status</label> --}}
                        <select class="custom-select my-1 mr-sm-2" id="inlineFormCustomSelectPref">
                            <option selected>Pilih Kategori...</option>
                            <option value="1">Pembayaran</option>
                            <option value="2">Penerimaan</option>
                            <option value="3">Pengiriman</option>
                            <option value="4">Administrasi</option>
                            <option value="5">Lainnya</option>
                        </select>
                    </div>
                </div>
                </form>
            </div>
            <div class="col-md-3 ml-1">
                <div class="dropdown float-right">
                <button class="btn btn-secondary dropdown-toggle" type="button" id="actionMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Export </button>
                <div class="dropdown-menu" aria-labelledby="actionMenuButton">
                    <a class="dropdown-item" href="#">PDF</a>
                    <a class="dropdown-item" href="#">EXCEl</a>
                </div>
                </div>
            </div>
            </div>
            <!-- table -->
            <table class="table table-hover table-borderless border-v">
                <thead class="thead-dark">
                    <tr class="text-center">
                        <th>No</th>
                        <th>Uraian Keluhan</th>
                        <th>Tanggal Laporan</th>
                        <th>Customer</th>
                        <th>Via Keluhan</th>
                        <th>Status Keluhan</th>
                        <th>Waktu Selesai</th>
                        <th>Aksi</th>
                        <th>Kategori</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no=1 ?>
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>Lorem ipsum dolor sit amet consectetur adipisicing elit. Tenetur corrupti eos expedita?</td>
                        <td>{{ date('l, d-m-Y  H:i:s') }}</td>
                        <td>PT Samudera Merdeka</td>
                        <td>Wa</td>
                        <td><span class="badge badge-secondary">Menunggu Verifikasi Admin</span></td>
                        <td>{{ date('H:i:s') }}</td>
                        <td>Silahkan lakukan input kembali</td>
                        <td>Pembayaran</td>
                    </tr>
                
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>Lorem ipsum dolor sit amet consectetur adipisicing elit. Atque error, molestiae optio est, numquam nobis fuga ipsum ducimus consequatur tempora rerum, earum repellendus!</td>
                        <td>{{ date('l, d-m-Y  H:i:s') }}</td>
                        <td>PT Samudera Merdeka</td>
                        <td>Wa</td>
                        <td><span class="badge badge-warning">Diteruskan Ke CS</span></td>
                        <td>{{ date('H:i:s') }}</td>
                        <td>Silahkan lakukan input kembali</td>
                        <td>Pembayaran</td>
                    </tr>
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>Lorem ipsum dolor sit amet consectetur adipisicing elit. Atque error, molestiae optio est, numquam nobis fuga ipsum ducimus consequatur tempora rerum, earum repellendus!</td>
                        <td>{{ date('l, d-m-Y  H:i:s') }}</td>
                        <td>PT Samudera Merdeka</td>
                        <td>Wa</td>
                        <td><span class="badge badge-info">Ditangani CS</span></td>
                        <td>{{ date('H:i:s') }}</td>
                        <td>Silahkan lakukan input kembali</td>
                        <td>Pembayaran</td>
                    </tr>
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>Lorem ipsum dolor sit amet consectetur adipisicing elit. Atque error, molestiae optio est, numquam nobis fuga ipsum ducimus consequatur tempora rerum, earum repellendus!</td>
                        <td>{{ date('l, d-m-Y  H:i:s') }}</td>
                        <td>PT Samudera Merdeka</td>
                        <td>Wa</td>
                        <td><span class="badge badge-success">Selesai</span></td>
                        <td>{{ date('H:i:s') }}</td>
                        <td>Silahkan lakukan input kembali</td>
                        <td>Pembayaran</td>
                    </tr>
                </tbody>
            </table>
            <nav aria-label="Table Paging" class="mb-0 text-muted">
            <ul class="pagination justify-content-end mb-0">
                <li class="page-item"><a class="page-link" href="#">Previous</a></li>
                <li class="page-item"><a class="page-link" href="#">1</a></li>
                <li class="page-item"><a class="page-link" href="#">2</a></li>
                <li class="page-item"><a class="page-link" href="#">3</a></li>
                <li class="page-item"><a class="page-link" href="#">Next</a></li>
            </ul>
            </nav>
        </div>
        </div>
    </div> <!-- simple table -->
    </div> <!-- end section -->
@endsection