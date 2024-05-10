@extends('student.layouts.master')
@section('content')
    <div class="row">
        <div class="col">
            <div class="row type academic shadow bg-white py-5 mb-4">
                <div class="col text-center">
                    <h1>You have chosen the General Training test.</h1>
                    <a href="{{ route('studentDashboard') }}" class="next-button" data-next-step="one"><strong>Select a different test</strong></a>
                </div>
            </div>
            <div class="row instructions shadow bg-white mb-4">
                <div class="col-md-6 p-0" style="overflow:hidden;">
                    <img src="{{ asset('images/test-1.jpg') }}" alt="test" style="height:100%">
                </div>
                <div class="col-12 col-md-6 py-5 px-4">
                    <h1>How do the familiarisation tests work?</h1>
                    <p>There are three sections to this IELTS on computer familiarisation test:</p>
                    <p>Listening (30 minutes)<br>Reading (60 minutes)<br>Writing (60 minutes)</p>
                    <p>The Writing section is scored by a person in the real test. In this familiarisation test, the
                        writing is
                        not scored.</p>
                    <p>The Speaking section is conducted face-to-face and does <strong>not</strong> form part of this test.
                    </p>
                    <h2>How to use this familiarisation test</h2>
                    <p>Take this test on a computer for the most accurate test experience.</p>
                    <p>Warning: Do not close your browser during the test. You will not get your results.</p>
                    <p>Press "Finish Section" to move to the next section.</p>
                    <p>Press "Finish Test" to end the test.</p>
                    <p>Please note that these buttons are not available in the real computer-delivered test.</p>
                    <p>IELTS on computer has helpful tools for taking notes and reviewing. Press "Help"
                        before you
                        start for more details.</p>
                    <h2>After you finish the test</h2>
                    <p>Once you have completed the familiarisation test, you will receive an email with a link of your
                        percentage marks for your Listening and Reading answers.</p>
                    <p>You will be able to match these with the Common European Framework of Reference for Languages (CEFR)
                        framework levels.</p>
                    <a href="{{route('general.listening.confirm_details')}}" class="btn btn-primary next-button end">Start test</a>
                </div>
            </div>
        </div>
    </div>
@endsection
