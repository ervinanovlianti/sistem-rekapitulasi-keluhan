@extends('layouts.main')
@section('content')
 <div class="row">
  <div class="col-md-12">
    <h2 class="h4 mb-1 text-center">Data Keluhan</h2>
    {{-- <p class="mb-3">Child rows with additional detailed information</p> --}}
    <a href="/input_keluhan" class="btn btn-primary my-2">Tambah</a>
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
              @foreach ($data_keluhan as $item)
              <tr>
                <td>{{  $no++ }}</td>
                <td></td>
                <td><a href="/perhitungan-naive-bayes">{{ $item->uraian_keluhan }}</a></td>
                <td>{{ $item->tgl_keluhan }}</td>
                <td class="text-center"><span class="badge badge-pill badge-info mr-2">{{ $item->status_keluhan }}</span></td>
                <td>{{ $item->kategori_keluhan }}</td>
                <td>
                  <button class="btn btn-sm dropdown-toggle more-horizontal" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="text-muted sr-only">Action</span>
                  </button>
                  <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item" href="#">Tangani</a>
                  </div>
                </td>
              </tr>
              @endforeach
          </tbody>
        </table>
        {{-- <nav aria-label="Table Paging" class="mb-0 text-muted">
            <ul class="pagination justify-content-end mb-0">
                <li class="page-item"><a class="page-link" href="#">Previous</a></li>
                <li class="page-item"><a class="page-link" href="#">1</a></li>
                <li class="page-item"><a class="page-link" href="#">2</a></li>
                <li class="page-item"><a class="page-link" href="#">3</a></li>
                <li class="page-item"><a class="page-link" href="#">Next</a></li>
            </ul>
        </nav> --}}
      </div>
    </div>
  </div>
</div> <!-- end section -->
@endsection