<nav class="topnav navbar navbar-light">
    <button type="button" class="navbar-toggler text-muted mt-2 p-0 mr-3 collapseSidebar">
    <i class="fe fe-menu navbar-toggler-icon"></i>
    </button>
    <h4>PT. PELINDO (PERSERO) TERMINAL PETIKEMAS NEW MAKASSAR</h4>
    <ul class="nav">
        {{-- <li class="nav-item nav-notif">
            <a class="nav-link text-muted my-2" href="/notifikasi" data-toggle="modal" data-target=".modal-notif">
            <span class="fe fe-bell fe-16"></span>
            <span class="dot dot-md bg-success"></span>
            </a>
        </li> --}}
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle text-muted pr-0" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="avatar avatar-sm mt-2">
                    <img src="{{ asset('foto_profil/profil-default.png') }}" alt="..." class="avatar-img rounded-circle">
                </span>
            </a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                <a class="dropdown-item" href="#">Profile</a>
                <a class="dropdown-item" href="/dashboard-cs">CS</a>
                <a class="dropdown-item" href="/dashboard-pj">Pengguna Jasa</a>
                <a class="dropdown-item">
                <form action="/logout" method="POST">
                    @csrf
                    <button>Logout</button>
                </form>
                </a>
                
            </div>
        </li>
    </ul>
</nav>

{{-- <div class="modal fade modal-notif modal-slide" tabindex="-1" role="dialog" aria-labelledby="defaultModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="defaultModalLabel">Notifikasi</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="list-group list-group-flush my-n3">
                <div class="list-group-item bg-transparent">
                    <div class="row align-items-center">
                    <div class="col-auto">
                        <span class="fe fe-box fe-24"></span>
                    </div>
                    <div class="col">
                        @foreach ($notifikasiKeluhan as $item)
                        <small><strong>{{ $item->id_pengguna }}</strong></small>
                        <div class="my-0 text-muted small">{{ $item->uraian_keluhan }}</div>
                        <small class="badge badge-pill badge-light text-muted">1m ago</small>
                            
                        @endforeach
                    </div>
                    </div>
                </div>
            </div> <!-- / .list-group -->
        </div>
        <div class="modal-footer">
            {{-- <button type="button" class="btn btn-secondary btn-block" data-dismiss="modal">Clear All</button> --}}
        </div>
        </div>
    </div>
</div>