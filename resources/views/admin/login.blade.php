<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Wings Learning</title>
    @include('layouts.header')
</head>

<body id="page-top" style="background-color: #f2f0f0 !important;">
    <div class="container">
        <!-- Outer Row -->
        <div class="row justify-content-center" style="padding-top: 150px;">
            <img src="{{ asset('assets/img/wingslogo.png') }}" style="padding-right: 25px;" alt="shamim">
            <h1 style="color: red; font-size: 60px; font-family:Arial">WINGS LEARNING CENTRE</h1>
            <div class="col-xl-10 col-lg-12 col-md-9">
                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Admin Login</h1>
                                    </div>
                                    @if (session('error-msg'))
                                        <div class="alert alert-danger">{{ session('error-msg') }}</div>
                                    @endif
                                    <form action="{{ url('admin_login') }}" method="post" class="user">
                                        @csrf
                                        <div class="form-group">
                                            <input type="email" class="form-control form-control-user"
                                                id="exampleInputEmail" aria-describedby="emailHelp" name="email"
                                                placeholder="Enter Email Address...">
                                        </div>
                                        {{-- <div class="form-group">
                                            <input type="password" class="form-control form-control-user" id="exampleInputPassword" name="password" placeholder="Password">
                                        </div> --}}
                                        <div class="form-group">
                                            <div class="input-group">
                                                <input type="password" class="form-control form-control-user"
                                                    id="exampleInputPassword" name="password" placeholder="Password">
                                                <div class="input-group-append">
                                                    <button class="btn btn-outline-secondary" type="button"
                                                        id="togglePassword"
                                                        style="border-top-right-radius: 10rem; border-bottom-right-radius: 10rem;">
                                                        <i class="fa fa-eye" id="togglePasswordIcon"></i>
                                                    </button>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="custom-control custom-checkbox small">
                                                <input type="checkbox" class="custom-control-input" id="customCheck">
                                                <label class="custom-control-label" for="customCheck">Remember
                                                    Me</label>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary btn-user btn-block">
                                            Login
                                        </button>
                                        <hr>
                                    </form>
                                    <hr>
                                    <div class="text-center">
                                        <a class="small" href="forgot-password.html">Forgot Password?</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('layouts.footer_script')
</body>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const passwordInput = document.querySelector('#exampleInputPassword');
        const togglePasswordButton = document.querySelector('#togglePassword');
        const togglePasswordIcon = document.querySelector('#togglePasswordIcon');

        togglePasswordButton.addEventListener('click', function() {
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                togglePasswordIcon.classList.remove('fa-eye');
                togglePasswordIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                togglePasswordIcon.classList.remove('fa-eye-slash');
                togglePasswordIcon.classList.add('fa-eye');
            }
        });
    });
</script>

</html>
