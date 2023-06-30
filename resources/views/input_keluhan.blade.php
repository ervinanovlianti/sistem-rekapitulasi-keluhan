@extends('layouts.main')
@section('content')
<h5 class="text-center">Input Data Keluhan</h5>
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
                <select class="form-select" aria-label="Default select example">
                    <option selected>Jenis</option>
                    <option value="1">Perseorangan</option>
                    <option value="2">Perusahaan</option>
                </select>
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
                 <select class="form-select" aria-label="Default select example">
                    <option selected>Via Keluhan</option>
                    <option value="1">Wa/Hp</option>
                    <option value="2">Web</option>
                    <option value="3">Visit</option>
                    <option value="4">Talkie/Walkie</option>
                </select>
                <div class="mb-3">
                    <label for="" class="form-label">Uraian Masalah</label>
                    <input type="text" class="form-control" id="">
                </div>
                <div class="mb-3">
                    <label for="" class="form-label">File/Gambar</label>
                    <input type="file" class="form-control" id="">
                </div>
                <a type="kembali" class="btn btn-primary">Kembali</a>
                <a type="submit" class="btn btn-primary">Submit</a>
            </form>
        </div> <!-- /.card-body -->
        </div> <!-- /.card -->
                </div> <!-- /.col -->
@endsection