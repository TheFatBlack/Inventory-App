<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <meta name="description" content="POS - Bootstrap Admin Template">
    <meta name="keywords"
        content="admin, estimates, bootstrap, business, corporate, creative, management, minimal, modern,  html5, responsive">
    <meta name="author" content="Dreamguys - Bootstrap Admin Template">
    <meta name="robots" content="noindex, nofollow">
    <title>{{ env('APP_NAME') }}</title>

    <link rel="shortcut icon" type="image/x-icon" href="{{asset('template/assets/img/favicon.jpg')}}">

    <link rel="stylesheet" href="{{asset('template/assets/css/bootstrap.min.css')}}">

    <link rel="stylesheet" href="{{asset('template/assets/plugins/select2/css/select2.min.css')}}">

    <link rel="stylesheet" href="{{asset('template/assets/css/bootstrap-datetimepicker.min.css')}}">

    <link rel="stylesheet" href="{{asset('template/assets/css/animate.css')}}">
    <link rel="stylesheet" href="{{asset('template/assets/css/dataTables.bootstrap4.min.css')}}">

    <link rel="stylesheet" href="{{asset('template/assets/plugins/fontawesome/css/fontawesome.min.css')}}">
    <link rel="stylesheet" href="{{asset('template/assets/plugins/fontawesome/css/all.min.css')}}">

    <link rel="stylesheet" href="{{asset('template/assets/css/style.css')}}">
</head>

<body>
    <div id="global-loader">
        <div class="whirly-loader"> </div>
    </div>
    <div class="main-wrapper">
        @include('template-petugas.navbar')

        @include('template-petugas.sidebar')

        <div class="page-wrapper">
            @yield('content')
        </div>
    </div>


    <script src="{{ asset('template/assets/js/jquery-3.6.0.min.js') }}"></script>

    <script src="{{ asset('template/assets/js/feather.min.js') }}"></script>

    <script src="{{ asset('template/assets/js/jquery.slimscroll.min.js') }}"></script>

    <script src="{{ asset('template/assets/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('template/assets/js/dataTables.bootstrap4.min.js') }}"></script>

    <script src="{{ asset('template/assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('template/assets/plugins/select2/js/select2.min.js') }}"></script>

    <script src="{{ asset('template/assets/js/moment.min.js') }}"></script>
    <script src="{{ asset('template/assets/js/bootstrap-datetimepicker.min.js') }}"></script>

    <script src="{{ asset('template/assets/plugins/sweetalert/sweetalert2.all.min.js') }}"></script>
    <script src="{{ asset('template/assets/plugins/sweetalert/sweetalerts.min.js') }}"></script>

    <script src="{{ asset('template/assets/plugins/apexchart/apexcharts.min.js') }}"></script>
    <script src="{{ asset('template/assets/plugins/apexchart/chart-data.js') }}"></script>

    <script src="{{ asset('template/assets/js/script.js') }}"></script>
</body>

</html>