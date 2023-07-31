@extends('layouts.main')
@section('content')
<div class="row">
    <div class="col-md-12">
      <h2 class="h4 mb-1 text-center">Data Keluhan {{  $pengguna_jasa->nama  }}</h2>
      <div class="card shadow">
        <div class="card-body">
          <!-- table -->
          <table class="table table-hover table-borderless border-v">
            <thead class="thead-dark">
              <tr>
                <th>No</th>
                <th>Uraian Keluhan</th>
                <th>Tanggal Laporan</th>
                <th>Status Keluhan</th>
                <th>Kategori</th>
              </tr>
            </thead>
            <tbody>
                <?php $no = 1; ?>
                <tr>
                  <td>{{  $no++ }}</td>
                  <td>{{ $pengguna_jasa->uraian_keluhan }}</a></td>
                  <td>{{ $pengguna_jasa->tgl_keluhan }}</td>
                  <td class="text-center">
                    @if ($pengguna_jasa->status_keluhan == 'selesai')
                    <span class="badge badge-pill badge-success mr-2">{{ $pengguna_jasa->status_keluhan }}</span></td>
                    @elseif ($pengguna_jasa->status_keluhan == 'menunggu verifikasi')
                    <span class="badge badge-pill badge-warning mr-2">{{ $pengguna_jasa->status_keluhan }}</span></td>
                    @else
                    <span class="badge badge-pill badge-info mr-2">{{ $pengguna_jasa->status_keluhan }}</span></td>
                    @endif
                  <td>{{ $pengguna_jasa->kategori_keluhan }}</td>
                  
                </tr>
            </tbody>
          </table>
          <nav aria-label="Table Paging" class="mb-0 text-muted">
              <ul class="pagination justify-content-end mb-0">
                {{-- {{ $data_keluhan->links('pagination::bootstrap-4') }} --}}
              </ul>
          </nav>
        </div>
      </div>
    </div>
  </div> <!-- end section -->
@endsection