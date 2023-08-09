@extends('layouts.main')
@section('content')
<div class="row">
    <div class="col-md-12">
        <h2 class="h4 mb-1 text-center">Data Costumer Service</h2>
        {{-- <p class="mb-3">Child rows with additional detailed information</p> --}}
        <a href="/input_datacs" class="btn btn-primary my-2">Tambah</a>
        <div class="card shadow">
            <div class="card-body">
                <!-- table -->
                <table class="table table-hover table-borderless border-v">
                    <thead class="thead-dark">
                        <tr class="text-center">
                            <th>No</th>
                            <th>Nama CS</th>
                            <th>E-mail</th>
                            <th>No. Telepon</th>
                            <th>Departemen</th>
                            {{-- <th>Action</th> --}}
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
                            {{-- <td class="text-center">
                                <a href="" aria-expanded="false" class="btn btn-sm btn-warning">
                                    <i class="fe fe-edit fe-16"></i>
                                </a>
                                <a href="" aria-expanded="false" class="btn btn-sm btn-danger">
                                    <i class="fe fe-delete fe-16"></i>
                                </a>
                            </td> --}}
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div> <!-- end section -->

@endsection