
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
                    {{-- <input type="hidden" class="form-control" name="tgl_keluhan" id="" aria-describedby="" value="{{ date("Y-m-d h:i:sa") }}"> --}}
                    {{-- <label for="" class="form-label">Nama Pelapor</label>
                    <input type="text" class="form-control" id="" name="nama" placeholder="John" value="{{ auth()->user()->nama }}"> --}}
                </div>
                <div class="form-group mv-3">
                    <label for="uraian_keluhan">Uraian Keluhan</label>
                    <textarea id="uraian_keluhan" name="uraian_keluhan" class="form-control mb-4" rows="6" cols="50" maxlength="300"></textarea>
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