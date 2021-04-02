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
        <form method="POST" action="{{ route('updatePassword') }}">
            @csrf
            <div class="form-icon">
                <span><i class="fab fa-stripe-s"></i></span>
            </div>

            @if (session('error'))
                <div class="alert alert-danger" role="alert">
                    {{ session('error') }}
                </div>
            @endif
            
            <input type="hidden" name="activation_token" value="{{ $token }}">

            <div class="form-group">
                <input id="email" type="email" placeholder="Nhập email xác nhận" class="form-control item @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group">
                <input id="password" type="password" placeholder="Nhập mật khẩu mới" class="form-control item @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group">
                <input id="password-confirm" type="password" placeholder="Nhập lại mật khẩu mới" class="form-control item" name="password_confirmation" required autocomplete="new-password">
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
