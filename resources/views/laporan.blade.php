@extends('layouts.main')
@section('content')
<div class="row">
    <!-- Striped rows -->
    <div class="col-md-12">
        <h2 class="h4 mb-1 text-center">Laporan Keluhan Pengguna Jasa Petikemas Kategori {{ request ('kategori') }} Per {{ request ('bulan') }} </h2>
        <h2 class="h4 mb-1 text-center">PT. Pelindo (Persero) Terminal Petikemas New Makassar</h2>
         @if (Session::has('success'))
            <div class="alert alert-success">
                {{ Session::get('success') }}
            </div>
        @endif
        <div class="card shadow">
        <div class="card-body">
            <div class="toolbar row mb-3">
            <div class="col">
                <form class="form-inline" method="GET" action="{{ route('laporan.cari') }}">
                    <div class="form-row">
                        <div class="form-group col-4 mr-4 ">
                            <label for="cari" class="sr-only">Search</label>
                            <input type="text" name="cari" id="cari" class="form-control" placeholder="Search" value="{{ request ('cari') }}">
                        </div>
                        <div class="form-group col-3 ml-3">
                            <select name="bulan" class="custom-select my-1 " id="inlineFormCustomSelectPref" >
                                @if (empty(request('bulan')))
                                <option value="">Pilih Bulan...</option>
                                @else
                                <option value="" selected>{{ request('bulan') }}</option>
                                @endif
                                <option value="2023-06">Juni 2023</option>
                                <option value="2023-07">Juli 2023</option>
                                
                            </select>
                        </div>
                        <div class="form-group col-3 ">
                            <select class="custom-select my-1 " name="kategori">
                                @if (empty(request('kategori')))
                                <option value="" selected>Pilih Kategori...</option>
                                @else
                                <option value="" selected>{{ request('kategori') }}</option>
                                @endif
                                <option value="Pembayaran">Pembayaran</option>
                                <option value="Pengiriman">Pengiriman</option>
                                <option value="Penerimaan">Penerimaan</option>
                                <option value="Administrasi">Administrasi</option>
                                <option value="Lainnya">Lainnya</option>
                            </select>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Search</button>
                    {{-- <a href="{{ route('export', ['export' => 1]) }}" class="btn btn-success">Export</a> --}}
                </form>
            </div>
            <div class="col-md-3 ml-1">
                <div class="dropdown float-right">
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="actionMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Export </button>
                    <div class="dropdown-menu" aria-labelledby="actionMenuButton">
                        <a class="dropdown-item" href="{{ url('/export-to-pdf/') }}">PDF</a>
                        <a class="dropdown-item" href="{{ url('/export') }}">EXCEL</a>
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
                    <th>Kategori</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; ?>
                @foreach ($keluhan as $item)
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ $item->uraian_keluhan }}</a></td>
                        <td>{{ date('d-m-Y H:m:s', strtotime($item->tgl_keluhan)) }}</td>
                        <td>{{ $item->nama }}</td>
                        <td>{{ $item->via_keluhan }}</td>
                        <td>
                            {{-- @if ($item->status_keluhan == 'selesai')
                            <span class="badge badge-pill badge-success mr-2">{{ $item->status_keluhan }}</span></td>
                            @elseif ($item->status_keluhan == 'menunggu verifikasi')
                            <span class="badge badge-pill badge-warning mr-2">{{ $item->status_keluhan }}</span></td>
                            @else
                            <span class="badge badge-pill badge-info mr-2">{{ $item->status_keluhan }}</span></td>
                            @endif --}}
                            {{ $item->status_keluhan }}
                        </td>
                        <td>{{ $item->waktu_penyelesaian }}</td>
                        <td>{{ $item->kategori_keluhan }}</td>
                        <td>{{ $item->aksi }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
            <nav aria-label="Table Paging" class="mb-0 text-muted">
                <ul class="pagination justify-content-end mb-0">
                    {{ $keluhan->links('pagination::bootstrap-4') }}
                </ul>
            </nav>
        </div>
        </div>
    </div> <!-- simple table -->
    </div> <!-- end section -->
@endsection