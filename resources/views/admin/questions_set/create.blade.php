@extends('layouts.master.admin')
@section('css')
    <!-- datatables css -->
    <!-- <link href="{{ URL::asset('assets/libs/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css"/> -->
    <link href="{{ URL::asset('assets/libs/select2/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote-bs4.min.css" rel="stylesheet">
    <style>
        table,
        td,
        th {
            vertical-align: middle !important;
        }

        table th {
            font-weight: bold;
        }
    </style>
@endsection
@section('content')
    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    <div class="row justify-content-center">
        <h2>Create Question Set</h2>
    </div>
    <div class="card">
        <div class="card-body">
            @if (isset($item))
                {!! Form::model($item, [
                    'route' => ['questions_set.update', $item->id],
                    'method' => 'PUT',
                    'class' => 'custom-validation',
                    'files' => true,
                    'role' => 'form',
                    'id' => 'edit-form',
                ]) !!}
            @else
                {!! Form::open([
                    'route' => ['questions_set.store'],
                    'method' => 'POST',
                    'class' => 'custom-validation',
                    'files' => true,
                    'role' => 'form',
                    'id' => 'add-form',
                ]) !!}
                @csrf
            @endif
            <div class="row">
                <div class="col-md-7 offset-md-2">
                    <form class="custom-validation" action="#">

                        <div class="row">
                            <div class="col-md-3 text-left">
                                {!! Form::label('type_id', 'Exam Type') !!}
                            </div>
                            <div class="col-md-9">
                                <div class="form-group">
                                    {!! Form::select('type_id', $type, isset($item->type) ? $item->type : null, [
                                        'class' => 'form-control',
                                        'id' => 'type_id',
                                    ]) !!}

                                    {!! $errors->first('type_id', '<p class="help-block text-danger">:message</p>') !!}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3 text-left">
                                {!! Form::label('skills_id', 'Skill Type') !!}
                            </div>
                            <div class="col-md-9">
                                <div class="form-group">
                                    {!! Form::select('skills_id', [], null, [
                                        'class' => 'form-control',
                                        'id' => 'skills_id',
                                    ]) !!}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3 text-left">
                                {!! Form::label('title_id', 'Exam Title') !!}
                            </div>
                            <div class="col-md-9">
                                <div class="form-group">
                                    {!! Form::select('title_id', $testTitle, isset($item->title_id) ? $item->title_id : null, [
                                        'class' => 'form-control',
                                    ]) !!}

                                    {!! $errors->first('title_id', '<p class="help-block text-danger">:message</p>') !!}
                                </div>
                            </div>
                        </div>
                        {{-- <div class="row">
                            <div class="col-md-3 text-left">
                                {!! Form::label('exam_taken', 'Exam Taken') !!}
                            </div>
                            <div class="col-md-9">
                                <div class="form-group">
                                    {!! Form::text('exam_taken', isset($item->exam_taken) ? $item->exam_taken : null, ['class' => 'form-control']) !!}

                                    {!! $errors->first('exam_taken', '<p class="help-block text-danger">:message</p>') !!}
                                </div>
                            </div>
                        </div> --}}
                        <div class="row">
                            <div class="col-md-3 text-left">
                                {!! Form::label('exam_duration', 'Exam duration') !!}
                            </div>
                            <div class="col-md-9">
                                <div class="form-group">
                                    {!! Form::text('exam_duration', isset($item->exam_duration) ? $item->exam_duration : null, [
                                        'class' => 'form-control',
                                    ]) !!}

                                    {!! $errors->first('exam_duration', '<p class="help-block text-danger">:message</p>') !!}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3 text-left">
                                {!! Form::label('total_question', 'Total question') !!}
                            </div>
                            <div class="col-md-9">
                                <div class="form-group">
                                    {!! Form::text('total_question', isset($item->total_question) ? $item->total_question : null, [
                                        'class' => 'form-control',
                                    ]) !!}

                                    {!! $errors->first('total_question', '<p class="help-block text-danger">:message</p>') !!}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3 text-left">
                                {!! Form::label('total_part', 'Total part') !!}
                            </div>
                            <div class="col-md-9">
                                <div class="form-group">
                                    {!! Form::text('total_part', isset($item->total_part) ? $item->total_part : null, [
                                        'class' => 'form-control',
                                        'id' => 'total_part',
                                    ]) !!}

                                    {!! $errors->first('total_part', '<p class="help-block text-danger">:message</p>') !!}
                                </div>
                            </div>
                        </div>

                        <div class="row">

                            <div class="col-md-12">
                                <div class="form-group" id="part-info-container">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-3 text-left">
                                {!! Form::label('audio_file', 'Audio File') !!}
                            </div>
                            <div class="col-md-9">
                                <div class="form-group">
                                    {!! Form::file('audio_file', isset($item->audio_file) ? $item->audio_file : null, [
                                        'class' => 'form-control',
                                    ]) !!}

                                    {!! $errors->first('audio_file', '<p class="help-block text-danger">:message</p>') !!}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3 text-left">
                                {!! Form::label('is_active', 'Status') !!}
                            </div>
                            <div class="col-md-9">
                                <div class="form-group">
                                    {!! Form::select('is_active', $is_active, isset($item->is_active) ? $item->is_active : 1, [
                                        'class' => 'form-control',
                                    ]) !!}

                                    {!! $errors->first('is_active', '<p class="help-block text-danger">:message</p>') !!}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <div class="form-group mb-0">
                                    <div>
                                        <button type="submit" class="btn btn-primary waves-effect waves-light mr-1">
                                            Submit
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>


        </div>
    </div> <!-- end col -->
