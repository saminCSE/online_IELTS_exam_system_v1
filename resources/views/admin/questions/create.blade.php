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
        <h2>Create Questions</h2>
    </div>
    <div class="card">
        <div class="card-body">
            @if (isset($item))
                {!! Form::model($item, [
                    'route' => ['questions.update', $item->id],
                    'method' => 'PUT',
                    'class' => 'custom-validation',
                    'files' => true,
                    'role' => 'form',
                    'id' => 'edit-form',
                ]) !!}
            @else
                {!! Form::open([
                    'route' => ['questions.store'],
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
                                {!! Form::label('question_sets_id', 'Question Set') !!}
                            </div>
                            <div class="col-md-9">
                                <div class="form-group">
                                    {!! Form::select('question_sets_id', $set, isset($item->question_sets_id) ? $item->question_sets_id : null, [
                                        'class' => 'form-control',
                                    ]) !!}

                                    {!! $errors->first('question_sets_id', '<p class="help-block text-danger">:message</p>') !!}
                                </div>
                            </div>
                        </div>
                        {{-- <div class="row">
                    <div class="col-md-3 text-left">
                        {!! Form::label('question_type', 'Question Type') !!}
                    </div>
                    <div class="col-md-9">
                        <div class="form-group">
                            {!! Form::select('question_type', $type, isset($item->question_type) ? $item->question_type : null, [
                                'class' => 'form-control',
                            ]) !!}
                            {!! $errors->first('question_type', '<p class="help-block text-danger">:message</p>') !!}
                        </div>
                    </div>
                </div> --}}
                        <div class="row">
                            <div class="col-md-3 text-left">
                                {!! Form::label('question_type', 'Question Type') !!}
                            </div>
                            <div class="col-md-9">
                                <div class="form-group">
                                    {!! Form::select('question_type', $type, isset($item->question_type) ? $item->question_type : null, [
                                        'class' => 'form-control',
                                        'id' => 'question_type', // Add an ID to the select element
                                    ]) !!}
                                    {!! $errors->first('question_type', '<p class="help-block text-danger">:message</p>') !!}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3 text-left">
                                {!! Form::label('group_id', 'Gorup Id') !!}
                            </div>
                            <div class="col-md-9">
                                <div class="form-group">
                                    {!! Form::number('group_id', isset($item->group_id) ? $item->group_id : null, ['class' => 'form-control']) !!}

                                    {!! $errors->first('group_id', '<p class="help-block text-danger">:message</p>') !!}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3 text-left">
                                {!! Form::label('title', 'Question Title') !!}
                            </div>
                            <div class="col-md-9">
                                <div class="form-group">
                                    {!! Form::text('title', isset($item->title) ? $item->title : null, ['class' => 'form-control']) !!}

                                    {!! $errors->first('title', '<p class="help-block text-danger">:message</p>') !!}
                                </div>
                            </div>
                        </div>
                        <div class="row" id="options-div">
                            <div class="col-md-3 text-left">
                                {!! Form::label('options', 'Options') !!}
                            </div>
                            <div class="col-md-9">
                                <div class="form-group">
                                    {!! Form::text('options', isset($item->options) ? $item->options : null, [
                                        'class' => 'form-control',
                                        'id' => 'options',
                                    ]) !!}
                                    {!! $errors->first('options', '<p class="help-block text-danger">:message</p>') !!}
                                </div>
                            </div>
                        </div>
                        {{-- <div class="row" id="options-div">
                    <div class="col-md-3 text-left">
                        {!! Form::label('options', 'Options') !!}
                    </div>
                    <div class="col-md-9">
                        <div class="form-group">
                            {!! Form::text('options', isset($item->options) ? $item->options : null, [
                                'class' => 'form-control',
                                'id' => 'options',
                            ]) !!}
                            {!! $errors->first('options', '<p class="help-block text-danger">:message</p>') !!}
                        </div>
                    </div>
                </div> --}}



                        <div class="row">
                            <div class="col-md-3 text-left">
                                {!! Form::hidden('options', 'Options') !!}
                            </div>
                            <div class="col-md-9">
                                <div class="form-group">
                                    <div class="col-md-12" id="dynamic-options-container">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3 text-left">
                                {!! Form::label('correct_answer', 'Correct Answer') !!}
                            </div>
                            <div class="col-md-9">
                                <div class="form-group">
                                    {!! Form::text('correct_answer', isset($item->correct_answer) ? $item->correct_answer : null, [
                                        'class' => 'form-control',
                                    ]) !!}

                                    {!! $errors->first('correct_answer', '<p class="help-block text-danger">:message</p>') !!}
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
    {{-- <script>
        var existingOptions = @json($options ?? []);

        function updateOptions() {
            let questionType = $('#question_type').val();
            let numOptions = existingOptions.length > 0 ? existingOptions.length : parseInt($('#options').val());

            // Set the value for the 'options' field if in edit mode
            if (existingOptions.length > 0) {
                $('#options').val(numOptions);
            }

            $('#dynamic-options-container').empty();

            // Check if the question type is either '1' (radio) or '2' (checkbox)
            if (questionType === '1' || questionType === '2') {
                for (let i = 0; i < numOptions; i++) {
                    let inputContainer = $('<div>').addClass('input-container');
                    let textField = $('<input>').attr({
                        type: 'text',
                        name: 'options[]',
                        class: 'form-control input-field',
                        value: existingOptions.length > 0 ? existingOptions[i]['text'] : ''
                    });

                    let inputType = (questionType === '1') ? 'radio' : 'checkbox';
                    let inputName = (questionType === '1') ? 'correct_option' : 'correct_option[]';

                    let inputField = $('<input>').attr({
                        type: inputType,
                        name: inputName,
                        value: i + 1
                    });

                    inputField.on('change', function() {
                        let selectedOptions = $('input[name^="correct_option"]:checked');
                        let selectedValues = [];

                        selectedOptions.each(function() {
                            let text = $(this).closest('.input-container').find('.input-field').val();
                            selectedValues.push(text);
                        });

                        // Concatenate selected values with #
                        let concatenatedValues = selectedValues.join('#');

                        // Set the concatenated values to the correct_answer field
                        $('#correct_answer').val(concatenatedValues).prop('readonly', true);
                    });

                    inputContainer.append(inputField, textField);
                    $('#dynamic-options-container').append(inputContainer);
                }
            } else if (questionType === '4') {
                // Code for summernote options
                for (let i = 0; i < numOptions; i++) {
                    let inputContainer = $('<div>').addClass('input-container');
                    let summernoteField = $('<textarea>').attr({
                        name: 'options[]',
                        class: 'summernote-field',
                    });

                    inputContainer.append(summernoteField);
                    $('#dynamic-options-container').append(inputContainer);

                    // Initialize Summernote editor for each textarea
                    summernoteField.summernote({
                        height: 150, // Set the desired height
                        // ... other Summernote options ...
                    });

                    if (existingOptions.length > 0) {
                        summernoteField.summernote('code', existingOptions[i]['text']);
                    }
                }
            }
        }

        $(document).ready(function() {
            $('#question_type').on('change', function() {
                existingOptions = []; // Reset existing options when question type changes
                updateOptions();
            });

            $('#options').on('input', updateOptions);

            if (existingOptions.length > 0) {
                updateOptions(); // Call this with existing options if in edit mode
            }
        });
    </script> --}}

    {{-- <script>
        var existingOptions = @json($options ?? []);

        function updateOptions() {
            let questionType = $('#question_type').val();
            let numOptions = existingOptions.length > 0 ? existingOptions.length : parseInt($('#options').val());

            // Set the value for the 'options' field if in edit mode
            if (existingOptions.length > 0) {
                $('#options').val(numOptions);
            }

            $('#dynamic-options-container').empty();

            for (let i = 0; i < numOptions; i++) {
                let inputContainer = $('<div>').addClass('input-container');

                if (questionType === '1' || questionType === '2') {
                    // Code for radio and checkbox options
                    let textField = $('<input>').attr({
                        type: 'text',
                        name: 'options[]',
                        class: 'form-control input-field',
                        value: existingOptions.length > 0 ? existingOptions[i]['text'] : ''
                    });

                    let inputType = (questionType === '1') ? 'radio' : 'checkbox';
                    let inputName = (questionType === '1') ? 'correct_option' : 'correct_option[]';

                    let inputField = $('<input>').attr({
                        type: inputType,
                        name: inputName,
                        value: i + 1
                    });

                    inputField.on('change', function() {
                        if ($(this).prop('checked')) {
                            let selectedOption = $(this).closest('.input-container').find('.input-field').val();
                            $('#correct_answer').summernote('code', selectedOption).prop('readonly', true);
                        }
                    });

                    inputContainer.append(inputField, textField);
                }

                if (questionType === '4') {
                    // Code for summernote options and correct answer
                    let uniqueIdentifier = 'summernote' + i;

                    let summernoteField = $('<textarea>').attr({
                        name: 'options[]',
                        class: 'summernote-field',
                        id: uniqueIdentifier // Add a unique identifier for each Summernote field
                    });

                    let radioField = $('<input>').attr({
                        type: 'radio',
                        name: 'correct_option',
                        value: i + 1
                    });

                    inputContainer.append(radioField, summernoteField);

                    // Initialize Summernote editor for each textarea
                    summernoteField.summernote({
                        height: 150, // Set the desired height
                        // ... other Summernote options ...
                    });

                    radioField.on('change', function() {
                        if ($(this).prop('checked')) {
                            let selectedOption = $('#' + uniqueIdentifier).summernote('code');
                            $('#correct_answer').summernote('code', selectedOption).prop('readonly', true);
                        }
                    });

                    if (existingOptions.length > 0) {
                        summernoteField.summernote('code', existingOptions[i]['text']);
                    }
                }

                $('#dynamic-options-container').append(inputContainer);
            }
        }

        $(document).ready(function() {
            $('#question_type').on('change', function() {
                existingOptions = []; // Reset existing options when the question type changes
                updateOptions();
            });

            $('#options').on('input', updateOptions);

            if (existingOptions.length > 0) {
                updateOptions(); // Call this with existing options if in edit mode
            }

            // Trigger the AJAX call based on a different event or condition
            // For example, you can trigger it on the form submission event or any other relevant event.
            // Uncomment and modify the following lines based on your specific requirements.

            // $('#your-form-id').on('submit', function(event) {
            //     event.preventDefault();
            //     // Add the AJAX call here
            // });
        });
    </script> --}}
    <script>
        var existingOptions = @json($options ?? []);
        var selectedImageFilename = ''; // Variable to store the selected image filename

        function updateOptions() {
            let questionType = $('#question_type').val();
            let numOptions = existingOptions.length > 0 ? existingOptions.length : parseInt($('#options').val());

            // Set the value for the 'options' field if in edit mode
            if (existingOptions.length > 0) {
                $('#options').val(numOptions);
            }

            $('#dynamic-options-container').empty();

            for (let i = 0; i < numOptions; i++) {
                let inputContainer = $('<div>').addClass('input-container');

                if (questionType === '1' || questionType === '2' || questionType === '5') {
                    // Code for radio and checkbox options
                    let textField = $('<input>').attr({
                        type: 'text',
                        name: 'options[]',
                        class: 'form-control input-field',
                        value: existingOptions.length > 0 ? existingOptions[i]['text'] : ''
                    });

                    let inputType = (questionType === '1' || questionType === '5') ? 'radio' : 'checkbox';
                    let inputName = (questionType === '1' || questionType === '5') ? 'correct_option' : 'correct_option[]';

                    let inputField = $('<input>').attr({
                        type: inputType,
                        name: inputName,
                        value: i + 1
                    });

                    inputField.on('change', function() {
                        let selectedOptions = $('input[name^="correct_option"]:checked');
                        let selectedValues = [];

                        selectedOptions.each(function() {
                            let text = $(this).closest('.input-container').find('.input-field').val();
                            selectedValues.push(text);
                        });

                        // Concatenate selected values with #
                        let concatenatedValues = selectedValues.join('#');

                        // Set the concatenated values to the correct_answer field
                        $('#correct_answer').val(concatenatedValues).prop('readonly', true);
                    });

                    inputContainer.append(inputField, textField);
                    $('#dynamic-options-container').append(inputContainer);
                }

                if (questionType === '4') {
                    // Code for summernote options and correct answer
                    let uniqueIdentifier = 'summernote' + i;

                    let summernoteField = $('<textarea>').attr({
                        name: 'options[]',
                        class: 'summernote-field',
                        id: uniqueIdentifier // Add a unique identifier for each Summernote field
                    });

                    let radioField = $('<input>').attr({
                        type: 'radio',
                        name: 'correct_option',
                        value: i + 1
                    });

                    inputContainer.append(radioField, summernoteField);

                    // Initialize Summernote editor for each textarea
                    summernoteField.summernote({
                        height: 150, // Set the desired height
                        // ... other Summernote options ...
                    });

                    radioField.on('change', function() {
                        if ($(this).prop('checked')) {
                            selectedImageFilename = $('#' + uniqueIdentifier).summernote(
                                'code'); // Store the selected image filename
                            $('#correct_answer').summernote('code', $('#' + uniqueIdentifier).summernote('code'))
                                .prop('readonly', true);
                        }
                    });

                    if (existingOptions.length > 0) {
                        summernoteField.summernote('code', existingOptions[i]['text']);
                    }
                }

                $('#dynamic-options-container').append(inputContainer);
            }
        }

        $(document).ready(function() {
            $('#question_type').on('change', function() {
                existingOptions = []; // Reset existing options when the question type changes
                selectedImageFilename = ''; // Reset the selected image filename
                updateOptions();
            });

            $('#options').on('input', updateOptions);

            if (existingOptions.length > 0) {
                updateOptions(); // Call this with existing options if in edit mode
            }

            // Trigger the AJAX call based on a different event or condition
            // For example, you can trigger it on the form submission event or any other relevant event.
            // Uncomment and modify the following lines based on your specific requirements.

            // $('#your-form-id').on('submit', function(event) {
            //     event.preventDefault();
            //     // Add the AJAX call here
            // });

            // Include the selected image filename in the form data when submitting
            $('#your-form-id').on('submit', function() {
                $('#correct_answer').val(selectedImageFilename);
            });
        });
    </script>
    {{-- <script>
        var existingOptions = @json($options ?? []);
        var selectedImageFilename = '';

        function updateOptions() {
            let questionType = $('#question_type').val();
            let numOptions = existingOptions.length > 0 ? existingOptions.length : parseInt($('#options').val());

            if (existingOptions.length > 0) {
                $('#options').val(numOptions);
            }

            $('#dynamic-options-container').empty();

            for (let i = 0; i < numOptions; i++) {
                let inputContainer = $('<div>').addClass('input-container');

                if (questionType === '1' || questionType === '2') {
                    let textField = $('<input>').attr({
                        type: 'text',
                        name: 'options[]',
                        class: 'form-control input-field',
                        value: existingOptions.length > 0 ? existingOptions[i]['text'] : ''
                    });

                    let inputType = (questionType === '1') ? 'radio' : 'checkbox';
                    let inputName = (questionType === '1') ? 'correct_option' : 'correct_option[]';

                    let inputField = $('<input>').attr({
                        type: inputType,
                        name: inputName,
                        value: i + 1
                    });

                    inputField.on('change', function() {
                        let selectedOptions = $('input[name^="correct_option"]:checked');
                        let selectedValues = selectedOptions.map(function() {
                            return $(this).closest('.input-container').find('.input-field').val();
                        }).get();

                        let concatenatedValues = selectedValues.join('#');
                        $('#correct_answer').val(concatenatedValues).prop('readonly', true);
                    });

                    inputContainer.append(inputField, textField);
                    $('#dynamic-options-container').append(inputContainer);
                }

                if (questionType === '4') {
                    let uniqueIdentifier = 'summernote' + i;

                    let summernoteField = $('<textarea>').attr({
                        name: 'options[]',
                        class: 'summernote-field',
                        id: uniqueIdentifier
                    });

                    let radioField = $('<input>').attr({
                        type: 'radio',
                        name: 'correct_option',
                        value: i + 1
                    });

                    inputContainer.append(radioField, summernoteField);

                    summernoteField.summernote({
                        height: 150,
                        // ... other Summernote options ...
                    });

                    radioField.on('change', function() {
                        if ($(this).prop('checked')) {
                            selectedImageFilename = $('#' + uniqueIdentifier).summernote('code');
                            $('#correct_answer').summernote('code', $('#' + uniqueIdentifier).summernote('code'))
                                .prop('readonly', true);
                        }
                    });

                    if (existingOptions.length > 0) {
                        summernoteField.summernote('code', existingOptions[i]['text']);
                    }
                }

                $('#dynamic-options-container').append(inputContainer);
            }
        }

        $(document).ready(function() {
            $('#question_type, #options').on('change input', updateOptions);

            if (existingOptions.length > 0) {
                updateOptions();
            }

            $('#your-form-id').on('submit', function() {
                $('#correct_answer').val(selectedImageFilename);
            });
        });
    </script> --}}












    <style>
        .input-field {
            margin-bottom: 10px;
            border-radius: 40px;
            width: 300px;
        }

        .input-container {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
            border-radius: 40px;
        }

        input[type="checkbox"],
        input[type="radio"] {
            box-sizing: border-box;
            padding: 0;
            margin-right: 10px;
        }
    </style>

    <script>
        function updateOptionsVisibility() {
            const questionType = document.getElementById('question_type').value;
            const optionsDiv = document.getElementById('options-div');

            if (questionType === '3') {
                optionsDiv.style.display = 'none';
            } else {
                optionsDiv.style.display = 'flex';
            }
        }

        // Initialize visibility based on the current value
        updateOptionsVisibility();

        // Add an event listener to update visibility when the question type changes
        document.getElementById('question_type').addEventListener('change', updateOptionsVisibility);
    </script>
@endsection
