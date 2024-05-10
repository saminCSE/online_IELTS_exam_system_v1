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
        <h2>Edit Question Set</h2>
    </div>
    <div class="card">
        <div class="card-body">
            {!! Form::model($item, [
                'route' => ['questions_set.update', $item->id],
                'method' => 'PUT',
                'class' => 'custom-validation',
                'files' => true,
                'role' => 'form',
                'id' => 'edit-form',
            ]) !!}
            @csrf
            <div class="row">
                <div class="col-md-7 offset-md-2">
                    <form class="custom-validation" action="#">

                        {{-- <div class="row">
                            <div class="col-md-3 text-left">
                                {!! Form::label('type_id', 'Exam Type') !!}
                            </div>
                            <div class="col-md-9">
                                <div class="form-group">
                                    {!! Form::text('type_id', isset($item->type_id) ? $item->type_id : null, [
                                        'class' => 'form-control',
                                    ]) !!}
                                    {!! $errors->first('type_id', '<p class="help-block text-danger">:message</p>') !!}
                                </div>
                            </div>
                        </div> --}}
                        {{-- <div class="row">
                            <div class="col-md-3 text-left">
                                {!! Form::label('skills_id', 'Skill Type') !!}
                            </div>
                            <div class="col-md-9">
                                <div class="form-group">
                                    {!! Form::text('skills_id', isset($item->skills_id) ? $item->skills_id : null, [
                                        'class' => 'form-control',
                                    ]) !!}
                                    {!! $errors->first('skills_id', '<p class="help-block text-danger">:message</p>') !!}
                                </div>
                            </div>
                        </div> --}}
                        {{-- <div class="row">
                            <div class="col-md-3 text-left">
                                {!! Form::label('title_id', 'Exam Title') !!}
                            </div>
                            <div class="col-md-9">
                                <div class="form-group">
                                    {!! Form::text('title_id', isset($item->title_id) ? $item->title_id : null, [
                                        'class' => 'form-control',
                                    ]) !!}
                                    {!! $errors->first('title_id', '<p class="help-block text-danger">:message</p>') !!}
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
                                        'readonly' => 'readonly',
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
                                        'readonly' => 'readonly',
                                    ]) !!}
                                    {!! $errors->first('total_part', '<p class="help-block text-danger">:message</p>') !!}
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">

                                <div class="form-group">
                                    @php
                                        $partInfo = json_decode($item->part_info, true);
                                        // print_r($partInfo);
                                    @endphp
                                    @if (is_array($partInfo) && count($partInfo) > 0)
                                        @foreach ($partInfo as $part)
                                            <div class="row">
                                                <div class="col-lg-2">
                                                    <input type="text" name="part_info[{{ $part['id'] }}][id]"
                                                        class="form-control" value="{{ $part['id'] }}" readonly>
                                                </div>
                                                <div class="col-lg-3">
                                                    <input type="text" name="part_info[{{ $part['id'] }}][title]"
                                                        class="form-control" value="{{ $part['title'] }}"
                                                        placeholder="Title">
                                                </div>
                                                <div class="col-lg-2">
                                                    <input type="text" name="part_info[{{ $part['id'] }}][start]"
                                                        class="form-control" value="{{ $part['start'] }}"
                                                        placeholder="Start">
                                                </div>
                                                <div class="col-lg-2">
                                                    <input type="text" name="part_info[{{ $part['id'] }}][end]"
                                                        class="form-control" value="{{ $part['end'] }}" placeholder="End">
                                                </div>
                                                <div class="col-lg-3">
                                                    <input type="text"
                                                        name="part_info[{{ $part['id'] }}][short_title]"
                                                        class="form-control" value="{{ $part['short_title'] }}"
                                                        placeholder="Short Title">
                                                </div>
                                                <div class="col-lg-12" style="padding: 10px;">
                                                    <textarea name="part_info[{{ $part['id'] }}][question_passage]" class="form-control summernote"
                                                        placeholder="Question passage" id="question-passage-editor-{{ $part['id'] }}">{{ $part['question_passage'] }}</textarea>
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        No Part
                                    @endif
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
                        ['table', ['table']],
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

            var idCounter = {{ is_array($item->part_info) ? count($item->part_info) : 0 }};

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

            // Trigger input event to populate part info container with database data on page load
            $('#total_part').trigger('input');
        });
    </script>
@endsection
