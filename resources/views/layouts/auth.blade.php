<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" @if (app()->getLocale() == 'ar') dir="rtl" @else dir="ltr" @endif>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Title -->
    <title> Galaxy | Auth</title>
    <!-- Favicon -->
    <!-- Bootstrap -->
    <link rel="stylesheet" href="{{ asset('dash/assets/css/bootstrap.min.css') }}">
    <!-- file upload -->
    <link rel="stylesheet" href="{{ asset('dash/assets/css/file-upload.css') }}">
    <!-- file upload -->
    <link rel="stylesheet" href="{{ asset('dash/assets/css/plyr.css') }}">
    <!-- DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.dataTables.min.css">
    <!-- full calendar -->
    <link rel="stylesheet" href="{{ asset('dash/assets/css/full-calendar.css') }}">
    <!-- jquery Ui -->
    <link rel="stylesheet" href="{{ asset('dash/assets/css/jquery-ui.css') }}">
    <!-- editor quill Ui -->
    <link rel="stylesheet" href="{{ asset('dash/assets/css/editor-quill.css') }}">
    <!-- apex charts Css -->
    <link rel="stylesheet" href="{{ asset('dash/assets/css/apexcharts.css') }}">
    <!-- calendar Css -->
    <link rel="stylesheet" href="{{ asset('dash/assets/css/calendar.css') }}">
    <!-- jvector map Css -->
    <link rel="stylesheet" href="{{ asset('dash/assets/css/jquery-jvectormap-2.0.5.css') }}">
    <!-- Main css -->
    <link rel="stylesheet" href="{{ asset('dash/assets/css/main.css') }}">
</head>
<body>

    <section class="auth d-flex">
        <div class="auth-left bg-main-50 flex-center p-24">
            <img src="{{asset('dash/assets/images/thumbs/auth-img2.png')}}" alt="">
        </div>
        <div class="auth-right py-40 px-24 flex-center flex-column">
            <div class="auth-right__inner mx-auto w-100">
                <a href="index.html" class="auth-right__logo">
                    <img src="{{asset('dash/assets/images/logo/logo.png')}}" alt="">
                </a>
                @yield('content')

            </div>
        </div>
    </section>
    <script src="{{ asset('dash/assets/js/jquery-3.7.1.min.js') }}"></script>
    <!-- Bootstrap Bundle Js -->
    <script src="{{ asset('dash/assets/js/boostrap.bundle.min.js') }}"></script>
    <!-- Phosphor Js -->
    <script src="{{ asset('dash/assets/js/phosphor-icon.js') }}"></script>
    <!-- file upload -->
    <script src="{{ asset('dash/assets/js/file-upload.js') }}"></script>
    <!-- file upload -->
    <script src="{{ asset('dash/assets/js/plyr.js') }}"></script>
    <!-- dataTables -->
    <script src="https://cdn.datatables.net/2.0.8/js/dataTables.min.js"></script>
    <!-- full calendar -->
    <script src="{{ asset('dash/assets/js/full-calendar.js') }}"></script>
    <!-- jQuery UI -->
    <script src="{{ asset('dash/assets/js/jquery-ui.js') }}"></script>
    <!-- jQuery UI -->
    <script src="{{ asset('dash/assets/js/editor-quill.js') }}"></script>
    <!-- apex charts -->
    <script src="{{ asset('dash/assets/js/apexcharts.min.js') }}"></script>
    <!-- Calendar Js -->
    <script src="{{ asset('dash/assets/js/calendar.js') }}"></script>
    <!-- jvectormap Js -->
    <script src="{{ asset('dash/assets/js/jquery-jvectormap-2.0.5.min.js') }}"></script>
    <!-- jvectormap world Js -->
    <script src="{{ asset('dash/assets/js/jquery-jvectormap-world-mill-en.js') }}"></script>

    <!-- main js -->
    <script src="{{ asset('dash/assets/js/main.js') }}"></script>



</body>
</html>
