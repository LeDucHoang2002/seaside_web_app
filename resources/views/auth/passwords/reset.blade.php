<!DOCTYPE html>
<html lang="en">

<head>
    <title>@yield('title', 'Quên mật khẩu')</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        @media (min-width: 768px) {
            .card {
                width: 40%;
            }
        }

        .card {
            margin: 50px auto;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        .card-header {
            background-color: #c6a0a3;
            color: #ffffff;
            padding: 15px;
            border-top-left-radius: 8px;
            border-top-right-radius: 8px;
        }

        .card-body {
            padding: 20px;
        }

        a {
            text-decoration: none;
        }

        .header {
            font-family: Arial, sans-serif;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding-left: 13.5%;
            padding-right: 13.5%;
            font-size: 22px;
            width: 100%;
            height: 55px;
            border-bottom: 1px solid #b2b2b2;
            background-color: #ffffff;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .col-md-4 {
            text-align: right;
            line-height: 2.5;
        }

        .form-control {
            width: 100%;
            padding: 10px;
            border: 1px solid #ced4da;
            border-radius: 4px;
            margin-top: 5px;
            box-sizing: border-box;
        }

        .btn-primary {
            background-color: #bf6d72;
            color: #ffffff;
            border: 1px solid #bf6d72;
            border-radius: 4px;
            padding: 10px 20px;
            cursor: pointer;
        }

        .btn-primary:hover {
            background-color: #c48185;
            border: 1px solid #c48185;
        }

        .invalid-feedback {
            color: #dc3545;
        }

        .alert {
            margin-top: 20px;
        }

        .alert-success {
            background-color: #28a745;
            color: #ffffff;
            padding: 10px;
            border-radius: 4px;
        }
    </style>
</head>

<body class="animsition">
    <div class="header"> <a href="{{ route('buyer.home') }}" class="logo" style="color: #000">
            <p><b>SEASIDE</b> STORE / <span style="color: #a0a5a8">Đặt lại mật khẩu</span></p>
        </a>
        <p style="font-size: 16px;color: #bf6d72">Bạn cần giúp đỡ?</p>
    </div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Đặt lại mật khẩu') }}</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('password.update') }}">
                            @csrf

                            <input type="hidden" name="token" value="{{ $token }}">

                            <div class="form-group row">
                                <label for="email"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Địa chỉ email của bạn') }}</label>

                                <div class="col-md-6">
                                    <input id="email" type="email"
                                        class="form-control @error('email') is-invalid @enderror" name="email"
                                        value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Nhập mật khẩu mới') }}</label>

                                <div class="col-md-6">
                                    <input id="password" type="password"
                                        class="form-control @error('password') is-invalid @enderror" name="password"
                                        required autocomplete="new-password">

                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password-confirm"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Nhập lại mật khẩu mới') }}</label>

                                <div class="col-md-6">
                                    <input id="password-confirm" type="password" class="form-control"
                                        name="password_confirmation" required autocomplete="new-password">
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Đặt lại mật khẩu') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
