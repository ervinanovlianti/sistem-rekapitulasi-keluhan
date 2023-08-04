<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="favicon.ico">
    <title>Sistem Rekapitulasi</title>
    <!-- Bootstrap CSS -->
    {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous"> --}}
    <!-- Simple bar CSS -->
    <link rel="stylesheet" href="{{ asset('admin/css/simplebar.css') }}">
    <!-- Fonts CSS -->
    <link href="https://fonts.googleapis.com/css2?family=Overpass:ital,wght@0,100;0,200;0,300;0,400;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <!-- Icons CSS -->
    <link rel="stylesheet" href="{{ asset('admin/css/feather.css') }}">
    <!-- Date Range Picker CSS -->
    <!-- App CSS -->
    <link rel="stylesheet" href="{{ asset('admin/css/app-light.css') }}" id="lightTheme">
    <link rel="stylesheet" href="{{ asset('admin/css/select2.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/css/dropzone.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/css/uppy.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/css/jquery.steps.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/css/jquery.timepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/css/quill.snow.css') }}">
</head>
<body class="vertical  light  ">
    <div class="wrapper">
    @include('partials.navbar')
    @include('partials.sidebar')
    <main role="main" class="main-content">
        <div class="container-fluid">
            @yield('content')
        </div> <!-- .container-fluid -->
    </main> <!-- main -->
    </div> <!-- .wrapper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="{{ asset('admin/js/jquery.min.js')}}"></script>
    <script src="{{ asset('admin/js/popper.min.js')}}"></script>
    <script src="{{ asset('admin/js/bootstrap.min.js')}}"></script>
    <script src="{{ asset('admin/js/config.js')}}"></script>
    <script src="{{ asset('admin/js/apps.js')}}"></script>
</body>
</html>