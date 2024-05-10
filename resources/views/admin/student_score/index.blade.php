@extends('layouts.master.admin')
@section('css')
    <!-- datatables css -->
    <link href="{{ URL::asset('assets/libs/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
@endsection
@section('content')
<div id="layoutSidenav_content">
    <main>
        <div class="">
            <div class="">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h2> Your Test Score</h2>
                                <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th class="th-sm">SL</th>
                                            <th class="th-sm">Student Name</th>
                                            <th class="th-sm">Student Email</th>
                                            <th class="th-sm">Exam Title</th>
                                            <th class="th-sm">Skill Title</th>
                                            <th class="th-sm">Score</th>
                                            <th class="th-sm">Total</th>
                                            <th class="th-sm">Action</th>
                                            <!-- <th class="th-sm">Action</th> -->
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data as $item)
                                        <tr>
                                            <th scope="row">{{ $loop->iteration }}</th>
                                            <td>{{ $item->student_name }}</td>
                                            <td>{{ $item->student_email }}</td>
                                            <td>{{ $item->title }}</td>
                                            <td>{{ $item->skill_title }}</td>
                                            <td>{{ number_format($item->score, 0) }}</td>
                                            <td>40</td>
                                            <td>
                                                {!! Form::open([
                                                'route' => ["delete_test_score.delete_test_score_delete",$item->user_id],
                                                'method' => 'delete',
                                                'style' => 'display:inline',
                                                ]) !!}
                                                <button class="btn btn-danger btn-xs text-white" data-toggle="tooltip" title="Delete" style="display:inline;padding:2px 5px 3px 5px;" onclick="return confirm('Are you sure to delete this ?')"><i class="fas fa-times"></i>
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
@section('scripts')
    <script src="{{ URL::asset('assets/libs/datatables/datatables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/js/pages/datatables.init.js') }}"></script>
    <script src="{{ URL::asset('assets/libs/jquery-ui/jquery-ui.min.js') }}"></script>
    <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
@endsection

