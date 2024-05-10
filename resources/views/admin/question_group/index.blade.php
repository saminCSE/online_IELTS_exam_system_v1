@extends('layouts.master.admin')
@section('css')
    <!-- datatables css -->
    <link href="{{ URL::asset('assets/libs/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
@endsection

@section('content')
    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    <div class="card shadow mb-12">
        @if (session('status'))
            <div class="alert alert-success">{{ session('status') }}</div>
        @elseif(session('delete_status'))
            <div class="alert alert-danger">{{ session('delete_status') }}</div>
        @endif
        <div class="row justify-content-center">
            <h2>Group Questions List</h2>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
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
                        <table id="datatable" class="table table-bordered dt-responsive nowrap"
                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th class="th-sm">SL</th>
                                    <th class="th-sm">Group Id</th>
                                    <th class="th-sm">Question</th>
                                    <th class="th-sm">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($items as $item)
                                    <tr>
                                        <th scope="row">{{ $loop->iteration }}</th>
                                        <td>{{ $item->id }}</td>
                                        <td>{!! replaceInputsAndDropdowns(json_decode($item->questions)) !!}</td>

                                        <td>
                                            <a href="{{ url('question_group/' . $item->id . '/edit') }}"
                                                class="btn btn-warning btn-xs mr-3" data-toggle="tooltip" title="Edit"
                                                style="display:inline;padding:2px 5px 3px 5px;">
                                                <i class="fa fa-edit"></i>
                                            </a>

                                            {!! Form::open([
                                                'route' => ['questions_group.question_group_delete', $item->id],
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
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


    @php

        // function replaceInputs($inputString)
        // {
        //     // Define a regular expression pattern to match $inputX
        //     $pattern = '/(\$input\d+)/';

        //     // Counter variable
        //     $count = 1;

        //     // Replace matches with <input></input> and increment the counter
        //     $replacement = function ($matches) use (&$count) {
        //         $inputTag = '<input style="padding: 5px 10px; border-radius: 50px; border: 2px solid gray;text-align:center" placeholder="' . $count . '">';
        //         $count++;
        //         return $inputTag;
        //     };

        //     // Perform the replacement
        //     $result = preg_replace_callback($pattern, $replacement, $inputString);

        //     return $result;
        // }

        function replaceInputsAndDropdowns($inputString)
        {
            // Define regular expression patterns
            $inputPattern = '/(\$input\d+)/';
            $dropdownPattern = '/\$dropdown(\d+)@([^$]+)\$([^<]+)/';

            // Counter variables
            $inputCount = 1;
            $dropdownCount = 1;

            // Replace $inputX with <input></input> and $dropdownX with dropdown
            $replacement = function ($matches) use (&$inputCount, &$dropdownCount) {
                if (strpos($matches[0], '$input') !== false) {
                    $inputTag = '<input style="padding: 5px 10px; border-radius: 50px; border: 2px solid gray;text-align:center" placeholder="' . $inputCount . '">';
                    $inputCount++;
                    return $inputTag;
                } elseif (strpos($matches[0], '$dropdown') !== false) {
                    // Extract the dropdown details dynamically
                    $dropdownNumber = $matches[1];
                    $options = explode('@', $matches[2]);
                    $questionTitle = $matches[3];

                    $dropdownTag = '<select data-num="' . $dropdownNumber . '">';

                    foreach ($options as $option) {
                        $dropdownTag .= '<option>' . $option . '</option>';
                    }

                    $dropdownTag .= '</select>';

                    $dropdownTag .= '<span class="question-title">' . $questionTitle . '</span>';

                    $dropdownCount++;
                    // You can use $questionTitle as needed for your application

                    return $dropdownTag;
                }
            };

            // Perform the replacement for both patterns
            $result = preg_replace_callback($inputPattern, $replacement, $inputString);
            $result = preg_replace_callback($dropdownPattern, $replacement, $result);

            return $result;
        }

    @endphp
@endsection

@section('scripts')
    <script src="{{ URL::asset('assets/libs/datatables/datatables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/js/pages/datatables.init.js') }}"></script>
    <script src="{{ URL::asset('assets/libs/jquery-ui/jquery-ui.min.js') }}"></script>
    <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
@endsection
