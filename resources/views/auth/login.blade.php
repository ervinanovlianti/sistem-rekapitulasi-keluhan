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
    <link rel="stylesheet" href="{{ asset('admin/css/daterangepicker.css') }}">
    <!-- App CSS -->
    <link rel="stylesheet" href="{{ asset('admin/css/app-light.css') }}" id="lightTheme">
    <link rel="stylesheet" href="{{ asset('admin/css/select2.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/css/dropzone.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/css/uppy.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/css/jquery.steps.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/css/jquery.timepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/css/quill.snow.css') }}">
</head>
    <body class="light ">
        <div class="wrapper vh-100">
        <div class="row align-items-center h-100">
            <form class="col-lg-3 col-md-4 col-10 mx-auto text-center" form method="post" action="/login">
                <input type="hidden" name="_token" value="C3tnROXV3eS9A8ErtomFUMr5SfzM33aiepJkQOCb">            
            <h1 class="h6 mb-3">Sign in</h1>
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
                    <div class="form-group">
                <label for="inputEmail" class="sr-only">Email address</label>
                <input type="email" name="email" id="inputEmail" class="form-control form-control-lg" placeholder="Email address" required="" autofocus="">
                    @error('email')
                        <div style="color: red;">{{ $message }}</div>
                    @enderror
                </div>
            <div class="form-group">
                <label for="inputPassword" class="sr-only">Password</label>
                <input type="password" name="password" id="inputPassword" class="form-control form-control-lg" placeholder="Password" required="">
                 @error('password')
        <div style="color: red;">{{ $message }}</div>
    @enderror
            </div>
            
            <button class="btn btn-lg btn-primary btn-block" type="submit">Login</button>
            <p class="mt-3">Belum punya akun? <a href="/register">Sign Up</a></p>
            <p class="mt-2 mb-3 text-muted"> 2023</p>
            </form>
        </div>
        </div>
    <script src="{{ asset('admin/js/jquery.min.js')}}"></script>
    <script src="{{ asset('admin/js/popper.min.js')}}"></script>
    <script src="{{ asset('admin/js/moment.min.js')}}"></script>
    <script src="{{ asset('admin/js/bootstrap.min.js')}}"></script>
    <script src="{{ asset('admin/js/simplebar.min.js')}}"></script>
    <script src='{{ asset('admin/js/daterangepicker.js')}}'></script>
    <script src='{{ asset('admin/js/jquery.stickOnScroll.js')}}'></script>
    <script src="{{ asset('admin/js/tinycolor-min.js')}}"></script>
    <script src="{{ asset('admin/js/config.js')}}"></script>
    <script src="{{ asset('admin/js/apps.js')}}"></script>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-56159088-1"></script>
  </body>
</html>
</body>
</html>