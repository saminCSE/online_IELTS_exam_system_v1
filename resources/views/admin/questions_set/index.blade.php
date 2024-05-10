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
                        <h1 class="text-center">Active Sets</h1>
                        <table id="datatable" class="table table-bordered dt-responsive nowrap"
                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th class="th-sm">SL</th>
                                    <th class="th-sm">Title</th>
                                    <th class="th-sm">Exam Type</th>
                                    <th class="th-sm">Skill Type</th>
                                    <th class="th-sm">Exam Taken</th>
                                    <th class="th-sm">Exam Duration</th>
                                    <th class="th-sm">Total Question</th>
                                    <th class="th-sm">Total Part</th>
                                    <th class="th-sm">Action</th>
                                    <th class="th-sm">Part Info</th>
                                    <th class="th-sm">Audio File</th>
                                    <th class="th-sm">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($questions_set as $sets)
                                    <?php
                                    $parentId = $loop->iteration;
                                    ?>
                                    @if ($sets->is_active)
                                        <tr>
                                            <th scope="row">{{ $loop->iteration }}</th>
                                            <td>{{ $sets->test_title }}</td>
                                            <td>{{ $sets->type_title }}</td>
                                            <td>{{ $sets->skill_title }}</td>
                                            <td>{{ $sets->exam_taken }}</td>
                                            <td>{{ $sets->exam_duration }}</td>
                                            <td>{{ $sets->total_question }}</td>
                                            <td>{{ $sets->total_part }}</td>
                                            {{-- <td> <input data-id="{{ $sets->id }}" class="toggle-class" type="checkbox"
                                                    data-onstyle="success" onclick="clickAlert()" data-offstyle="danger"
                                                    data-toggle="toggle" data-on="Approved" data-off="Pending"
                                                    {{ $sets->is_active ? 'checked' : '' }}></td> --}}
                                            <td><a href="{{ route('set.inactive', ['type_id' => $sets->type_id, 'title_id' => $sets->title_id]) }}"
                                                    class="btn btn-danger">Inctive</a></td>
                                            <td>
                                                @if (is_array($sets->part_info) && count($sets->part_info) > 0)
                                                    @foreach ($sets->part_info as $part)
                                                        <table>
                                                            <tr>
                                                                <td>{{ $part->id }}</td>
                                                                <td>{{ $part->title }}</td>
                                                                <td>{{ $part->start }}</td>
                                                                <td>{{ $part->end }}</td>
                                                                <td>{{ $part->short_title }}</td>
                                                                <td>
                                                                    @if (isset($part->question_passage))
                                                                        <button type="button"
                                                                            class="btn btn-info btn-sm view-passage-button"
                                                                            data-toggle="modal" data-target="#passageModal"
                                                                            data-passage="{{ $part->question_passage }}">
                                                                            View Passage
                                                                        </button>
                                                                        <!-- Modal -->
                                                                    @else
                                                                        N/A
                                                                    @endif
                                                                </td>

                                                            </tr>
                                                        </table>
                                                    @endforeach
                                                @else
                                                    No part info available.
                                                @endif
                                            </td>
                                            <td>
                                                @if (!empty($sets->audio_file))
                                                    <audio class="audio-player" controls>
                                                        <source src="{{ asset($sets->audio_file) }}" type="audio/mpeg" />
                                                        Your browser does not support the audio element.
                                                    </audio>
                                                @else
                                                    N/A
                                                @endif
                                            </td>

                                            <td>
                                                 <a href="{{ url('questions_set/' . $sets->id . '/edit') }}" class="btn btn-warning btn-xs mr-3" data-toggle="tooltip" title="Edit" style="display:inline;padding:2px 5px 3px 5px;">
                                                    <i class="fa fa-edit"></i>
                                                </a>

                                                {!! Form::open([
                                                    'route' => ['questions_set.destroy', $sets->id],
                                                    'method' => 'delete',
                                                    'style' => 'display:inline',
                                                ]) !!}
                                                <button class="btn btn-danger btn-xs text-white" data-toggle="tooltip"
                                                    title="Delete" style="display:inline;padding:2px 5px 3px 5px;"
                                                    onclick="return confirm('Are you sure to delete this ?')"><i
                                                        class="fas fa-times"></i>
                                                </button>
                                                {!! Form::close() !!}
                                            </td>
                                        </tr>
                                        {{-- @if (!count($announce)) --}}
                                        {{-- <tr class="row1"> --}}
                                        {{-- <td colspan="8" class="text-center"> No record found. </td> --}}

                                        {{-- </tr> --}}

                                        {{-- @endif --}}
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                        <div class="modal fade" id="passageModal" tabindex="-1" role="dialog"
                            aria-labelledby="passageModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="passageModalLabel">Passage</h5>
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
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h1 class="text-center">Inactive Sets</h1>
                        <table id="datatable1" class="table table-bordered dt-responsive nowrap"
                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th class="th-sm">SL</th>
                                    <th class="th-sm">Title</th>
                                    <th class="th-sm">Exam Type</th>
                                    <th class="th-sm">Skill Type</th>
                                    <th class="th-sm">Exam Taken</th>
                                    <th class="th-sm">Exam Duration</th>
                                    <th class="th-sm">Total Question</th>
                                    <th class="th-sm">Total Part</th>
                                    <th class="th-sm">Action</th>
                                    <th class="th-sm">Part Info</th>
                                    <th class="th-sm">Audio File</th>
                                    <th class="th-sm">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($questions_set as $sets)
                                    <?php
                                    $parentId = $loop->iteration;
                                    ?>
                                    @if (!$sets->is_active)
                                        <tr>
                                            <th scope="row">{{ $loop->iteration }}</th>
                                            <td>{{ $sets->test_title }}</td>
                                            <td>{{ $sets->type_title }}</td>
                                            <td>{{ $sets->skill_title }}</td>
                                            <td>{{ $sets->exam_taken }}</td>
                                            <td>{{ $sets->exam_duration }}</td>
                                            <td>{{ $sets->total_question }}</td>
                                            <td>{{ $sets->total_part }}</td>
                                            {{-- <td> <input data-id="{{ $sets->id }}" class="toggle-class" type="checkbox"
                                                data-onstyle="success" onclick="clickAlert()" data-offstyle="danger"
                                                data-toggle="toggle" data-on="Approved" data-off="Pending"
                                                {{ $sets->is_active ? 'checked' : '' }}></td> --}}
                                            <td><a href="{{ route('set.active', ['type_id' => $sets->type_id, 'title_id' => $sets->title_id]) }}"
                                                    class="btn btn-success">Active</a></td>
                                            <td>
                                                @if (is_array($sets->part_info) && count($sets->part_info) > 0)
                                                    @foreach ($sets->part_info as $part)
                                                        <table>
                                                            <tr>
                                                                <td>{{ $part->id }}</td>
                                                                <td>{{ $part->title }}</td>
                                                                <td>{{ $part->start }}</td>
                                                                <td>{{ $part->end }}</td>
                                                                <td>{{ $part->short_title }}</td>
                                                                <td>
                                                                    @if (isset($part->question_passage))
                                                                        <button type="button"
                                                                            class="btn btn-info btn-sm view-passage-button"
                                                                            data-toggle="modal" data-target="#passageModal"
                                                                            data-passage="{{ $part->question_passage }}">
                                                                            View Passage
                                                                        </button>
                                                                        <!-- Modal -->
                                                                    @else
                                                                        N/A
                                                                    @endif
                                                                </td>

                                                            </tr>
                                                        </table>
                                                    @endforeach
                                                @else
                                                    No part info available.
                                                @endif
                                            </td>
                                            <td>
                                                @if (!empty($sets->audio_file))
                                                    <audio class="audio-player" controls>
                                                        <source src="{{ asset($sets->audio_file) }}" type="audio/mpeg" />
                                                        Your browser does not support the audio element.
                                                    </audio>
                                                @else
                                                    N/A
                                                @endif
                                            </td>

                                            <td>
                                                <a href="{{ url('questions_set/' . $sets->id . '/edit') }}"
                                                    class="btn btn-warning btn-xs mr-3" data-toggle="tooltip"
                                                    title="Edit" style="display:inline;padding:2px 5px 3px 5px;">
                                                    <i class="fa fa-edit"></i>
                                                </a>

                                                {!! Form::open([
                                                    'route' => ['questions_set.destroy', $sets->id],
                                                    'method' => 'delete',
                                                    'style' => 'display:inline',
                                                ]) !!}
                                                <button class="btn btn-danger btn-xs text-white" data-toggle="tooltip"
                                                    title="Delete" style="display:inline;padding:2px 5px 3px 5px;"
                                                    onclick="return confirm('Are you sure to delete this ?')"><i
                                                        class="fas fa-times"></i>
                                                </button>
                                                {!! Form::close() !!}
                                            </td>
                                        </tr>
                                        {{-- @if (!count($announce)) --}}
                                        {{-- <tr class="row1"> --}}
                                        {{-- <td colspan="8" class="text-center"> No record found. </td> --}}

                                        {{-- </tr> --}}

                                        {{-- @endif --}}
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                        <div class="modal fade" id="passageModal" tabindex="-1" role="dialog"
                            aria-labelledby="passageModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="passageModalLabel">Passage</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body" style="overflow-y: auto; max-height: 75vh; min-width: 100%;">

                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-dismiss="modal">Close</button>
                                    </div>
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
        {{-- <script>
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
                            url: "{{ route('sets_update') }}",
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
        </script> --}}
        <script>
            $(document).ready(function() {

                $(document).on('click', '.view-passage-button', function() {
                    var passageData = $(this).attr('data-passage');

                    $("#passageModal").find('.modal-body').html(passageData);
                });

                function initToggleButtons() {
                    $('.toggle-class').bootstrapToggle({
                        on: 'Active',
                        off: 'Inactive',
                        onstyle: 'success',
                        offstyle: 'danger'
                    });
                }

                $(function() {
                    initToggleButtons();

                    // Handle toggle change
                    $(document).on('change', '.toggle-class', function() {
                        var is_active = $(this).prop('checked') == true ? 1 : 0;
                        var id = $(this).data('id');
                        alert("Are you sure you want to update status?");
                        $.ajax({
                            type: "POST",
                            dataType: "json",
                            url: "{{ route('sets_update') }}",
                            data: {
                                'is_active': is_active,
                                'id': id
                            },
                            success: function(data) {
                                console.log(data.success)
                            }
                        });
                    });

                    // Reinitialize toggles after each draw
                    $('#datatable').on('draw.dt', function() {
                        // Destroy existing Bootstrap Toggle instances
                        $('.toggle-class').bootstrapToggle('destroy');
                        // Reinitialize Bootstrap Toggle
                        initToggleButtons();
                    });
                });
            });
        </script>
        <script>
            $(document).ready(function() {
                $('#datatable1').DataTable();
            });
        </script>
    @endsection
