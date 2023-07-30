@extends('layouts.main')
@section('content')
<h5 class="">Tambah Data Costumer Service</h5>
    <div class="col-md-6">
        <div class="card shadow mb-4">
        <div class="card-body">
            <form method="post" action="/input-datacs" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="" class="form-label">Nama</label>
                    <input type="text" class="form-control" id="" name="nama">
                </div>
                <div class="mb-3">
                    <label for="" class="form-label">Username</label>
                    <input type="text" class="form-control" id="" name="username">
                </div>
                <div class="mb-3">
                    <label for="" class="form-label">Email</label>
                    <input type="email" class="form-control" id="" name="email">
                </div>
                <div class="mb-3">
                    <label for="" class="form-label">Password</label>
                    <input type="password" class="form-control" id="" name="password">
                </div>
                <div class="mb-3">
                    <label for="" class="form-label">No. Telepon</label>
                    <input type="text" class="form-control" id="" name="no_telepon">
                </div>
                
                <a href="/dashboard" class="btn btn-secondary">Kembali</a>
                <button type="submit" class="btn btn-primary">Tambah</button>
            </form>
        </div> <!-- /.card-body -->
    </div> <!-- /.card -->
</div> <!-- /.col -->
@endsection