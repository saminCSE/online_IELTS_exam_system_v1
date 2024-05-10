@extends('student.layouts.master')
@section('content')
    <div id="confirm_details">
        <div class="container">
            <div class="student-details m-5 p-5" bis_skin_checked="1">
                <div class="d-flex align-items-center my-3">
                    <img src="https://cdielts.gelielts.com/img/userCheck.png" alt="">
                    <h3 class="m-0 p-0 text-danger">Confirm your details</h3>
                </div>

                <div class="bc-box" bis_skin_checked="1">

                    <ul>
                        <li>Name : <span class="text-danger">{{ auth('student')->user()->name }}</span></li>
                        <li>Date of birth : <span class="text-danger">{{ auth('student')->user()->birth_date }}</span></li>
                        <li>Candidate number : <span class="text-danger">{{ auth('student')->user()->candidate_id }}</span>
                        </li>
                    </ul>
                    <p class="bx-box-info">If your details aren't correct, please inform the invigilator.</p>
                    <button class="btn btn-danger bc-button next-button" onclick="showTestSound()"">My details are
                        correct</button>
                </div>
            </div>

        </div>
    </div>
    <div id="test_sound" class="hidden">
        <div class="container">
            <div class="student-details m-5 p-5" bis_skin_checked="1">
                <div class="col" bis_skin_checked="1">
                    <h5>IELTS Academic Reading</h5>
                    <p>Time: 1 hour</p>
                    <h5>INSTRUCTIONS TO CANDIDATES</h5>
                    <ul>
                        <li>Answer <strong>all</strong> the questions.</li>
                        <li>You can change your answers at any time during the test.</li>
                    </ul>
                    <h5>INFORMATION FOR CANDIDATES</h5>
                    <ul>
                        <li>There are 40 questions in this test.</li>
                        <li>Each question carries one mark.</li>
                        <li>The test clock will show you when there are 10 minutes and 5 minutes remaining.</li>
                    </ul>
                    <a href="{{route('start.academic.reading')}}" class="btn btn-danger">Start Test</a>
                </div>


            </div>
        </div>
    </div>





    <script>
        function playSound() {
            var soundFrame = document.getElementById('soundFrame');
            soundFrame.src = soundFrame.src + '&autoplay=1';
        }

        function showTestSound() {
            document.getElementById('confirm_details').style.display = 'none';
            document.getElementById('test_sound').style.display = 'block';
        }

        function show_start_test() {
            document.getElementById('test_sound').style.display = 'none';
            document.getElementById('start_test').style.display = 'block';
        }
    </script>
@endsection
