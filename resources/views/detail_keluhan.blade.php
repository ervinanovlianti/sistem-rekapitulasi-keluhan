@extends('layouts.main')
@section('content')
<div class="row">
  <div class="row justify-content-center">
    <div class="col-12">
      <h3 class="page-title">Detail Keluhan {{ $keluhan->id_keluhan }}</h3>
      @if ( $keluhan->status_keluhan == 'menunggu verifikasi')
        <div class="row">
        <div class="col-6 my-2">
          <div class="card shadow">
            <div class="card-body">
                <p>Nama Pelapor     : {{ $keluhan->nama }}</p>
                <p>Costumer         : {{ $keluhan->nama }}</p>
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
              <p>Status         : {{ $keluhan->status_keluhan }}</p>
              <p>Aksi           : {{ $keluhan->aksi }}</p>
              <a href="/keluhan" class="btn btn-secondary m-auto">Kembali</a>
              {{-- <a href="" class="btn btn-danger m-auto">Tolak</a> --}}
              <a href="/verifikasi-keluhan/{{ $keluhan->id_keluhan }}" class="btn btn-success m-auto">Verifikasi</a>
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
                <p>Costumer         : {{ $keluhan->nama }}</p>
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
              <p>Aksi           : {{ $keluhan->aksi }}</p>
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
              <p>Costumer        : {{ $keluhan->nama }}</p>
              <p>Tanggal Laporan : {{ $keluhan->tgl_keluhan }}</p>
              <p>Via Laporan     : {{ $keluhan->via_keluhan }}</p>
              <p>Gambar          : <a href="" class="btn btn-sm btn-primary">Lihat Gambar</a></p> 
            </div>
          </div>
        </div>
        <div class="col-md-6 my-2">
          <div class="card shadow">
            <div class="card-body">
              <p>Uraian Keluhan :  {{ $keluhan->nama }}</p>
              <p>Kategori       :  {{ $keluhan->kategori_keluhan }}</p>
              <p>Status         :  {{ $keluhan->status_keluhan }}</p>
              <p>Aksi           :  {{ $keluhan->aksi }}</p>
              <a href="" class="btn btn-secondary m-auto">Kembali</a>
              <a href="/keluhan-selesai/{{ $keluhan->id_keluhan }}" class="btn btn-success m-auto">Konfirmasi Selesai</a>
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
              <p>Costumer        : {{ $keluhan->nama }}</p>
              <p>Tanggal Laporan : {{ $keluhan->tgl_keluhan }}</p>
              <p>Via Laporan     : {{ $keluhan->via_keluhan }}</p>
              <p>Gambar          : <a href="" class="btn btn-sm btn-primary">Lihat Gambar</a></p> 
            </div>
          </div>
        </div>
        <div class="col-md-6 my-2">
          <div class="card shadow">
            <div class="card-body">
              <p>Uraian Keluhan :  {{ $keluhan->nama }}</p>
              <p>Kategori       :  {{ $keluhan->kategori_keluhan }}</p>
              <p>Status         :  {{ $keluhan->status_keluhan }}</p>
              <p>Aksi           :  {{ $keluhan->aksi }}</p>
            </div>
          </div>
        </div>
      </div>
      @endif
      
    </div>
@endsection