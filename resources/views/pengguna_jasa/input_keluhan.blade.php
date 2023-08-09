
@extends('layouts.main')
@section('content')
<div class="row">
<div class="col-md-6">
<h2 class="h4 mb-1">Masukkan Keluhan Anda</h2>
    <div class="card shadow mb-4 ">
        <div class="card-body">
            <form method="post" action="/simpan" id="dataForm" enctype="multipart/form-data">
                @csrf
            <div class="row">
            <div class="col-md-12">
                <div class="form-group mb-3">
                    <label for="uraian_keluhan">Uraian Keluhan</label>
                    <textarea id="uraian_keluhan" name="uraian_keluhan" class="form-control mb-4" rows="3" cols="50" maxlength="300"></textarea>
                </div>
                <div class="form-group mb-3">
                    <label>Gambar (Optional):</label>
                    <input type="file" class="form-control mb-4" name="gambar">
                </div>
                <button type="submit" class="btn btn-primary" >Submit</button>
            </div>
            </div>
            </form>
    </div> <!-- / .card -->
</div>
</div>
</div> 
@endsection