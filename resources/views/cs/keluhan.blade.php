@extends('layouts.main')
@section('content')
<div class="row">
<div class="col-md-12">
<h2 class="h4 mb-1 text-center">Data Keluhan</h2>
<div class="card shadow">
    <div class="card-body">
    <!-- table -->
    <table class="table table-hover table-borderless border-v">
        <thead class="thead-dark">
        <tr>
            <th>No</th>
            <th>Customer</th>
            <th>Uraian Keluhan</th>
            <th>Tanggal Laporan</th>
            <th>Status Keluhan</th>
            <th>Kategori</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
            <?php $no = 1; ?>
            @foreach ($dataKeluhan as $item)
            <tr>
            <td>{{  $no++ }}</td>
            <td>{{ $item->jenis_pengguna }}</td>
            <td>{{ $item->uraian_keluhan }}</a></td>
            <td>{{ date('j/m/Y H:m', strtotime($item->tgl_keluhan )) }}</td>
            <td class="text-center">
                @if ($item->status_keluhan == 'selesai')
                <span class="badge badge-pill badge-success mr-2">{{ $item->status_keluhan }}</span></td>
                @elseif ($item->status_keluhan == 'menunggu verifikasi')
                <span class="badge badge-pill badge-warning mr-2">{{ $item->status_keluhan }}</span></td>
                @else
                <span class="badge badge-pill badge-info mr-2">{{ $item->status_keluhan }}</span></td>
                @endif
            <td>{{ $item->kategori_keluhan }}</td>
            <td>
                <button class="btn btn-sm dropdown-toggle more-horizontal" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="text-muted sr-only">Action</span>
                </button>
                <div class="dropdown-menu dropdown-menu-right">

                <a href="/detail-keluhan/{{ $item->id_keluhan }}" class="dropdown-item">Detail</a>
                </div>
            </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <nav aria-label="Table Paging" class="mb-0 text-muted">
        <ul class="pagination justify-content-end mb-0">
            {{ $dataKeluhan->links('pagination::bootstrap-4') }}
        </ul>
    </nav>
    </div>
</div>
</div>
</div> <!-- end section -->
@endsection