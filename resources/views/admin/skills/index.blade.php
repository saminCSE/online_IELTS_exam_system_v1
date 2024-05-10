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
    <h2>Skills List</h2>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th class="th-sm">SL</th>
                                <th class="th-sm">Exam Type</th>
                                <th class="th-sm">Skill Title</th>
                                <!-- <th class="th-sm">Action</th> -->
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($skills as $skill)
                            <tr>
                                <th scope="row">{{ $loop->iteration }}</th>
                                <td>{{ $skill->type_title }}</td>
                                <td>{{ $skill->title }}</td>
                                <!-- <td>
                                    <a href="{{ url('skills/' . $skill->id . '/edit') }}" class="btn btn-warning btn-xs mr-3" data-toggle="tooltip" title="Edit" style="display:inline;padding:2px 5px 3px 5px;">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                        </td> -->
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
@endsection
@section('scripts')
<script src="{{ URL::asset('assets/libs/datatables/datatables.min.js') }}"></script>
<script src="{{ URL::asset('assets/js/pages/datatables.init.js') }}"></script>
<script src="{{ URL::asset('assets/libs/jquery-ui/jquery-ui.min.js') }}"></script>
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
@endsection