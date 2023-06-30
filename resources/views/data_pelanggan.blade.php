@extends('layouts.main')
@section('content')
<div class="row">
    <div class="col-md-12">
        <h2 class="h4 mb-1 text-center">Data Pelanggan</h2>
        {{-- <p class="mb-3">Child rows with additional detailed information</p> --}}
        {{-- <button class="btn-primary my-2">Tambah</button> --}}
        <div class="card shadow">
        <div class="card-body">
            <!-- table -->
            <table class="table table-hover table-borderless border-v">
            <thead class="thead-dark">
                <tr>
                <th>No</th>
                <th>Nama</th>
                <th>No. Kontak</th>
                <th>Jenis Pelanggan</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; ?>
                <tr>
                    <td>{{  $no++ }}</td>
                    <td>Ervina</td>
                    <td>123</td>
                    <td>Perusahaan</td>
                </tr>
                <tr>
                    <td>{{ $no++ }}</td>
                    <td>PT Mutiara Permata</td>
                    <td>1234</td>
                    <td>Perusahaan</td>
                </tr>

                <tr>
                    <td>{{ $no++ }}</td>
                    <td>Mudyna</td>
                    <td>1234</td>
                    <td>Perseorangan</td>
                </tr>
            </tbody>
            </table>
        </div>
        </div>
    </div>
    </div> <!-- end section -->

@endsection