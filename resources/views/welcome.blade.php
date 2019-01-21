<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title')</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('css/datepicker.min.css') }}">
        <link rel="stylesheet" href="{{ asset('css/fullcalendar.min.css') }}">
        <link rel="stylesheet" href="{{ asset('css/toastr.min.css') }}">
        <link rel="stylesheet" href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}">
        <!-- <link rel="stylesheet" href="{{ asset('css/sb-admin-2.min.css') }}"> -->
        <!-- Styles -->

    </head>
    <body style="background-image: url({{ asset('images/bg.jpg')  }});">
        <br/><br/>
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-4">
                    <img src="{{ asset('images/logo.jpg') }}" width="120" height="120">
                </div>
                <div class="col-lg-4">
                    
                </div>
                <div class="col-lg-4">
                     @if (Route::has('login'))
                        <div class="top-right links">
                            @auth
                                <a href="{{ url('/home') }}">Home</a>
                            @else
                                <a href="{{ route('login') }}">Login</a>
                            @endauth
                        </div>
                    @endif
                </div>
            </div>
        </div>

        @yield('content')

        <script type="text/javascript" src="{{ asset('js/jquery.js') }}"></script>
        <script src="{{ asset('js/bootstrap.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/moment.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/momentlocale.js') }}"></script>
        <script src="{{ asset('js/fullcalendar.min.js') }}"></script>
        <script src="{{ asset('js/datepicker.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/toastr.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('vendor/jquery-easing/jquery.easing.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/sb-admin-2.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('vendor/chart.js/Chart.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/demo/chart-area-demo.js') }}"></script>
        @yield('scripts')

    </body>
</html>
