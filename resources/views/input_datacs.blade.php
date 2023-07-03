@extends('layouts.main')
@section('content')
<h5 class="">Tambah Data Costumer Service</h5>
    <div class="col-md-6">
        <div class="card shadow mb-4">
        <div class="card-body">
            <form>
                <div class="mb-3">
                    <label for="" class="form-label">Nama</label>
                    <input type="text" class="form-control" id="" name="nama_cs">
                </div>
                <div class="mb-3">
                    <label for="" class="form-label">No. Telepon</label>
                    <input type="text" class="form-control" id="">
                </div>
                <div class="mb-3">
                    <label for="" class="form-label">E-mail</label>
                    <input type="text" class="form-control" id="">
                </div>
                <div class="mb-3">
                    <label for="" class="form-label">Password</label>
                    <input type="text" class="form-control" id="">
                </div>
                <div class="form-group mb-3">
                    <label for="example-select">Departemen</label>
                    <select class="form-control" id="example-select">
                        <option>--Pilih--</option>
                        <option>IL</option>
                        <option>ILCS</option>
                    </select>
                </div>
                <a href="/" class="btn btn-secondary">Kembali</a>
                <a href="/" class="btn btn-primary">Tambah</a>
            </form>
        </div> <!-- /.card-body -->
    </div> <!-- /.card -->
</div> <!-- /.col -->
@endsection