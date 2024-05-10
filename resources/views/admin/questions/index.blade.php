@extends('layouts.master.admin')
@section('css')
    <!-- datatables css -->
    <link href="{{ URL::asset('assets/libs/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
@endsection

@section('content')
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
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
            <h2>Questions List</h2>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        {{-- Dropdown for Test Title Selection --}}
                        <select id="test-title-select" class="form-control mb-3">
                            <option value="">Select Test Title</option>
                            @foreach ($tests as $test)
                                <option value="{{ $test->id }}">{{ $test->title }}</option>
                            @endforeach
                        </select>

                        {{-- Dropdown for Skill Selection --}}
                        <select id="skill-select" class="form-control mb-3" disabled>
                            <option value="">Select Skill</option>
                            @foreach ($skills as $skill)
                                <option value="{{ $skill->id }}">{{ $skill->title }}</option>
                            @endforeach
                        </select>

                        {{-- Table Structure --}}
                        <div class="table-responsive">
                            <table id="datatable_custom" class="table table-bordered" style="width: 100%;">
                                <thead>
                                    <tr>
                                        <th class="th-sm">SL</th>
                                        <th class="th-sm">Question Title</th>
                                        <th class="th-sm">Option Title</th>
                                        <th class="th-sm">Correct Answer</th>
                                        <th class="th-sm">Status</th>
                                        <th class="th-sm">Group Id</th>
                                        <th class="th-sm">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="table-body">
                                    {{-- Table rows will be inserted here --}}
                                </tbody>
                            </table>
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
        document.getElementById('test-title-select').addEventListener('change', function() {
            // Enable skill selection upon choosing a test
            document.getElementById('skill-select').disabled = false;
        });

        document.getElementById('skill-select').addEventListener('change', function() {
            var testId = document.getElementById('test-title-select').value;
            var skillId = this.value;
            var tableBody = document.getElementById('table-body');
            tableBody.innerHTML = ''; // Clear the table

            // Filter and display items based on the selected test and skill
            let index = 1; // Initialize the index
            @foreach ($item as $item)
                if ({{ $item->test_id }} == testId && {{ $item->skill_id }} == skillId) {
                    let optionsHtml = '';
                    @php
                        $options = explode(';', $item->option_title);
                    @endphp
                    @if ($options[0] != '')
                        optionsHtml +=
                            '<div class="options-wrapper" style="border: 1px solid #ddd; padding: 5px;">';
                        @foreach ($options as $option)
                            optionsHtml +=
                                '<div class="option-item" style="border-bottom: 1px solid #ddd; padding: 4px;">{{ $option }}</div>';
                        @endforeach
                        optionsHtml += '</div>';
                    @else
                        optionsHtml += '<div class="options-wrapper" style="border: none;"></div>';
                    @endif

                    // Log the optionsHtml for debugging
                    console.log(optionsHtml);

                    // Check if optionsHtml contains an <img> tag
                    let isImageTagPresent = optionsHtml.includes('&lt;img');
                    console.log(isImageTagPresent);

                    let imgTagStyle = isImageTagPresent ? 'width: 300px;' : '';


                    let row = `<tr>
                                    <th scope="row">${index}</th>
                                    <td>{!! $item->question_title !!}</td>
                                    <td>${isImageTagPresent ? applyWidthToImages('{!! $item->option_title !!}', imgTagStyle) : optionsHtml}</td>
                                    <td>{!! $item->correct_answer !!}</td>
                                    <td>{!! $item->is_active
                                        ? '<button class="btn btn-success btn-xs">Active</button>'
                                        : '<button class="btn btn-danger btn-xs">Inactive</button>' !!}</td>
                                    <td>{!! $item->group_id !!}</td>
                                    <td>
                                        <!-- Action buttons -->
                                        {{-- Implement action buttons here --}}
                                        <div class="d-flex">
                                            <a href="{{ url('questions/' . $item->id . '/edit') }}" class="btn btn-warning btn-xs mr-3" data-toggle="tooltip" title="Edit" style="display:inline;padding:2px 5px 3px 5px;">
                                                <i class="fa fa-edit"></i>
                                            </a>

                                                {!! Form::open([
                                                    'route' => ['questions.destroy', $item->id],
                                                    'method' => 'delete',
                                                    'style' => 'display:inline',
                                                    'onsubmit' => 'return confirm("Are you sure to delete this ?")',
                                                ]) !!}
                                                <button type="submit" class="btn btn-danger btn-xs text-white" data-toggle="tooltip"
                                                    title="Delete" style="display:inline;padding:2px 5px 3px 5px; margin-left: 5px;"><i class="fas fa-times"></i>
                                                </button>
                                                {!! Form::close() !!}
                                        </div>

                                    </td>
                                </tr>`;

                    // Function to apply width style to all images in the given HTML
                    function applyWidthToImages(html, style) {
                        const parser = new DOMParser();
                        const doc = parser.parseFromString(html, 'text/html');
                        const images = doc.querySelectorAll('img');

                        images.forEach((img) => {
                            img.style.cssText = style;
                        });

                        return doc.body.innerHTML;
                    }
                    tableBody.innerHTML += row;
                    index++; // Increment the index
                }
            @endforeach
        });
    </script>
@endsection
