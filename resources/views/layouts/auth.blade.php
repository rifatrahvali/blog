<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">


    <!-- Title -->
    <title>@yield('title','Oturum İşlemleri')</title>

    <!-- Styles -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css?family=Material+Icons|Material+Icons+Outlined|Material+Icons+Two+Tone|Material+Icons+Round|Material+Icons+Sharp"
        rel="stylesheet">
    <link href="{{asset('assets/plugins/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('assets/plugins/perfectscroll/perfect-scrollbar.css')}}" rel="stylesheet">
    <link href="{{asset('assets/plugins/pace/pace.css')}}" rel="stylesheet">


    <!-- Theme Styles -->
    <link href="{{asset('assets/css/main.min.css')}}" rel="stylesheet">
    <link href="{{asset('assets/css/custom.css')}}" rel="stylesheet">

    <link rel="icon" type="image/png" sizes="32x32" href="{{asset('assets/images/neptune.png')}}" />
    <link rel="icon" type="image/png" sizes="16x16" href="{{asset('assets/images/neptune.png')}}" />
    @yield('css')
</head>

<body>

    @yield('content')
    

    <!-- Javascripts -->
    <script src="{{asset('assets/plugins/jquery/jquery-3.5.1.min.js')}}"></script>
    <script src="{{asset('assets/plugins/bootstrap/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('assets/plugins/perfectscroll/perfect-scrollbar.min.js')}}"></script>
    <script src="{{asset('assets/plugins/pace/pace.min.js')}}"></script>
    <script src="{{asset('assets/js/main.min.js')}}"></script>
    <script src="{{asset('assets/js/custom.js')}}"></script>
    @yield('js')
</body>

</html>