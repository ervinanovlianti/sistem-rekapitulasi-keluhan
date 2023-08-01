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
        <form class="col-lg-3 col-md-4 col-10 mx-auto" method="post" action="http://127.0.0.1:8000/register">
        <div class="mx-auto text-center my-4">
            <a class="navbar-brand mx-auto mt-2 flex-fill text-center" href="./index.html">
            <svg version="1.1" id="logo" class="navbar-brand-img brand-md" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 120 120" xml:space="preserve">
                <g>
                    <polygon class="st0" points="78,105 15,105 24,87 87,87 	" />
                    <polygon class="st0" points="96,69 33,69 42,51 105,51 	" />
                    <polygon class="st0" points="78,33 15,33 24,15 87,15 	" />
                    </g>
            </svg>
            </a>
            <h2 class="my-3">Register</h2>
            </div>
            <input type="hidden" name="_token" value="C3tnROXV3eS9A8ErtomFUMr5SfzM33aiepJkQOCb">            <div class="form-group">
                <label for="firstname">Nama Customer</label>
                <input type="text" name="nama" id="firstname" class="form-control">
            </div>
                        <div class="form-group">
                <label for="firstname">No Telepon</label>
                <input type="text" name="no_telepon" id="firstname" class="form-control">
            </div>
            
                    <div class="form-group">
                <label for="inputEmail4">Email</label>
                <input type="email" name="email" class="form-control" id="inputEmail4">
            </div>
            
            <div class="form-group">
            <label for="inputPassword5">New Password</label>
            <input type="password" name="password" class="form-control" id="inputPassword5">
            </div>
                        
            <button class="btn btn-lg btn-primary btn-block" type="submit">Sign up</button>
            <p class="mt-5 mb-3 text-muted text-center">2023</p>
        </form>
      </div>
    </div>
    <script src="{{ asset('admin//js/jquery.min.js')}}"></script>
    <script src="{{ asset('admin//js/popper.min.js')}}"></script>
    <script src="{{ asset('admin//js/moment.min.js')}}"></script>
    <script src="{{ asset('admin//js/bootstrap.min.js')}}"></script>
    <script src="{{ asset('admin//js/simplebar.min.js')}}"></script>
    <script src='{{ asset('admin//js/daterangepicker.js')}}'></script>
    <script src='{{ asset('admin//js/jquery.stickOnScroll.js')}}'></script>
    <script src="{{ asset('admin//js/tinycolor-min.js')}}"></script>
    <script src="{{ asset('admin//js/config.js')}}"></script>
    <script src="{{ asset('admin//js/apps.js')}}"></script>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-56159088-1"></script>
  </body>
</html>
</body>
</html>