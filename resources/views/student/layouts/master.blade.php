<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>WINGS - Online Mock Test</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        .hidden {
            display: none;
        }
    </style>



    @include('student.layouts.header')
</head>

<body class="sb-nav-fixed" style="background-color: #ebeff0">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-danger" style="height: 100px;">
        <div class="container">
            <div class="col-xs-12 col-md-12 col-lg-8">
                <a href="{{ route('welcome') }}"><img href="{{ route('welcome') }}"
                        src="{{ asset('/assets/images/wingslogo-white.png') }}" class="img-responsive"
                        style="height: 90px; width:120px" alt="wings"> </a>
            </div>
            <div class="col-xs-12 col-md-12 col-lg-4">
                <ul>
                    @auth('student')
                        <li class="nav-item dropdown no-arrow" style="list-style: none">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small text-white">
                                    {{ auth('student')->user()->name }}
                                </span>
                            </a>
                            <div class="dropdown-menu shadow animated--grow-in"
                                aria-labelledby="userDropdown">

                                <a class="dropdown-item" href="{{ route('student_logout') }}">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <div class="main container">
        @yield('content')
    </div>
    @include('student.layouts.footer_scripts')
    @include('student.layouts.footer')
</body>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>

</html>
