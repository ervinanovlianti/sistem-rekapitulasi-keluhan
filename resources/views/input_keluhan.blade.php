@extends('layouts.main')
@section('content')
<h5 class="">Input Data Keluhan</h5>
<div class="col-md-6">
    <div class="card shadow mb-4">
        <div class="card-header">
            <strong class="card-title">Input Keluhan Pengguna Jasa</strong>
        </div>
        <div class="card-body">
            <form>
                <div class="mb-3">
                    <label for="" class="form-label">Tanggal Keluhan</label>
                    <input type="text" class="form-control" name="tgl_keluhan" id="exampleInputEmail1"
                        aria-describedby="" value="{{ date(" Y-m-d h:i:sa") }}">
                </div>
                {{-- Identitas Pengguna Jasa --}}
                <div class="mb-3">
                    <label for="" class="form-label">Nama Pelapor</label>
                    <input type="text" class="form-control" id="" name="nama_pengguna">
                </div>
                <div class="mb-3">
                    <label for="" class="form-label">No. Telepon</label>
                    <input type="text" class="form-control" id="">
                </div>
                <div class="form-group mb-3">
                    <label for="example-select">Jenis Customer</label>
                    <select class="form-control" id="example-select" name="jenis_costumer">
                        <option>--Pilih--</option>
                        <option value="Perusahaan">Perusahaan</option>
                        <option value="Perseorangan">Perseorangan</option>
                    </select>
                </div>
                {{-- jika form select diisi dengan perusahaan muncul form tambahan --}}
                {{-- <div class="mb-3">
                    <label for="" class="form-label">Nama Perusahaan</label>
                    <input type="text" class="form-control" id="exampleInputPassword1">
                </div> --}}
                {{-- Akhir --}}

                {{-- Via Keluhan --}}
                {{-- Jika admin terdapat via keluhan --}}
                <div class="form-group mb-3">
                    <label for="example-select">Via Keluhan</label>
                    <select class="form-control" id="example-select" name="via_keluhan">
                        <option selected>--Pilih--</option>
                        <option value="Wa/Hp">Wa/Hp</option>
                        <option value="Web">Web</option>
                        <option value="Visit">Visit</option>
                        <option value="Talkie/Walkie">Talkie/Walkie</option>
                    </select>
                </div>
                {{-- Akhir via keluhan --}}
                {{-- Pelanggan (add properti hidden)--}}
                <div class="mb-3">
                    <label for="" class="form-label">Via Keluhan</label>
                    <input type="text" class="form-control" id="" placeholder="Website">
                </div>

                <div class="mb-3">
                    <label for="" class="form-label">Uraian Masalah</label>
                    <input type="text" class="form-control" id="" maxlength="280" name="uraian_keluhan">
                </div>
                {{-- Akhir pelanggan --}}
                {{-- <div class="mb-3">
                    <label for="" class="form-label">File/Gambar</label>
                    <input type="file" class="form-control" id="">
                </div> --}}
                <a href="" class="btn btn-secondary">Kembali</a>
                <button type="submit" href="" class="btn btn-primary">Tambah</button>
            </form>
        </div>
    </div>
</div>
@endsection