@extends('layouts.master.admin')
@section('css')
    <!-- datatables css -->
    <link href="{{ URL::asset('assets/libs/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
@endsection

@section('content')
    <div class="card shadow mb-12">
        @if (session('status'))
            <div class="alert alert-success">{{ session('status') }}</div>
        @elseif(session('delete_status'))
            <div class="alert alert-danger">{{ session('delete_status') }}</div>
        @endif
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <table id="datatable" class="table table-bordered dt-responsive nowrap"
                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th class="th-sm">SL</th>
                                    <th class="th-sm">Test Title</th>
                                    <th class="th-sm">Skill Type</th>
                                    <th class="th-sm">Student Name</th>
                                    <th class="th-sm">Answer</th>
                                    <th class="th-sm">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($item as $ans)
                                    <?php
                                    $parentId = $loop->iteration;
                                    $submitAnswers = json_decode($ans->submit_answer, true);
                                    ?>
                                    <tr>
                                        <th scope="row">{{ $loop->iteration }}</th>
                                        <td>{{ $ans->test_title }}</td>
                                        <td>{{ $ans->skill_title }}</td>
                                        <td>{{ $ans->student_name }}</td>
                                        <td>
                                            @if (isset($submitAnswers))
                                                @foreach ($submitAnswers as $submitAnswer)
                                                    <table>
                                                        <tr>
                                                            <td>Task:{{ $loop->iteration }}</td>
                                                            <td>
                                                                <button type="button"
                                                                    class="btn btn-info btn-sm view-passage-button"
                                                                    data-toggle="modal" data-target="#passageModal"
                                                                    data-passage="{{ nl2br($submitAnswer['text']) }}">
                                                                    View Essay
                                                                </button>
                                                                <!-- Modal -->
                                                            </td>
                                                        </tr>
                                                    </table>
                                                @endforeach
                                            @else
                                            <i>No Answer</i>
                                            @endif

                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-primary btn-sm score-update-button"
                                                data-toggle="modal" data-target="#scoreUpdateModal"
                                                data-question-set-id="{{ $ans->question_sets_id }}"
                                                data-student-id="{{ $ans->student_id }}">
                                                Score Update
                                            </button>
                                        </td>

                                    </tr>
                                    {{-- @if (!count($announce)) --}}
                                    {{-- <tr class="row1"> --}}
                                    {{-- <td colspan="8" class="text-center"> No record found. </td> --}}

                                    {{-- </tr> --}}

                                    {{-- @endif --}}
                                @endforeach
                            </tbody>
                        </table>
                        <div class="modal fade" id="passageModal" tabindex="-1" role="dialog"
                            aria-labelledby="passageModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="passageModalLabel">Essay</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body" style="overflow-y: auto; max-height: 75vh; min-width: 100%;">

                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal fade" id="scoreUpdateModal" tabindex="-1" role="dialog"
                            aria-labelledby="scoreUpdateModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="scoreUpdateModalLabel">Score Update</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form id="score-update-form">
                                            @csrf
                                            <input type="hidden" name="question_set_id" id="question_set_id">
                                            <input type="hidden" name="student_id" id="student_id">
                                            <div class="form-group">
                                                <label for="score">Score:</label>
                                                <input type="number" class="form-control" name="score" id="score"
                                                    required>
                                            </div>
                                            <button type="submit" class="btn btn-primary">Submit</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        @endsection
        @section('scripts')
            <script src="{{ URL::asset('assets/libs/datatables/datatables.min.js') }}"></script>
            <script src="{{ URL::asset('assets/js/pages/datatables.init.js') }}"></script>
            <script src="{{ URL::asset('assets/libs/jquery-ui/jquery-ui.min.js') }}"></script>
            <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
            <script>
                $(document).ready(function() {

                    $(document).on('click', '.view-passage-button', function() {
                        var passageData = $(this).attr('data-passage');

                        $("#passageModal").find('.modal-body').html(passageData);
                    });

                    $(function() {
                        $('.toggle-class').change(function clickAlert() {
                            var is_active = $(this).prop('checked') == true ? 1 : 0;
                            var id = $(this).data('id');
                            alert("Are you sure you want to update status?");
                            $.ajax({
                                type: "POST",
                                dataType: "json",
                                url: "/sets/update",
                                data: {
                                    'is_active': is_active,
                                    'id': id
                                },
                                success: function(data) {
                                    console.log(data.success)
                                }
                            });
                        })
                    })
                });
            </script>
            <script>
                $(document).ready(function() {
                    $(document).on('click', '.score-update-button', function() {
                        var questionSetId = $(this).data('question-set-id');
                        var studentId = $(this).data('student-id');

                        $("#question_set_id").val(questionSetId);
                        $("#student_id").val(studentId);
                    });

                    $("#score-update-form").submit(function(event) {
                        event.preventDefault();

                        var questionSetId = $("#question_set_id").val();
                        var studentId = $("#student_id").val();
                        var score = $("#score").val();

                        $.ajax({
                            type: "POST",
                            dataType: "json",
                            url: "{{ route('update_writting_score') }}", // Update this URL to the correct route
                            data: {
                                'question_set_id': questionSetId,
                                'student_id': studentId,
                                'score': score
                            },
                            success: function(data) {
                                if (data.success) {
                                    alert("Score updated successfully.");
                                    $('#scoreUpdateModal').modal('hide');
                                }
                            }
                        });
                    });
                });
            </script>
        @endsection
