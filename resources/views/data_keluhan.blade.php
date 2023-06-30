@extends('layouts.main')
@section('content')
 <div class="row">
  <div class="col-md-12">
    <h2 class="h4 mb-1 text-center">Data Keluhan</h2>
    {{-- <p class="mb-3">Child rows with additional detailed information</p> --}}
    <a href="/input_data" class="btn btn-primary my-2">Tambah</a>
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
            <tr>
              <td>{{  $no++ }}</td>
              <td>PT Mutiara Permata</td>
              <td>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Excepturi ducimus exercitationem odio et maiores esse quod in aut? Deserunt tempore at vel inventore!</td>
              <td>28-06-2023 13:12:00</td>
              <td><span class="badge badge-pill badge-info mr-2">Diterima oleh CS</span><small class="text-muted"></small></td>
              <td>Pembayaran</td>
              <td><button class="btn btn-sm dropdown-toggle more-horizontal" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <span class="text-muted sr-only">Action</span>
                </button>
                <div class="dropdown-menu dropdown-menu-right">
                  {{-- <a class="dropdown-item" href="#">Edit</a> --}}
                  {{-- <a class="dropdown-item" href="#">Remove</a> --}}
                  <a class="dropdown-item" href="/detail_keluhan">Detail</a>
                </div>
              </td>
            </tr>
            <tr>
              <td>{{ $no++ }}</td>
              <td>PT Mutiara Permata</td>
              <td>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Excepturi ducimus exercitationem odio et maiores esse quod in aut? Deserunt tempore at vel inventore!</td>
              <td>28-06-2023 13:12:00</td>
              <td><span class="badge badge-pill badge-success mr-2">Selesai</span><small class="text-muted"></small></td>
              <td>Pembayaran</td>
              <td><button class="btn btn-sm dropdown-toggle more-horizontal" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <span class="text-muted sr-only">Action</span>
                </button>
                <div class="dropdown-menu dropdown-menu-right">
                  {{-- <a class="dropdown-item" href="#">Edit</a> --}}
                  {{-- <a class="dropdown-item" href="#">Remove</a> --}}
                  <a class="dropdown-item" href="/detail_keluhan">Detail</a>
                </div>
              </td>
            </tr>
            <tr>
              <td>{{ $no++ }}</td>
              <td>PT Mutiara Permata</td>
              <td>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Excepturi ducimus exercitationem odio et maiores esse quod in aut? Deserunt tempore at vel inventore!</td>
              <td>28-06-2023 13:12:00</td>
              <td><span class="badge badge-pill badge-info mr-2">Ditangani oleh CS</span><small class="text-muted"></small></td>
              <td>Pembayaran</td>
              <td><button class="btn btn-sm dropdown-toggle more-horizontal" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <span class="text-muted sr-only">Action</span>
                </button>
                <div class="dropdown-menu dropdown-menu-right">
                  {{-- <a class="dropdown-item" href="#">Edit</a> --}}
                  {{-- <a class="dropdown-item" href="#">Remove</a> --}}
                  <a class="dropdown-item" href="/detail_keluhan">Detail</a>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div> <!-- end section -->
@endsection