@extends('layouts.main')
@section('content')
<div class="row">
  <div class="row justify-content-center">
    <div class="col-12">
      <h3 class="page-title">Detail Keluhan {{ $keluhan->id_keluhan }}</h3>
      @if (Session::has('success'))
            <div class="alert alert-success">
                {{ Session::get('success') }}
            </div>
        @endif

        @if (Session::has('error'))
            <div class="alert alert-danger">
                {{ Session::get('error') }}
            </div>
        @endif
      @if ( $keluhan->status_keluhan == 'menunggu verifikasi')
        <div class="row">
        <div class="col-6 my-2">
          <div class="card shadow">
            <div class="card-body">
                <p>Nama Pelapor     : {{ $keluhan->nama }}</p>
                <p>Costumer         : {{ $keluhan->jenis_pengguna }}</p>
                <p>Tanggal Laporan  : {{ $keluhan->tgl_keluhan }}</p>
                <p>Via Laporan      : {{ $keluhan->via_keluhan }}</p>
                <p>Gambar           : <a href="" class="btn btn-sm btn-primary">Lihat Gambar</a></p> 
            </div>
          </div>
        </div>
        <div class="col-6 my-2">
          <div class="card shadow">
            <div class="card-body">
              <p>Uraian Keluhan : <strong>{{ $keluhan->uraian_keluhan }}</strong> </p>
              <p>Kategori       : {{ $keluhan->kategori_keluhan }}</p>
              <p>Status Keluhan      : {{ $keluhan->status_keluhan }}</p>
              {{-- <p>Aksi           : {{ $keluhan->aksi }}</p> --}}
              <a href="/keluhan" class="btn btn-secondary m-auto">Kembali</a>
              {{-- <a href="" class="btn btn-danger m-auto">Tolak</a> --}}
              <button type="button" class="btn btn-success m-auto" data-toggle="modal" data-target="#verifikasiModal" data-whatever="@mdo">Verifikasi</button>
            </div>
          </div>
        </div>
      </div>
      @elseif ( $keluhan->status_keluhan == 'dialihkan ke cs')
          <div class="row">
        <div class="col-md-6 my-2">
          <div class="card shadow">
            <div class="card-body">
                <p>Nama Pelapor     : {{ $keluhan->nama }}</p>
                <p>Costumer         : {{ $keluhan->jenis_pengguna }}</p>
                <p>Tanggal Laporan  : {{ $keluhan->tgl_keluhan }}</p>
                <p>Via Laporan      : {{ $keluhan->via_keluhan }}</p>
                <p>Gambar           : <a href="" class="btn btn-sm btn-primary">Lihat Gambar</a></p> 
            </div>
          </div>
        </div>
        <div class="col-md-6 my-2">
          <div class="card shadow">
            <div class="card-body">
              <p>Uraian Keluhan : <strong>{{ $keluhan->uraian_keluhan }}</strong> </p>
              <p>Kategori       : {{ $keluhan->kategori_keluhan }}</p>
              <p>Status         : {{ $keluhan->status_keluhan }}</p>
              {{-- <p>Aksi           : {{ $keluhan->aksi }}</p> --}}
              <a href="" class="btn btn-secondary m-auto">Kembali</a>
              <a href="/terima-keluhan/{{ $keluhan->id_keluhan }}" class="btn btn-success m-auto">Terima</a>
            </div>
          </div>
        </div>
      </div>
      @elseif ( $keluhan->status_keluhan == 'ditangani oleh cs')
      <div class="row">
        <div class="col-md-6 my-2">
          <div class="card shadow">
            <div class="card-body">
              <p>Nama Pelapor    : {{ $keluhan->nama }}</p>
              <p>Costumer        : {{ $keluhan->jenis_pengguna }}</p>
              <p>Tanggal Laporan : {{ $keluhan->tgl_keluhan }}</p>
              <p>Via Laporan     : {{ $keluhan->via_keluhan }}</p>
              <p>Gambar          : <a href="" class="btn btn-sm btn-primary">Lihat Gambar</a></p> 
            </div>
          </div>
        </div>
        <div class="col-md-6 my-2">
          <div class="card shadow">
            <div class="card-body">
              <p>Uraian Keluhan :  <strong>{{ $keluhan->uraian_keluhan }}</strong></p>
              <p>Kategori       :  {{ $keluhan->kategori_keluhan }}</p>
              <p>Status         :  {{ $keluhan->status_keluhan }}</p>
              {{-- <p>Aksi           :  {{ $keluhan->aksi }}</p> --}}
              <a href="" class="btn btn-secondary m-auto">Kembali</a>
              <button type="button" class="btn btn-success m-auto" data-toggle="modal" data-target="#konfirmasiModal" data-whatever="@mdo">Konfirmasi</button>
            </div>
          </div>
        </div>
      </div>
      @else
      <div class="row">
        <div class="col-md-6 my-2">
          <div class="card shadow">
            <div class="card-body">
              <p>Nama Pelapor    : {{ $keluhan->nama }}</p>
              <p>Costumer        : {{ $keluhan->jenis_pengguna }}</p>
              <p>Tanggal Laporan : {{ $keluhan->tgl_keluhan }}</p>
              <p>Via Laporan     : {{ $keluhan->via_keluhan }}</p>
              <p>Gambar          : <a href="" class="btn btn-sm btn-primary">Lihat Gambar</a></p> 
            </div>
          </div>
        </div>
        <div class="col-md-6 my-2">
          <div class="card shadow">
            <div class="card-body">
              <p>Uraian Keluhan :  {{ $keluhan->uraian_keluhan }}</p>
              <p>Kategori       :  {{ $keluhan->kategori_keluhan }}</p>
              <p>Status         :  {{ $keluhan->status_keluhan }}</p>
              <p>Waktu Penyelesaian         :  {{ $keluhan->waktu_penyelesaian }}</p>
              <p>Aksi           :  {{ $keluhan->aksi }}</p>
            </div>
          </div>
        </div>
      </div>
      @endif
    </div>

    {{-- Modal Verifkasi --}}
    <div class="modal fade" id="verifikasiModal" tabindex="-1" role="dialog" aria-labelledby="verifikasiModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="verifikasiModalLabel">Verifikasi Keluhan</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          
          <form method="POST" action="/verifikasi-keluhan">
          @csrf
          <div class="modal-body">
              <div class="form-group">
                <input type="hidden" name="id_keluhan" value="{{ $keluhan->id_keluhan }}">
                <label for="example-select"></label>
                    <select class="form-control" id="example-select" name="penanggungjawab">
                        <option selected>--Pilih--</option>
                        @foreach ($cs as $item)
                        <option value="{{ $item->nama }}">{{ $item->nama }}</option>
                        @endforeach
                    </select>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn mb-2 btn-secondary" data-dismiss="modal">Kembali</button>
              <button type="submit" class="btn btn-success m-auto">Verifikasi</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    {{-- Konfirmasi Selesai --}}
    <div class="modal fade" id="konfirmasiModal" tabindex="-1" role="dialog" aria-labelledby="konfirmasiModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="konfirmasiModalLabel">Konfirmasi Selesai</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          
          <form method="POST" action="/konfirmasi-selesai">
          @csrf
          <div class="modal-body">
              <div class="form-group">
                <input type="hidden" name="id_keluhan" value="{{ $keluhan->id_keluhan }}">
                <label for="message-text" class="col-form-label">Keterangan Aksi Penyelesaian:</label>
                <textarea class="form-control"  name="aksi"></textarea>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn mb-2 btn-secondary" data-dismiss="modal">Kembali</button>
              <button type="submit" class="btn btn-success m-auto">Konfirmasi</button>
            </div>
          </form>
        </div>
      </div>
    </div>
</div>
@endsection