@endsection

@section('scripts')
    <!-- Plugins js -->
    <!-- <script src="{{ URL::asset('assets/libs/datatables/datatables.min.js') }}"></script>
                                                                                                                                                                        <script src="{{ URL::asset('assets/js/pages/datatables.init.js') }}"></script>
                                                                                                                                                                        <script src="{{ URL::asset('assets/libs/jquery-ui/jquery-ui.min.js') }}"></script> -->
    <script src="{{ URL::asset('assets/libs/select2/select2.min.js') }}"></script>
    <script src="{{ URL::asset('assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote-bs4.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.summernote').each(function(index) {
                initializeSummernote($(this));
            });

            function initializeSummernote(element) {
                element.summernote({
                    height: 300,
                    toolbar: [
                        ['style', ['bold', 'italic', 'underline', 'clear']],
                        ['font', ['strikethrough']],
                        ['table', ['table']], // Add the 'table' option
                        ['para', ['ul', 'ol', 'paragraph']],
                        ['insert', ['link', 'picture']],
                    ],
                    callbacks: {
                        onImageUpload: function(files) {
                            uploadImage(files[0], element);
                        },
                    },
                });
            }

            function uploadImage(file, element) {
                let formData = new FormData();
                formData.append('file', file);
                const csrfToken = $('meta[name="csrf-token"]').attr('content');

                // Include the CSRF token in the request headers
                const headers = {
                    'X-CSRF-TOKEN': csrfToken
                };
                $.ajax({
                    url: "{{ route('image_uploading') }}",
                    method: 'POST',
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(data) {
                        var imageLink = data.url;
                        element.summernote('insertImage', imageLink);
                    },
                    error: function(data) {
                        console.error(data);
                    }
                });
            }

            var idCounter = 0;

            $('#type_id').change(function() {
                var type_id = $(this).val();
                var skillsDropdown = $('#skills_id');
                $.ajax({
                    type: 'POST',
                    url: "{{ route('skill_fetch') }}",
                    data: {
                        type_id: type_id
                    },
                    success: function(data) {
                        skillsDropdown.empty();
                        skillsDropdown.append($('<option>', {
                            value: '',
                            text: 'Select Skill...',
                        }));
                        $.each(data, function(key, value) {
                            skillsDropdown.append($('<option>', {
                                value: key,
                                text: value,
                            }));
                        });
                    },
                });
            });

            $('#total_part').on('input', function() {
                var totalPart = parseInt($(this).val()) || 0;
                var partInfoContainer = $('#part-info-container');
                partInfoContainer.empty();
                for (var i = 1; i <= totalPart; i++) {
                    partInfoContainer.append(
                        '<div class="row">' +
                        '<div class="col-lg-2">' +
                        '<input type="text" name="part_info[' + idCounter +
                        '][id]" class="form-control" value="' + i + '" readonly>' +
                        '</div>' +
                        '<div class="col-lg-3">' +
                        '<input type="text" name="part_info[' + idCounter +
                        '][title]" class="form-control" placeholder="Title">' +
                        '</div>' +
                        '<div class="col-lg-2">' +
                        '<input type="text" name="part_info[' + idCounter +
                        '][start]" class="form-control" placeholder="Start">' +
                        '</div>' +
                        '<div class="col-lg-2">' +
                        '<input type="text" name="part_info[' + idCounter +
                        '][end]" class="form-control" placeholder="End">' +
                        '</div>' +
                        '<div class="col-lg-3">' +
                        '<input type="text" name="part_info[' + idCounter +
                        '][short_title]" class="form-control" placeholder="Short Title">' +
                        '</div>' +
                        '<div class="col-lg-12" style="padding: 10px;">' +
                        '<textarea name="part_info[' + idCounter +
                        '][question_passage]" class="form-control summernote" placeholder="Question passage" id="question-passage-editor-' +
                        idCounter + '"></textarea>' +
                        '</div>' +
                        '</div>'
                    );
                    initializeSummernote($('#question-passage-editor-' + idCounter));
                    idCounter++;
                }
            });
        });
    </script>
@endsection
