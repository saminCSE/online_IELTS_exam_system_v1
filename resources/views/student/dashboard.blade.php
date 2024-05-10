@extends('student.layouts.master')
@section('content')
    <div style="height:100px"></div>
    <div class="bg-red mt-3">
        <div class="card" style="background-color: #dc3545; padding: 5px;">
            <aside class="panel panel-highlight">
                <div class="panel-body text-center" style="padding: 7px;">
                    <div class="text-center">
                        <p class="text-white" style="font-size: 40px;"><b>CD IELTS TEST</b></p>
                    </div>
                </div>
            </aside>
        </div>
    </div>
    <div class="bg-white">
        <img src="{{ asset('images/intro-banner.jpg') }}" style="width: 100%" alt="intro">
        <div class="px-5">
            <h1 class="text-center pt-5">Welcome!</h1>
            <p class="text-center" style="font-size: 18px">familiar with IELTS on computer with these familiarisation tests,
                which will give you an idea of what to expect in the Listening, Reading and Writing sections.</p>
            <div class="row py-4">
                <div class="col-sm-6">
                    <div class="card p-3 text-center" style="box-shadow:0px 0px 10px gray; height:100%">
                        <div class="card-header bg-white">
                            <h2 class="card-title">Academic</h2>
                        </div>
                        <div class="card-body d-flex align-items-center">

                            <p class="card-text" style="font-size:20px; text-align:justify">IELTS Academic measures whether
                                your level of English language proficiency is suitable for an academic environment. It
                                reflects aspects of academic language and evaluates whether you're ready to begin training
                                or studying.</p>

                        </div>
                        <div class="card-footer bg-white">
                            <a href="{{ route('academic_start_test') }}" class="btn btn-primary">Select Academic</a>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="card p-3 text-center" style="box-shadow:0px 0px 10px gray; height:100%">
                        <div class="card-header bg-white">
                            <h2 class="card-title">General</h2>
                        </div>
                        <div class="card-body d-flex align-items-center">

                            <p class="card-text" style="font-size:20px; text-align:justify">IELTS General Training measures
                                English language proficiency in a practical, everyday context. The tasks and tests reflect
                                both workplace and social situations.</p>

                        </div>
                        <div class="card-footer bg-white">
                            <a href="{{ route('general_start_test') }}" class="btn btn-primary">Select General Training</a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
