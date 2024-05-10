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
                        <table id="datatable" class="table table-bordered dt-responsive nowrap"
                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Birth Date</th>
                                    <th>Phone</th>
                                    <th>Identity No</th>
                                    <th>Candidate ID</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($items as $item)
                                    <tr>
                                        <td>{{ $item->id }}</td>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->email }}</td>
                                        <td>{{ $item->birth_date }}</td>
                                        <td>{{ $item->phone }}</td>
                                        <td>{{ $item->identity_no }}</td>
                                        <td>{{ $item->candidate_id }}</td>
                                        <td> <input data-id="{{ $item->id }}" class="toggle-class" type="checkbox"
                                                data-onstyle="success" onclick="clickAlert()" data-offstyle="danger"
                                                data-toggle="toggle" data-on="Active" data-off="Inactive"
                                                {{ $item->status ? 'checked' : '' }}></td>

                                        {{-- <td>{!! $item->status == 1 ? '<a class="btn btn-danger">Inactive</a>' : '<a class="btn btn-success">Active</a>' !!}</td> --}}
                                    </tr>
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

    <script>
        $(document).ready(function() {

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
                    var status = $(this).prop('checked') == true ? 1 : 0;
                    var id = $(this).data('id');
                    alert("Are you sure you want to update status?");
                    $.ajax({
                        type: "POST",
                        dataType: "json",
                        url: "{{ route('candidatestatus_update') }}",
                        data: {
                            'status': status,
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
@endsection

