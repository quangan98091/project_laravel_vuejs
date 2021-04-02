<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Đăng ký</title>

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
        <form method="POST" action="{{ route('register') }}">
            @csrf
            <div class="form-icon">
                <span><i class="fab fa-stripe-s"></i></span>
            </div>
            <div class="form-group">
                <input id="name" type="text" placeholder="Nhập tên hiển thị" class="form-control item @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-group">
                <input id="email" type="email" placeholder="Nhập email" class="form-control item @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-group">
                <input id="password" type="password" placeholder="Nhập mật khẩu" class="form-control item @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-group">
                <input id="password-confirm" type="password" class="form-control item" placeholder="Nhập lại mật khẩu" name="password_confirmation" required autocomplete="new-password">
            </div>
    
            <div class="form-group">
                <button type="submit" class="btn btn-block create-account">Đăng ký</button>
            </div>
        </form>

        <div class="social-media">  
            <p style="font-size: 19px;">
                Bạn đã có tài khoản?
                @if (Route::has('login'))
                    <a class="nav-link" href="{{ route('login') }}">Đăng nhập</a>
                @endif
            </p>
        </div>
    </div>
    <script type="text/javascript" src="{{ asset('website/login/jquery-3.2.1.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('website/login/jquery.mask.min.js') }}"></script>
</body>
</html>
​
