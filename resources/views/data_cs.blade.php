@extends('layouts.main')
@section('content')
<div class="row">
    <div class="col-md-12">
        <h2 class="h4 mb-1">Data Costumer Service</h2>
        {{-- <p class="mb-3">Child rows with additional detailed information</p> --}}
        <a href="/input_datacs" class="btn btn-primary my-2">Tambah</a>
        <div class="card shadow">
        <div class="card-body">
            <!-- table -->
            <table class="table table-hover table-borderless border-v">
            <thead class="thead-dark">
                <tr>
                    <th>No</th>
                    <th>Nama CS</th>
                    <th>E-mail</th>
                    <th>No. Telepon</th>
                    <th>Departemen</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; ?>
                @foreach($data_cs as $cs)
                <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{ $cs->nama }}</td>
                    <td>{{ $cs->email }}</td>
                    <td>{{ $cs->no_telepon }}</td>
                    <td>{{ $cs->jenis_pengguna }}</td>
                </tr>
                @endforeach
            </tbody>
            </table>
        </div>
        </div>
    </div>
    </div> <!-- end section -->

@endsection