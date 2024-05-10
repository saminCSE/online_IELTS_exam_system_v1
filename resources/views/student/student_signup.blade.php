<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Wings Learning</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.10.0/css/bootstrap-datepicker.min.css" integrity="sha512-34s5cpvaNG3BknEWSuOncX28vz97bRI59UnVtEEpFX536A7BtZSJHsDyFoCl8S7Dt2TPzcrCEoHBGeM4SUBDBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    @include('layouts.header')
</head>

<body id="page-top" style="background-color: #f2f0f0 !important;">
    <div class="container">
        <!-- Outer Row -->
        <div class="row justify-content-center" style="padding-top: 50px;">
            <img src="{{ asset('assets/img/wingslogo.png') }}" style="padding-right: 25px;" alt="shamim">
            <h1 style="color: red; font-size: 40px; font-family: Arial">WINGS LEARNING CENTRE</h1>
            <div class="col-xl-10 col-lg-12 col-md-9">
                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <!-- <div class="col-lg-6 d-none d-lg-block bg-login-image"></div> -->
                            <div class="col-lg-10 offset-lg-1">
                                <div class="p-5">
                                    <div class="">
                                        <h1 class="">Take the IELTS on computer familiarisation test</h1>
                                        <hr />
                                        <p>Please enter your name and email address to access the familiarisation test</p>
                                    </div>
                                    @if (session('message'))
                                    <div class="alert alert-danger">{{ session('message') }}</div>
                                    @elseif(session('success'))
                                    <div class="alert alert-success">{{ session('success') }}</div>
                                    @endif
                                    <form action="{{ url('register_student') }}" method="post" class="user">
                                        @csrf
                                        <div class="form-group py-1">
                                            <input type="text" class="form-control" id="exampleInputName" name="name" placeholder="Your Name" value="{{ old('name') }}" required>
                                            @error('name')
                                            <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group py-1">
                                            <input type="email" class="form-control" id="exampleInputEmail" name="email" placeholder="Your Email Address" value="{{ old('email') }}" required>
                                            @error('email')
                                            <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group py-1">
                                            <div class="input-group">
                                                <input type="text" class="form-control" id="exampleInput" name="candidate_id" placeholder="Candidate No." required>
                                            </div>
                                            @error('candidate_id')
                                            <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group py-1">
                                            <div class="input-group">
                                                <input type="text" class="form-control" id="exampleInput" name="identity_no" placeholder="NID /Passport No." required>
                                            </div>
                                            @error('identity_no')
                                            <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group py-1">
                                            <div class="input-group">
                                                <input type="number" class="form-control" id="exampleInput" name="phone" placeholder="Phone No." required>
                                            </div>
                                            @error('phone')
                                            <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        {{-- <div class="form-group py-1">
                                            <select class="form-control" id="country" name="country">
                                                <option value="" selected>Select Country</option>
                                                <option value="usa">Bangladesh</option>
                                                <option value="usa">India</option>
                                                <option value="uk">United Kingdom</option>
                                                <option value="usa">United States</option>
                                            </select>
                                        </div> --}}
                                        {{-- <div class="form-group py-1">
                                            <div class="input-group">
                                                <input type="text" class="form-control datepicker" id="exampleInput" name="birth_date" placeholder="Date Of Birth" required>
                                            </div>
                                            @error('birth_date')
                                            <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div> --}}
                                        <div class="input radio py-1">
                                            <label class="terms" for="agree-updates">
                                                <input type="radio" required class="form-check-input mr-2" name="agree_updates" value="1" id="agree-updates"><h5 class="d-inline"> agree to the <a href="">terms of use</a> and  <a href="">privacy and cookie policy</a> of this test.</h5>
                                            </label>
                                        </div>

                                        <h2>Stay in touch</h2>

                                        <div class="input checkbox py-1">
                                            <label class="terms" for="agree-updates">
                                                <input type="checkbox" required class="mr-2 form-check-input" name="agree_updates" value="1" id="agree-updates"><h5 class="d-inline">I agree to receive updates about products, services, and events provided or organized by the WINGS.</h5>
                                            </label>
                                        </div>

                                        <p style="font-size: 1em;" class="py-1">You may unsubscribe at any time by following the “Unsubscribe” link in our communications. We will process your personal information based on your consent.</p>

                                        <div class="input checkbox py-1">
                                            <label class="terms" for="agree-ielts">
                                                <input type="checkbox" required class="mr-2 form-check-input" name="agree_ielts" value="1" id="agree-ielts"><h5 class="d-inline">I agree to receive emails related to the familiarization test from IELTS prep.</h5>
                                            </label>
                                        </div>
                                        <button type="submit" style="font-size:20px" class="btn btn-primary btn-block">Register</button>
                                        <hr>
                                    </form>
                                    {{-- <a type="submit" style="font-size:20px" class="btn btn-primary btn-block">Register</a> --}}

                                    <hr>
                                    <div class="text-center">
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.10.0/js/bootstrap-datepicker.min.js" integrity="sha512-LsnSViqQyaXpD4mBBdRYeP6sRwJiJveh2ZIbW41EBrNmKxgr/LFZIiWT6yr+nycvhvauz8c2nYMhrP80YhG7Cw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        $(function () {
            $('.datepicker').datepicker({
                autoclose:true,
                todayHighlight:true,
                format:'yyyy-mm-dd',
            });

        });
    </script>
</html>
