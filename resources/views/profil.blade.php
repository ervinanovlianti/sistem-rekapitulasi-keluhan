@extends('layouts.main')
@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
    <div class="col-12">
        <h2 class="h3 mb-4 page-title">Profil</h2>
        <div class="row mt-5 align-items-center">
        <div class="col-md-3 text-center mb-5">
            <div class="avatar avatar-xl">
            <img src="{{ asset('admin/./assets/avatars/face-1.jpg') }}" alt="..." class="avatar-img rounded-circle">
            </div>
        </div>
        <div class="col">
            <div class="row align-items-center">
            <div class="col-md-7">
                <h4 class="mb-1">{{ auth()->user()->nama }}</h4>
                {{-- <p class="small mb-3"><span class="badge badge-dark">New York, USA</span></p> --}}
            </div>
            </div>
            <div class="row mb-4">
                <div class="col-md-7">
                    <p class="text-muted">{{ auth()->user()->hak_akses }}</p>
                    <p class="text-muted"> {{ auth()->user()->email }}</p>
                </div>
            </div>
        </div>
    </div> <!-- /.col-12 -->
    </div> <!-- .row -->
    </div> <!-- .container-fluid -->
{{-- <h5>Profil User</h5>
<div class="col-md-6">
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="list-group list-group-flush my-n3">
                <div class="list-group-item">
                    <div class="row align-items-center">
                        <div class="col">
                            <strong>Nama User</strong>
                        </div>
                        <div class="col-auto">
                            <strong>Ervina Novlianti</strong>
                        </div>
                    </div>
                    <div class="row align-items-center">
                        <div class="col">
                            <strong>Email</strong>
                        </div>
                        <div class="col-auto">
                            <strong>ervina@gmail.com</strong>
                        </div>
                    </div>
                    <div class="row align-items-center">
                        <div class="col">
                            <strong>No. Telepon</strong>
                        </div>
                        <div class="col-auto">
                            <strong>1234567890</strong>
                        </div>
                    </div>
                    <div class="row align-items-center">
                        <div class="col">
                            <strong>Status User</strong>
                        </div>
                        <div class="col-auto">
                            <strong>Administrator</strong>
                        </div>
                    </div>
                </div>
            </div> <!-- / .list-group -->
        </div> <!-- / .card-body -->
    </div> <!-- .card -->
</div> <!-- .col --> --}}
@endsection