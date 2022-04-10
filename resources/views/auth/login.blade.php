<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>{{ config('app.name') }} &middot; Login</title>

    <!-- Custom fonts for this template-->
    <link href="{{ asset('img/gesam_logo.png') }}" rel="shortcut icon" type="image/jpeg" />

    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Custom styles for this template-->
    <link href="{{ asset('css/sb-admin-2.min.css') }}" rel="stylesheet">

</head>

<body class="bg-login-image">

    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center mt-5">

            <div class="col-xl-10 col-lg-12 col-md-9 mt-5">
                <div class="card o-hidden border-0 shadow-lg my-5 mx-2">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block "
                                style="background-size:5px; background: #fff url({{ asset('img/gesam_logo.png') }}) no-repeat center/contain;">
                            </div>


                            <div class="col-lg-6 mx-auto">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 mb-1" style="color: rgb(13, 25, 136)">EPSU Admin Portal</h1>
                                        <p class="small text-gray-900 mb-4">Welcome Back! Please login into your account
                                        </p>
                                    </div>

                                    <form class="user" action="{{ route('login') }}" method="POST">
                                        @csrf
                                        <div class="form-group">
                                            <input type="text" name="email" class="form-control
                                            @error('email') is-invalid @enderror
                                            form-control-sm form-control-user" id="exampleInputEmail"
                                                aria-describedby="emailHelp" placeholder="Email">
                                            @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <input type="password" name="password"
                                                class="form-control @error('password') is-invalid @enderror form-control-sm form-control-user"
                                                id="exampleInputPassword" placeholder="Password">
                                            @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="row">
                                            <div class="mb-3 col-12 text-right">
                                                <a class="small" href="{{ route('password.request') }}">Forgot
                                                    Password?</a>
                                            </div>
                                        </div>

                                        <input value="Login" type="submit"
                                            class="btn btn-md btn-primary btn-user btn-block">
                                        <hr>
                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>

        </div>

        <!-- Custom scripts for all pages-->
        <script src="{{ asset('js/sb-admin-2.min.js') }}"></script>

</body>

</html>
