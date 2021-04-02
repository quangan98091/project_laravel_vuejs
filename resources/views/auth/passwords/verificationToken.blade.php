<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Lấy lại mật khẩu</title>

    <!-- Fontfaces CSS-->
    <link href="{{ asset('admin/css/font-face.css') }}" rel="stylesheet" media="all">
    <link href="{{ asset('admin/vendor/font-awesome-4.7/css/font-awesome.min.css') }}" rel="stylesheet" media="all">
    <link href="{{ asset('admin/vendor/font-awesome-5/css/fontawesome-all.min.css') }}" rel="stylesheet" media="all">
    <link href="{{ asset('admin/vendor/mdi-font/css/material-design-iconic-font.min.css') }}" rel="stylesheet" media="all">
    <link rel="stylesheet" href="{{ asset('website/login/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('website/login/theme.css') }}">

</head>
<body>
    <div class="registration-form">
        <form method="POST" action="{{ route('postVerifyToken') }}">
            @csrf
            <div class="form-icon">
                <span><i class="fab fa-stripe-s"></i></span>
            </div>
            
            @if (session('success'))
                <div class="alert alert-success" role="alert">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger" role="alert">
                    {{ session('error') }}
                </div>
            @endif
            
            <div class="form-group">
                <input id="activation_token" type="text" placeholder="Nhập mã OTP" class="form-control item @error('activation_token') is-invalid @enderror" name="activation_token" value="{{ old('activation_token') }}" required autocomplete="activation_token" autofocus>

                @error('activation_token')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-block create-account">Xác nhận</button>
            </div>
        </form>

        <div class="social-media">  
            @if (Route::has('register'))
                <a href="{{ route('register') }}" class="btn btn-primary btn-lg active" role="button" aria-pressed="true">Đăng ký</a>
            @endif
            <a href="{{ route('login') }}" class="btn btn-secondary btn-lg active" role="button" aria-pressed="true">Đăng nhập</a>  
        </div>
    </div>
    <script type="text/javascript" src="{{ asset('website/login/jquery-3.2.1.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('website/login/jquery.mask.min.js') }}"></script>
</body>
</html>
​
