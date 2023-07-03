@extends('layouts.main')
@section('content')
<h5 class="">Input Data Keluhan</h5>
     <div class="col-md-6">
        <div class="card shadow mb-4">
        {{-- <div class="card-header">
            <strong class="card-title">Input Keluhan Pengguna Jasa</strong>
        </div> --}}
        <div class="card-body">
            <form>
                <div class="mb-3">
                    <label for="" class="form-label">Tanggal Keluhan</label>
                    <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="" placeholder="{{ date('l, d-m-Y  H:i:s') }}">
                </div>
                <div class="mb-3">
                    <label for="" class="form-label">Nama Pelapor</label>
                    <input type="text" class="form-control" id="">
                </div>
                <div class="form-group mb-3">
                    <label for="example-select">Jenis Customer</label>
                    <select class="form-control" id="example-select">
                        <option>--Pilih--</option>
                        <option>Perusahaan</option>
                        <option>Perseorangan</option>
                    </select>
                </div>
                {{-- jika form select diisi dengan perusahaan muncul form tambahan --}}
                <div class="mb-3">
                    <label for="" class="form-label">Nama Perusahaan</label>
                    <input type="text" class="form-control" id="exampleInputPassword1">
                </div>
                <div class="mb-3">
                    <label for="" class="form-label">No. Telepon</label>
                    <input type="text" class="form-control" id="">
                </div>
                {{-- Akhir --}}
                {{-- Jika admin terdapat via keluhan --}}
                <div class="form-group mb-3">
                    <label for="example-select">Via Keluhan</label>
                    <select class="form-control" id="example-select">
                        <option selected>--Pilih--</option>
                        <option value="1">Wa/Hp</option>
                        <option value="2">Web</option>
                        <option value="3">Visit</option>
                        <option value="4">Talkie/Walkie</option>
                    </select>
                </div>
                {{-- Akhir via keluhan --}}

                {{-- Pelanggan (add properti hidden)--}}
                <div class="mb-3">
                    <label for="" class="form-label">Via Keluhan</label>
                    <input type="text" class="form-control" id="" placeholder="Website">
                </div>
                {{-- Akhir pelanggan --}}

                <div class="mb-3">
                    <label for="" class="form-label">Uraian Masalah</label>
                    <input type="text" class="form-control" id="" maxlength="280">
                </div>
                <div class="mb-3">
                    <label for="" class="form-label">File/Gambar</label>
                    <input type="file" class="form-control" id="">
                </div>
                <a href="" class="btn btn-secondary">Kembali</a>
                <a href="" class="btn btn-primary">Tambah</a>
            </form>
        </div> <!-- /.card-body -->
    </div> <!-- /.card -->
</div> <!-- /.col -->
@endsection