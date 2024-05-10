@extends('layouts.master.admin')
@section('css')
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

        /* Increase height of Summernote editor */
        .note-editable {
            height: 300px;
            /* Adjust the height as needed */
        }

        /* Increase height of textarea */
        textarea {
            height: 300px;
            /* Adjust the height as needed */
        }
    </style>
@endsection
@section('content')
    <div class="row justify-content-center">
        <h2>Create Group Question</h2>
    </div>
    <div class="row">

        <div class="col-md-7 offset-md-2">
            <div class="form-group">
                @if (session()->has('message'))
                    <div class="alert alert-success alert-dismissable">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <strong>{{ session()->get('message') }}</strong>
                    </div>
                @endif
                @if (session()->has('error'))
                    <div class="alert alert-danger alert-dismissable">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        @if (is_array(session()->get('error')))
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach (session()->get('error') as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @else
                            <strong>{{ session()->get('error') }}</strong>
                        @endif
                    </div>
                @endif
                {{-- {{dd($errors)}} --}}
                @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="js-message-wrap">

                </div>

                @if (isset($edititem))
                    <form id="question-form"
                        action="{{ route('questions_group.question_group_update', ['id' => $edititem->id]) }}"
                        method="POST">
                    @else
                        <form id="question-form" action="{{ route('store-question-group') }}" method="POST">
                @endif



                @csrf
                <div class="mb-3 row">
                    <label for="staticEmail" class="col-sm-2 col-form-label">Id</label>
                    <div class="col-sm-10">
                        <input type="number" class="form-control mb-3"
                            value="{{ isset($edititem) ? $edititem->id : old('id') }}" name="id">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="staticEmail" class="col-sm-2 col-form-label">Question</label>
                    <div class="col-sm-10">
                        <textarea class="mb-3" name="question" id="summernote" placeholder="Enter your question...">{{ isset($edititem) ? $edititem->questions : old('question') }}</textarea>
                    </div>
                </div>
                {{-- <div class="mb-3 row">
                    <label for="staticEmail" class="col-sm-2 col-form-label"></label>
                    <div class="col-sm-10">
                        <button class="mt-3 m-auto" type="submit" id="submit-form"
                            style="border-radius: 5px">Submit</button>
                    </div>
                </div> --}}
                <div class="mb-3 row">
                    <div class="col-sm-6 text-center">
                        <div class="form-group mb-0">
                            <div>
                                <button type="submit" id="submit-form"
                                    class="btn btn-primary waves-effect waves-light mr-1">
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
@endsection

@section('scripts')
    <script src="{{ URL::asset('assets/libs/jquery-ui/jquery-ui.min.js') }}"></script>
    <script src="{{ URL::asset('assets/libs/select2/select2.min.js') }}"></script>
    <script src="{{ URL::asset('assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote-bs4.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#summernote').summernote();
        });

        $('#submit-form').on('click', function() {
            // Collect Summernote content in JSON format
            var questionContent = $('#summernote').summernote('code');
            var jsonData = JSON.stringify({
                question: questionContent
            });

            // Send JSON data to the server
            $.ajax({
                method: 'POST',
                url: '/store-question-group', // Update this URL to match your route
                data: {
                    questionData: jsonData
                },
                success: function(response) {
                    // console.log(response);
                },
                error: function(error) {
                    console.error(error);
                }
            });
        });
    </script>
@endsection
