@extends('layouts.main')
@section('content')
<div class="row justify-content-center">
    <div class="col-12">
    <div class="row align-items-center mb-2">
        <div class="col">
        <h2 class="h5 page-title">Welcome Ervina!</h2>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 col-xl-3 mb-4">
            <div class="card shadow border-0">
            <div class="card-body">
                <div class="row align-items-center">
                <div class="col-3 text-center">
                    <span class="circle circle-sm bg-primary">
                    <i class="fe fe-16 fe-shopping-bag text-white mb-0"></i>
                    </span>
                </div>
                <div class="col pr-0">
                    <p class="small text-muted mb-0">Keluhan Baru</p>
                    <span class="h3 mb-0 ">{{ $keluhanBaru }}</span>
                </div>
                </div>
            </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-3 mb-4">
            <div class="card shadow border-0">
            <div class="card-body">
                <div class="row align-items-center">
                <div class="col-3 text-center">
                    <span class="circle circle-sm bg-primary">
                    <i class="fe fe-16 fe-shopping-cart text-white mb-0"></i>
                    </span>
                </div>
                <div class="col pr-0">
                    <p class="small text-muted mb-0">Keluhan Diproses</p>
                    <span class="h3 mb-0">{{ $keluhanDiproses }} </span>
                </div>
                </div>
            </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-3 mb-4">
            <div class="card shadow border-0">
            <div class="card-body">
                <div class="row align-items-center">
                <div class="col-3 text-center">
                    <span class="circle circle-sm bg-primary">
                    <i class="fe fe-16 fe-filter text-white mb-0"></i>
                    </span>
                </div>
                <div class="col">
                    <p class="small text-muted mb-0">Keluhan Selesai</p>
                    <div class="row align-items-center no-gutters">
                    <div class="col-auto">
                        <span class="h3 mr-2 mb-0">{{ $keluhanSelesai }} </span>
                    </div>
                    </div>
                </div>
                </div>
            </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-3 mb-4">
            <div class="card shadow border-0">
            <div class="card-body">
                <div class="row align-items-center">
                <div class="col-3 text-center">
                    <span class="circle circle-sm bg-primary">
                    <i class="fe fe-16 fe-activity text-white mb-0"></i>
                    </span>
                </div>
                <div class="col">
                    <p class="small text-muted mb-0">Total Keluhan</p>
                    <span class="h3 mb-0">{{ $totalKeluhan }}</span>
                </div>
                </div>
            </div>
            </div>
        </div>
    </div> 
    <div class="row">
        <!-- Log -->
        <div class="col-md-12 mb-4">
        <div class="card shadow">
            <div class="card-header">
            <strong class="card-title">Keluhan Terbaru</strong>
            <a class="float-right small text-muted" href="#!">View all</a>
            </div>
            <div class="card-body">
            <div class="list-group list-group-flush my-n3">
                @if(count($keluhanHariIni) > 0)
                <div class="list-group-item">
                    @foreach($keluhanHariIni as $keluhan)
                    <div class="row align-items-center">
                        <div class="col-auto">
                            <span class="circle circle-sm bg-warning"><i class="fe fe-inbox fe-16 text-white"></i></span>
                        </div>
                        <div class="col">
                            <small><strong>{{ $keluhan->tgl_keluhan }}</strong></small>
                            <div class="mb-2 text-muted small"><strong>{{ $keluhan->uraian_keluhan }}</strong></div>
                                @if ($keluhan->status_keluhan == 'selesai')
                                    <span class="badge badge-pill badge-success mr-2">{{ $keluhan->status_keluhan }}</span></td>
                                @elseif ($keluhan->status_keluhan == 'menunggu verifikasi')
                                    <span class="badge badge-pill badge-warning mr-2">{{ $keluhan->status_keluhan }}</span></td>
                                @else
                                    <span class="badge badge-pill badge-info mr-2">{{ $keluhan->status_keluhan }}</span></td>
                                @endif
                            </div>
                        <div class="col-auto pr-0">
                            <small class="fe fe-more-vertical fe-16 text-muted"></small>
                        </div>
                    </div> <!-- / .row -->
                    <hr>
                    @endforeach
                </div><!-- / .list-group-item -->
                @else
                    <p>Tidak ada keluhan yang tercatat hari ini.</p>
                @endif
                </div><!-- / .list-group-item -->
            </div> <!-- / .list-group -->
            </div> <!-- / .card-body -->
        </div> <!-- / .card -->
        </div> <!-- / .col -->
        <!-- Recent Activity -->
    </div> <!-- .row-->

    </div> <!-- .col-12 -->
</div> <!-- .row -->
@endsection