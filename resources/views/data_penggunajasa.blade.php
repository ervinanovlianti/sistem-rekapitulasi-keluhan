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
                    <th>Email</th>
                    <th>No. Telepon</th>
                    <th>Jenis Pelanggan</th>
                    </tr>
                </thead>
                <tbody>
                <?php $no = 1; ?>
                @foreach($data_penggunajasa as $pengguna)
                <tr>
                    <td>{{ $no++ }}</td>
                    <td><a href="/detail-penggunajasa/{{ $pengguna->id }}">{{ $pengguna->nama }}</a> </td>
                    <td> {{ $pengguna->email }}</td>
                    <td> {{ $pengguna->no_telepon }}</td>
                    <td> {{ $pengguna->jenis_pengguna }}</td>
                </tr>
                    
    <!-- Tambahkan kode lain sesuai dengan kolom yang ingin ditampilkan -->
@endforeach
                    
                </tbody>
            </table>
            <nav aria-label="Table Paging" class="mb-0 text-muted">
                <ul class="pagination justify-content-end mb-0">
                     {{ $data_penggunajasa->links('pagination::bootstrap-4') }}
                </ul>
            </nav>
        </div>
        </div>
    </div>
    </div> <!-- end section -->

@endsection