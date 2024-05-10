@extends('student.layouts.master')
@section('content')
<style>
    body {
        font-family: Arial, "Helvetica Neue", Helvetica, sans-serif;
    }

    .wl-footer {
        background-color: #f8f9fa;
        padding: 20px 0;
        text-align: center;
    }

    .wl-btn-primary {
        background-color: #007bff;
        color: #fff;
    }

    .wl-btn-secondary {
        background-color: #6c757d;
        color: #fff;
    }
</style>

<div style="height: 100px"></div>

<!-- Page Content -->
<div class="container page-content bg-white">
    <div class="page-header">
        <div class="row pt-4">
            <div class="col-xs-12 col-md-8">
                <h1>Free IELTS on Computer Familiarisation Test</h1>
            </div>
        </div>
    </div>

    <div class="row">
        <section role="main" class="col-xs-12 col-md-8">
            <!-- Content Section -->
            <figure class="" style="width: 100%;">
                <!-- Image -->
                <img class="img-fluid" style="width: 100%" src="https://takeielts.britishcouncil.org/sites/default/files/styles/bc-landscape-630x354/public/cd-fam-test.jpg?itok=6VY2D_Z-" alt="IELTS Familiarisation Test">
            </figure>

            <div class="card" style="background-color: #ebeff0; padding: 20px;">
                <aside class="panel panel-highlight">
                    <div class="panel-body text-center" style="padding: 20px;">
                        <p style="font-size: 20px;">Take the free IELTS on computer familiarisation test</p>
                        <div class="text-center">
                            <a href="{{route('student_signup')}}" target="_blank" class="btn btn-lg btn-danger" style="border-radius: 100px; padding:10px 40px" title="Opens in a new tab or window.">Register now</a>
                        </div>
                    </div>
                </aside>
            </div>
            <div class="wl-body-text">
                <p>Experience the IELTS on computer test system before you sit the real test, and know what to expect on the test day.</p>
                <h2>Key features and benefits:</h2>
                <ul>
                    <li>Free full sample version of the computer-delivered IELTS test - Listening, Reading, and Writing questions provide 2 hours 30 minutes of questions, exactly like the real IELTS test.</li>
                    <li>Both Academic and General Training tests available - Whatever reason you are considering IELTS, we have the test for you.</li>
                    <li>Free results provided for Listening and Reading sections</li>
                    <li>Accessible anywhere at any time, no need to book or register in advance</li>
                </ul>
            </div>
            <div class="card" style="background-color: #ebeff0; padding: 20px;">
                <aside class="panel panel-highlight">
                    <div class="panel-body text-center" style="padding: 20px;">
                        <div class="text-center">
                            <a href="#" target="_blank" class="btn btn-lg btn-danger" style="border-radius: 100px; padding:10px 40px" title="Opens in a new tab or window.">Click Here To Book Now</a>
                        </div>
                    </div>
                </aside>
            </div>
            <div class="container my-5">
                {{-- <h2>Share This</h2>
                <div class="d-flex">
                    <div class="m-1">
                        <a href="#" class="btn btn-primary">
                            <i class="fab fa-facebook"></i>
                        </a>
                    </div>
                    <div class="m-1">
                        <a href="#" class="btn btn-info">
                            <i class="fab fa-twitter"></i>
                        </a>
                    </div>
                    <div class="m-1">
                        <a href="mailto:your.email@example.com" class="btn btn-danger">
                            <i class="far fa-envelope"></i>
                        </a>
                    </div>
                    <div class="m-1">
                        <a href="#" class="btn btn-warning">
                            <i class="fab fa-instagram"></i>
                        </a>
                    </div>
                </div> --}}
            </div>
        </section>

        <!-- Sidebar -->
        <aside role="complementary" class="col-xs-6 col-md-4">
            <div class="wl-sidebar">
                <div class="panel panel-default">
                    <div class="card" style="background-color: #ebeff0; padding: 20px; mb-2">
                        <div class="card-body bg-white">
                            <a class="nav-link text-danger" href="#"><strong> IELTS on computer familiarisation test</strong></a>
                        </div>
                    </div>
                    @auth('student')
                    <div class="card" style="background-color: #ebeff0; padding: 20px;">
                        <div class="card-body bg-white">
                            <a class="nav-link text-danger" href="/test_score"><strong>Test Score</strong></a>
                        </div>
                    </div>
                    @endauth
                </div>
        </aside>
    </div>
</div>
@endsection
