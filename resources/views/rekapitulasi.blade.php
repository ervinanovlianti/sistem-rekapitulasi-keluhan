@extends('layouts.main')
@section('content')
    <div class="row">
        <!-- Striped rows -->
        <div class="col-md-12">
            <h2 class="h4 mb-1 text-center">Rekapitulasi Keluhan Pengguna Jasa Berdasarkan Kategori</h2>
            <div class="card shadow">
                <div class="card-body">
                    <form class="form-inline mb-3" action="/rekapitulasi" method="GET">
                        <div class="form-row">
                                <div class="form-group col-4  ">
                        {{-- <label for="tanggal_awal">Tanggal Awal:</label> --}}
                        <input type="date" class="form-control" id="tanggal_awal" name="tanggal_awal" value="{{ request('tanggal_awal') }}">
                                </div>
                                <div class="form-group col-4 mx-5 ">
                        {{-- <label for="tanggal_akhir">Tanggal Akhir:</label> --}}
                        <input type="date" class="form-control" id="tanggal_akhir" name="tanggal_akhir" value="{{ request('tanggal_akhir') }}">
                                </div>
                            </div>
                            <button type="submit" class="form-control">Filter</button>
                    </form>
                    <table class="table table-hover table-borderless border-v ">
                        <thead class="thead-dark">
                            <tr class="text-center">
                                <th rowspan="2">No</th>
                                <th rowspan="2">Kategori Keluhan</th>
                                <th colspan="4">Via Keluhan</th>
                                <th colspan="3">Status Keluhan</th>
                                <th rowspan="2">Total Keluhan</th>
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
                            <?php $no=1; ?>
                            @foreach ($rekapData as $kategoriId => $data)
                            <tr>
                                <td>{{ $no++ }}</td>
                                <td>{{ $data['kategori'] }}</td>
                                <td>{{ $data['Visit'] }}</td>
                                <td>{{ $data['Wa/HP'] }}</td>
                                <td>{{ $data['Web'] }}</td>
                                <td>{{ $data['Walkie Talkie'] }}</td>
                                <td>{{ $data['status']['selesai'] }}</td>
                                <td>{{ $data['status']['belum_selesai'] }}</td>
                                <td>{{ $data['status']['tidak_selesai'] }}</td>
                                <td>{{ $data['total'] }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
