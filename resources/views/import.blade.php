@extends('layouts.main')
@section('content')
<h5 class="">Input Data Keluhan</h5>
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
<div class="col-md-6">
    <div class="card shadow mb-4">
        <div class="card-header">
            <strong class="card-title">Input Keluhan Pengguna Jasa</strong>
        </div>
        <div class="card-body">
            <form action="/import-data" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="" class="form-label">File Excel</label>
                    <input type="file" name="file" class="form-control" accept=".xls,.xlsx">
                </div>
                <button type="submit" class="btn btn-primary">Import</button>
            </form>

        </div>
    </div>
</div>


@endsection