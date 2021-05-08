<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>ShareCode</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <!-- Bootstrap -->
    <link rel="stylesheet" href="{{ asset('home/plugins/bootstrap/bootstrap.min.css') }}">
    <!-- slick slider -->
    <link rel="stylesheet" href="{{ asset('home/plugins/slick/slick.css') }}">
    <!-- themefy-icon -->
    <link rel="stylesheet" href="{{ asset('home/plugins/themify-icons/themify-icons.css') }}">
    <!-- Main Stylesheet -->
    <link href="{{ asset('home/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('home/vendor/mdi-font/css/material-design-iconic-font.min.css') }}" rel="stylesheet" media="all">
    <link href="{{ asset('home/vendor/font-awesome-4.7/css/font-awesome.min.css') }}" rel="stylesheet" media="all">
    <link href="{{ asset('home/vendor/font-awesome-5/css/fontawesome-all.min.css') }}" rel="stylesheet" media="all">
    <link href="{{ asset('home/vendor/vue-multiselect/vue-multiselect.min.css') }}" rel="stylesheet" media="all">

    
    <style>
        .head-home {
            font-size: 16px;
            margin: 8px 35px;
        }
        .head-home a {
            color: white;
            margin-right: 3px;
            border: 1px solid #4e5050;
            background: #4e5050;
            padding: 5px 15px;
            border-radius: 11px;
            overflow: hidden;
            box-shadow: 0 0 5px 0px #000000;
        }
        .head-home a:hover {
            color: black;
            text-decoration: none;
            background: white;
        }
        .router-link-exact-active{
            color: #ff4700 !important;
            border-bottom: 1px solid #ff4700;
        }
    </style>
</head>
<body>
    <!-- preloader -->
    <div class="preloader">
        <div class="loader">
            <span class="dot"></span>
            <div class="dots">
                <span></span><span></span><span></span>
            </div>
        </div>
    </div>
    <!-- /preloader -->
    
    <div class="float-right head-home">
        @if (Route::has('login'))
            <div class="top-right links">
                @auth
                    @if (Auth::user()->type == 'admin')
                        <a href="{{ url('/dashboard') }}">Trang quản trị</a>
                    @endif
                @else
                    <a href="{{ route('login') }}">Đăng nhập</a>

                    @if (Route::has('register'))
                        <a href="{{ route('register') }}">Đăng ký</a>
                    @endif
                @endauth
            </div>   
         @endif
    </div>
    
    
    <div id="app">

    </div>
    

    {{-- @auth
        <script>
            window.user = @json(auth()->user())
        </script>
    @endauth --}}
    <script>
        window.user = (@json(auth()->user()) != null) ? @json(auth()->user()) : undefined;
    </script>
    
    <!-- Scripts -->
    <script src="{{ asset('js/fontend.js') }}"></script>
    <!-- jQuery -->
    <script src="{{ asset('home/plugins/jQuery/jquery.min.js') }}"></script>
    <!-- Bootstrap JS -->
    <script src="{{ asset('home/plugins/bootstrap/bootstrap.min.js') }}"></script>
    <!-- slick slider -->
    <script src="{{ asset('home/plugins/slick/slick.min.js') }}"></script>
    <!-- masonry -->
    <script src="{{ asset('home/plugins/masonry/masonry.js') }}"></script>
    <!-- instafeed -->
    <script src="{{ asset('home/plugins/instafeed/instafeed.min.js') }}"></script>
    <!-- smooth scroll -->
    {{-- <script src="{{ asset('home/plugins/smooth-scroll/smooth-scroll.js') }}"></script> --}}
    <!-- headroom -->
    <script src="{{ asset('home/plugins/headroom/headroom.js') }}"></script>
    <!-- reading time -->
    <script src="{{ asset('home/plugins/reading-time/readingTime.min.js') }}"></script>
    <!-- Main Script -->
    <script src="{{ asset('home/js/script.js') }}"></script>
    <script src="{{ asset('home/vendor/vue-multiselect/vue-multiselect.min.js') }}"></script>
    
</body>
</html>
