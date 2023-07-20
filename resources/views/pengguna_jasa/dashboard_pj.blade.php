@extends('cs.layout.main')
@section('content-cs')
<div class="row justify-content-center">
    <div class="col-12">
    <div class="row align-items-center mb-2">
        <div class="col">
        <h2 class="h5 page-title">Welcome Ervina!</h2>
        </div>
        <div class="col-auto">
        <form class="form-inline">
            <div class="form-group d-none d-lg-inline">
            <label for="reportrange" class="sr-only">Date Ranges</label>
            <div id="reportrange" class="px-2 py-2 text-muted">
                <span class="small"></span>
            </div>
            </div>
            <div class="form-group">
            <button type="button" class="btn btn-sm"><span class="fe fe-refresh-ccw fe-16 text-muted"></span></button>
            <button type="button" class="btn btn-sm mr-2"><span class="fe fe-filter fe-16 text-muted"></span></button>
            </div>
        </form>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 col-xl-3 mb-4">
            <div class="card shadow bg-primary text-white border-0">
            <div class="card-body">
                <div class="row align-items-center">
                <div class="col-3 text-center">
                    <span class="circle circle-sm bg-primary-light">
                    <i class="fe fe-16 fe-shopping-bag text-white mb-0"></i>
                    </span>
                </div>
                <div class="col pr-0">
                    <p class="small text-muted mb-0">Keluhan Baru</p>
                    <span class="h3 mb-0 text-white">1</span>
                    {{-- <span class="small text-muted">+5.5%</span> --}}
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
                    <span class="h3 mb-0">2</span>
                    {{-- <span class="small text-success">+16.5%</span> --}}
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
                        <span class="h3 mr-2 mb-0">12 </span>
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
                    <span class="h3 mb-0">15</span>
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
                <div class="list-group-item">
                <div class="row align-items-center">
                    <div class="col-auto">
                    <span class="circle circle-sm bg-warning"><i class="fe fe-shield-off fe-16 text-white"></i></span>
                    </div>
                    <div class="col">
                    <small><strong>11:00 April 16, 2020</strong></small>
                    <div class="mb-2 text-muted small">Lorem ipsum dolor sit amet, <strong>consectetur adipiscing</strong>
                        elit. Integer dignissim nulla eu quam cursus placerat. Vivamus non odio ullamcorper, lacinia ante nec,
                        blandit leo. </div>
                    <span class="badge badge-pill badge-warning">Security</span>
                    </div>
                    <div class="col-auto pr-0">
                    <small class="fe fe-more-vertical fe-16 text-muted"></small>
                    </div>
                </div> <!-- / .row -->
                </div><!-- / .list-group-item -->
                <div class="list-group-item">
                <div class="row align-items-center">
                    <div class="col-auto">
                    <span class="circle circle-sm bg-success"><i class="fe fe-database fe-16 text-white"></i></span>
                    </div>
                    <div class="col">
                    <small><strong>17:00 April 15, 2020</strong></small>
                    <div class="mb-2 text-muted small">Proin porta vel erat suscipit luctus. Cras rhoncus felis sed magna
                        commodo, in <a href="#!">pretium</a> mauris faucibus. Cras rhoncus felis sed magna commodo, in pretium
                        mauris faucibus.</div>
                    <span class="badge badge-pill badge-success">System Update</span>
                    </div>
                    <div class="col-auto pr-0">
                    <small class="fe fe-more-vertical fe-16 text-muted"></small>
                    </div>
                </div> <!-- / .row -->
                </div><!-- / .list-group-item -->
                <div class="list-group-item">
                <div class="row align-items-center">
                    <div class="col-auto">
                    <span class="circle circle-sm bg-secondary"><i class="fe fe-user-plus fe-16 text-white"></i></span>
                    </div>
                    <div class="col">
                    <small><strong>17:00 April 10, 2020</strong></small>
                    <div class="mb-2 text-muted small"> Morbi id arcu convallis, eleifend justo tristique, tincidunt nisl.
                        Morbi euismod fermentum quam, at fringilla elit posuere a. <strong>Aliquam</strong> accumsan mi
                        venenatis risus fermentum, at sagittis velit fermentum.</div>
                    <span class="badge badge-pill badge-secondary">Users</span>
                    </div>
                    <div class="col-auto pr-0">
                    <small class="fe fe-more-vertical fe-16 text-muted"></small>
                    </div>
                </div> <!-- / .row -->
                </div><!-- / .list-group-item -->
            </div> <!-- / .list-group -->
            </div> <!-- / .card-body -->
        </div> <!-- / .card -->
        </div> <!-- / .col -->
        <!-- Recent Activity -->
        <div class="col-md-12 col-lg-12 mb-4">
        <div class="card timeline shadow">
            <div class="card-header">
            <strong class="card-title">Aktivitas Terbaru</strong>
            <a class="float-right small text-muted" href="#!">View all</a>
            </div>
            <div class="card-body" data-simplebar style="height:355px; overflow-y: auto; overflow-x: hidden;">
            <h6 class="text-uppercase text-muted mb-4">Today</h6>
            <div class="pb-3 timeline-item item-primary">
                <div class="pl-5">
                <div class="mb-1"><strong>@username</strong><span class="text-muted small mx-2">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Placeat alias itaque repudiandae nobis suscipit consequuntur autem deserunt aliquam, similique neque minima?</div>
                <p class="small text-muted">Pembayaran<span class="badge badge-light">1 menit yang lalu</span>
                </p>
                </div>
            </div>
            <div class="pb-3 timeline-item item-warning">
                <div class="pl-5">
                <div class="mb-3"><strong>@username</strong><span class="text-muted small mx-2">Lorem ipsum dolor sit amet consectetur adipisicing elit. Provident ipsam dolore iure aliquid laborum cumque minima adipisci iste veritatis, natus sunt nihil dolorum aspernatur tempora? Modi architecto aspernatur quibusdam sed officiis sunt.</strong></div>
                <p class="small text-muted">Keterlambatan Pengiriman <span class="badge badge-light">15 menit yang lalu</span>
                </p>
                </div>
            </div>
            <div class="pb-3 timeline-item item-success">
                <div class="pl-5">
                <div class="mb-3"><strong>@Kelley Sonya</strong><span class="text-muted small mx-2">has commented on</span><strong>Advanced table</strong></div>
                <div class="card d-inline-flex mb-2">
                    <div class="card-body bg-light py-2 px-3 small rounded"> Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer dignissim nulla eu quam cursus placerat. Vivamus non odio ullamcorper, lacinia ante nec, blandit leo. </div>
                </div>
                <p class="small text-muted">Back-End Development <span class="badge badge-light">1h ago</span>
                </p>
                </div>
            </div>
            <h6 class="text-uppercase text-muted mb-4">Yesterday</h6>
            <div class="pb-3 timeline-item item-warning">
                <div class="pl-5">
                <div class="mb-3"><strong>@Fletcher Everett</strong><span class="text-muted small mx-2">created new group for</span><strong>Tiny Admin</strong></div>
                <ul class="avatars-list mb-3">
                    <li>
                    <a href="#!" class="avatar avatar-sm">
                        <img alt="..." class="avatar-img rounded-circle" src="./assets/avatars/face-1.jpg">
                    </a>
                    </li>
                    <li>
                    <a href="#!" class="avatar avatar-sm">
                        <img alt="..." class="avatar-img rounded-circle" src="./assets/avatars/face-4.jpg">
                    </a>
                    </li>
                    <li>
                    <a href="#!" class="avatar avatar-sm">
                        <img alt="..." class="avatar-img rounded-circle" src="./assets/avatars/face-3.jpg">
                    </a>
                    </li>
                </ul>
                <p class="small text-muted">Front-End Development <span class="badge badge-light">1h ago</span>
                </p>
                </div>
            </div>
            <div class="pb-3 timeline-item item-success">
                <div class="pl-5">
                <div class="mb-3"><strong>@Bertha Ball</strong><span class="text-muted small mx-2">has commented on</span><strong>Advanced table</strong></div>
                <div class="card d-inline-flex mb-2">
                    <div class="card-body bg-light py-2 px-3"> Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer dignissim nulla eu quam cursus placerat. Vivamus non odio ullamcorper, lacinia ante nec, blandit leo. </div>
                </div>
                <p class="small text-muted">Back-End Development <span class="badge badge-light">1h ago</span>
                </p>
                </div>
            </div>
            <div class="pb-3 timeline-item item-danger">
                <div class="pl-5">
                <div class="mb-3"><strong>@Lillith Joseph</strong><span class="text-muted small mx-2">has upload new files to</span><strong>Tiny Admin</strong></div>
                <div class="row mb-3">
                    <div class="col"><img src="./assets/products/p4.jpg" alt="..." class="img-fluid rounded"></div>
                    <div class="col"><img src="./assets/products/p1.jpg" alt="..." class="img-fluid rounded"></div>
                    <div class="col"><img src="./assets/products/p2.jpg" alt="..." class="img-fluid rounded"></div>
                </div>
                <p class="small text-muted">Front-End Development <span class="badge badge-light">1h ago</span>
                </p>
                </div>
            </div>
            </div> <!-- / .card-body -->
        </div> <!-- / .card -->
        </div> <!-- / .col-md-6 -->
    </div> <!-- .row-->

    </div> <!-- .col-12 -->
</div> <!-- .row -->
@endsection