<aside class="sidebar-left border-right bg-white shadow" id="leftSidebar" data-simplebar>
    {{-- <a href="#" class="btn collapseSidebar toggle-btn d-lg-tne text-muted ml-2 mt-3" data-toggle="toggle">
    <i class="fe fe-x"><span class="sr-only"></span></i>
    </a> --}}
    <nav class="vertnav navbar navbar-light">
    <!-- nav bar -->
    <div class="w-100 mb-2 d-flex">
        <a class="navbar-brand mx-auto mt-2 flex-fill text-center" href="/">
            <img src="{{ asset('foto_profil/tpkm-pelindo.png') }}" alt="" width="200" height="50">
        </a>
    </div>
    {{-- Menu --}}
    <ul class="navbar-nav flex-fill w-100 mb-2">
        @if(Auth::user()->hak_akses === 'admin')
        <li class="nav-item">
        <a href="/dashboard" aria-expanded="false" class="nav-link">
            <i class="fe fe-home fe-16"></i>
            <span class="ml-3 item-text">Dashboard</span>
        </a>
        </li>
        @endif
        @if(Auth::user()->hak_akses === 'customer_service')
        <li class="nav-item">
        <a href="/dashboard-cs" aria-expanded="false" class="nav-link">
            <i class="fe fe-home fe-16"></i>
            <span class="ml-3 item-text">Dashboard</span>
        </a>
        </li>
        @endif
        @if(Auth::user()->hak_akses === 'pengguna_jasa')
        <li class="nav-item">
        <a href="/dashboard-pj" aria-expanded="false" class="nav-link">
            <i class="fe fe-home fe-16"></i>
            <span class="ml-3 item-text">Dashboard</span>
        </a>
        </li>
        @endif
        <p class="text-muted nav-heading mt-1 mb-1">
            <span>Menu</span>
        </p>
        @if(Auth::user()->hak_akses === 'admin')
        <li class="nav-item">
        <a href="/complaints" aria-expanded="false" class="nav-link">
            <i class="fe fe-file fe-16"></i>
            <span class="ml-3 item-text">Keluhan</span>
        </a>
        </li>
        <li class="nav-item">
        <a href="/service-users" aria-expanded="false" class="nav-link">
            <i class="fe fe-users fe-16"></i>
            <span class="ml-3 item-text">Pelanggan</span>
        </a>
        </li>
        <li class="nav-item">
        <a href="/cs" aria-expanded="false" class="nav-link">
            <i class="fe fe-user-check fe-16"></i>
            <span class="ml-3 item-text">Costumer Service</span>
        </a>
        </li>
        @endif

        @if(Auth::user()->hak_akses === 'pengguna_jasa')
        <li class="nav-item">
        <a href="/data-keluhan" aria-expanded="false" class="nav-link">
            <i class="fe fe-file fe-16"></i>
            <span class="ml-3 item-text">Keluhan</span>
        </a>
        </li>
        @endif
        @if(Auth::user()->hak_akses === 'customer_service')
        <li class="nav-item">
        <a href="/datakeluhan" aria-expanded="false" class="nav-link">
            <i class="fe fe-file fe-16"></i>
            <span class="ml-3 item-text">Keluhan</span>
        </a>
        </li>
        @endif


        @if(Auth::user()->hak_akses === 'admin')
        <p class="text-muted nav-heading mt-1 mb-1">
            <span>Laporan</span>
        </p>
        <li class="nav-item">
        <a href="/laporan" aria-expanded="false" class="nav-link">
            <i class="fe fe-printer fe-16"></i>
            <span class="ml-3 item-text">Laporan</span>
        </a>
        </li>

        <li class="nav-item">
        <a href="/rekapitulasi" aria-expanded="false" class="nav-link">
            <i class="fe fe-file-text fe-16"></i>
            <span class="ml-3 item-text">Rekapitulasi</span>
        </a>
        </li>
        @endif

        <p class="text-muted nav-heading mt-1 mb-1">
            <span>User</span>
        </p>
        {{-- @if(Auth::user()->hak_akses === 'admin') --}}
        <li class="nav-item">
        <a href="/profil" aria-expanded="false" class="nav-link">
            <i class="fe fe-user fe-16"></i>
            <span class="ml-3 item-text">Profil</span>
        </a>
        </li>
        {{-- @endif --}}
        {{-- @if(Auth::user()->hak_akses === 'pengguna_jasa')
        <li class="nav-item">
        <a href="/profil" aria-expanded="false" class="nav-link">
            <i class="fe fe-user fe-16"></i>
            <span class="ml-3 item-text">Profil</span>
        </a>
        </li>
        @endif
        @if(Auth::user()->hak_akses === 'customer_service')
        <li class="nav-item">
        <a href="/profil" aria-expanded="false" class="nav-link">
            <i class="fe fe-user fe-16"></i>
            <span class="ml-3 item-text">Profil</span>
        </a>
        </li>
        @endif --}}
    </ul>
    {{-- Akhir Menu --}}
    </nav>
</aside>
