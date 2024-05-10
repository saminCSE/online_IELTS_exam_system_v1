@extends('student.layouts.master')
@section('content')
    <div id="layoutSidenav_content">
        <main>
            <div class="">
                <div class="">
                    <div class="row">
                        <div class="col-md-3 mx-0 px-0">
                            <div class="list-group question-list" id="tabList" role="tablist">
                                @foreach ($titleNames as $title_id => $titleName)
                                    <a class="list-group-item list-group-item-action {{ $loop->first ? 'active' : '' }}"
                                        id="test{{ $title_id }}-tab" data-bs-toggle="list"
                                        href="#test{{ $title_id }}" role="tab"
                                        aria-controls="test{{ $title_id }}">
                                        {{ $titleName }}
                                    </a>
                                @endforeach
                                <!-- Add more practice tests here -->
                            </div>
                        </div>
                        <div class="col-md-9 mx-0 px-0">
                            <div class="tab-content" id="tabContent">
                                @foreach ($skillsNames as $title_id => $skills)
                                    <div class="tab-pane fade text-center {{ $loop->first ? 'show active' : '' }}"
                                        id="test{{ $title_id }}" role="tabpanel"
                                        aria-labelledby="test{{ $title_id }}-tab">
                                        <!-- Content for Practice Test -->
                                        <h2 class="test-title">{{ $titleNames[$title_id] }}</h2>

                                        <!-- Listening Section -->
                                        @foreach ($skills as $skills_id => $skillsName)
                                            <button class="btn btn-primary test-button" data-bs-toggle="modal"
                                                data-bs-target="#S{{ $skills_id }}-Modal{{ $title_id }}">
                                                {{ $skillsName }}
                                            </button>

                                            <div class="modal fade" tabindex="-1" role="dialog"
                                                id="S{{ $skills_id }}-Modal{{ $title_id }}">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header justify-content-center">
                                                            <div class="container justify-content-center">
                                                                <h4 class="modal-title text-center">Practice Mode</h4>
                                                            </div>

                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="modal-body text-center">
                                                                @if ($skills_id === 2)
                                                                <div class="container justify-content-center"
                                                                        style="padding: 5px">
                                                                        <div class="alert alert-warning" role="alert">
                                                                            Exam will start after clicking on the
                                                                            <strong>"Start Now"</strong> button.
                                                                        </div>
                                                                        <div class="alert alert-warning" role="alert">
                                                                            Do <strong>not reload or
                                                                                exit</strong> the page during the exam time.
                                                                        </div>
                                                                        <div class="alert alert-warning" role="alert">
                                                                            The page will
                                                                            <strong>automatically close</strong> after the
                                                                            exam time is over.
                                                                        </div>
                                                                    </div>
                                                                    <a class="iot-bt btn btn-danger"
                                                                        href="{{ route('reading', ['title_id' => $title_id, 'skills_id' => $skills_id]) }}"
                                                                        target="_blank">
                                                                        Start Now
                                                                    </a>
                                                                @elseif($skills_id === 4)
                                                                <div class="container justify-content-center"
                                                                        style="padding: 5px">
                                                                        <div class="alert alert-warning" role="alert">
                                                                            Exam will start after clicking on the
                                                                            <strong>"Start Now"</strong> button.
                                                                        </div>
                                                                        <div class="alert alert-warning" role="alert">
                                                                            Do <strong>not reload or
                                                                                exit</strong> the page during the exam time.
                                                                        </div>
                                                                        <div class="alert alert-warning" role="alert">
                                                                            The page will
                                                                            <strong>automatically close</strong> after the
                                                                            exam time is over.
                                                                        </div>
                                                                    </div>
                                                                    <a class="iot-bt btn btn-danger"
                                                                        href="{{ route('writing', ['title_id' => $title_id, 'skills_id' => $skills_id]) }}"
                                                                        target="_blank">
                                                                        Start Now
                                                                    </a>
                                                                @elseif($skills_id === 6)
                                                                <div class="container justify-content-center"
                                                                        style="padding: 5px">
                                                                        <div class="alert alert-warning" role="alert">
                                                                            Exam will start after clicking on the
                                                                            <strong>"Start Now"</strong> button.
                                                                        </div>
                                                                        <div class="alert alert-warning" role="alert">
                                                                            Do <strong>not reload or
                                                                                exit</strong> the page during the exam time.
                                                                        </div>
                                                                        <div class="alert alert-warning" role="alert">
                                                                            The page will
                                                                            <strong>automatically close</strong> after the
                                                                            exam time is over.
                                                                        </div>
                                                                    </div>
                                                                    <a class="iot-bt btn btn-danger"
                                                                        href="{{ route('listening', ['title_id' => $title_id, 'skills_id' => $skills_id]) }}"
                                                                        target="_blank">
                                                                        Start Now
                                                                    </a>
                                                                @endif
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @endforeach
                                <!-- Add more tab panes for other practice tests -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        <footer class="py-4 bg-light mt-auto">
            <div class="container-fluid px-4">
                <div class="d-flex align-items-center justify-content-between small">
                    <div class="text-muted">
                        Copyright &copy; Sheba Capital Limited 2023
                    </div>
                </div>
            </div>
        </footer>
    </div>
@endsection
