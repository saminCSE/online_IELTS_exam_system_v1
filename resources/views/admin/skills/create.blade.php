@extends('layouts.master.admin')
@section('css')
<!-- datatables css -->
<!-- <link href="{{ URL::asset('assets/libs/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css"/> -->
<link href="{{ URL::asset('assets/libs/select2/select2.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::asset('assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.css') }}" rel="stylesheet" type="text/css" />
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
    <h2>Create Skills</h2>
</div>
<div class="card">
    <div class="card-body">
        @if (isset($item))
        {!! Form::model($item, [
        'route' => ['skills.update', $item->id],
        'method' => 'PUT',
        'class' => 'custom-validation',
        'files' => true,
        'role' => 'form',
        'id' => 'edit-form',
        ]) !!}
        @else
        {!! Form::open([
        'route' => ['skills.store'],
        'method' => 'POST',
        'class' => 'custom-validation',
        'files' => true,
        'role' => 'form',
        'id' => 'add-form',
        ]) !!}
        @endif

        <form class="custom-validation" action="#">

        <div class="row">
                    <div class="col-md-2 text-right">
                        {!! Form::label('type_id', 'Exam Type') !!}
                    </div>
                    <div class="col-lg-5">
                        <div class="form-group">
                            {!! Form::select('type_id', $type, isset($item->type) ? $item->type : NULL, [
                                'class' => 'form-control',
                            ]) !!}

                            {!! $errors->first('type_id', '<p class="help-block text-danger">:message</p>') !!}
                        </div>
                    </div>
            </div>

            <div class="row">
                <div class="col-md-2 text-right">
                    {!! Form::label('title', 'Title') !!}
                </div>
                <div class="col-lg-5">
                    <div class="form-group">
                        {!! Form::text('title', isset($item->title) ? $item->title : null, ['class' => 'form-control']) !!}

                        {!! $errors->first('title', '<p class="help-block text-danger">:message</p>') !!}
                    </div>
                </div>
            </div>
                <div class="row">
                    <div class="col-md-5 text-right">
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
</div> <!-- end col -->
@endsection

@section('scripts')
<!-- Plugins js -->
<!-- <script src="{{ URL::asset('assets/libs/datatables/datatables.min.js') }}"></script>
        <script src="{{ URL::asset('assets/js/pages/datatables.init.js') }}"></script>
        <script src="{{ URL::asset('assets/libs/jquery-ui/jquery-ui.min.js') }}"></script> -->
<script src="{{ URL::asset('assets/libs/select2/select2.min.js') }}"></script>
<script src="{{ URL::asset('assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
@endsection