@extends('template')
@section('content')

<!-- widgets -->
    <div class="row my-4">
        <div class="col-md-3">
            <div class="card shadow mb-4">
                <div class="card-body">
                <div class="row align-items-center">
                    <div class="col">
                    <small class="text-muted mb-1">Keluhan Baru</small>
                    <h3 class="card-title mb-0">10</h3>
                    <p class="small text-muted mb-0"><span class="fe fe-arrow-down fe-12 text-danger"></span><span></span></p>
                    </div>
                    <div class="col-4 text-right">
                    <span class="sparkline inlineline"></span>
                    </div>
                </div> <!-- /. row -->
                </div> <!-- /. card-body -->
            </div> <!-- /. card -->
        </div> <!-- /. col -->
        <div class="col-md-3">
            <div class="card shadow mb-4">
                <div class="card-body">
                <div class="row align-items-center">
                    <div class="col">
                    <small class="text-muted mb-1">Keluhan Diproses</small>
                    <h3 class="card-title mb-0">230</h3>
                    <p class="small text-muted mb-0"><span class="fe fe-arrow-up fe-12 text-warning"></span><span></span></p>
                    </div>
                    <div class="col-4 text-right">
                    <span class="sparkline inlinepie"></span>
                    </div>
                </div> <!-- /. row -->
                </div> <!-- /. card-body -->
            </div> <!-- /. card -->
        </div> <!-- /. col -->
        <div class="col-md-3">
            <div class="card shadow mb-4">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col">
                            <small class="text-muted mb-1">Keluhan Selesai</small>
                            <h3 class="card-title mb-0">108</h3>
                            <p class="small text-muted mb-0"><span class="fe fe-arrow-up fe-12 text-success"></span><span></span></p>
                        </div>
                        <div class="col-4 text-right">
                            <span class="sparkline inlinebar"></span>
                        </div>
                    </div> <!-- /. row -->
                </div> <!-- /. card-body -->
            </div> <!-- /. card -->
        </div> <!-- /. col -->
        <div class="col-md-3">
            <div class="card shadow mb-4">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col">
                            <small class="text-muted mb-1">Total Keluhan</small>
                            <h3 class="card-title mb-0">108</h3>
                            <p class="small text-muted mb-0"><span class="fe fe-arrow-up fe-12 text-success"></span><span></span></p>
                        </div>
                        <div class="col-4 text-right">
                            <span class="sparkline inlinebar"></span>
                        </div>
                    </div> <!-- /. row -->
                </div> <!-- /. card-body -->
            </div> <!-- /. card -->
        </div> <!-- /. col -->
    </div> <!-- end section -->
@endsection