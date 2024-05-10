@extends('student.layouts.master')
@section('content')
    <div id="layoutSidenav_content">
        <main>
            <div style="padding-top: 100px"></div>
                <div class="row">
                    <div class="col-12">
                        <div class="container d-flex justify-content-center mt-4 mb-3">
                            <div class="card p-3 mt-3" style="width:40%">
                                <h5 class="mt-3 mb-3">Test score</h5>

                                @forelse ($data as $item)
                                    <div class="border p-2 rounded d-flex flex-row align-items-center mt-2">
                                        <div class="p-1 px-4 d-flex flex-column align-items-center score rounded">876;lkjhcx
                                            <h4 class="text-success">{{ $item->title }}</h4>
                                        </div>
                                        <div class="ml-5 p-3">
                                            <h6 class="text-primary">{{ $item->skill_title }}</h6>
                                            <h5>Score: {{ number_format($item->score, 0) }}</h5>
                                        </div>
                                    </div>
                                @empty
                                    <div class="card p-3 mt-3">
                                        <h5 class="mt-3 mb-3">No results found</h5>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                        {{-- <div class="card">
                        <div class="card-body">
                            <h2>Your Test Score</h2>
                            <div class="table-responsive">
                                <table id="datatable" class="table table-bordered dt-responsive nowrap"
                                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th class="th-sm">SL</th>
                                            <th class="th-sm">Exam Title</th>
                                            <th class="th-sm">Skill Title</th>
                                            <th class="th-sm">Score</th>
                                            <th class="th-sm">Total</th>
                                            <!-- <th class="th-sm">Action</th> -->
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data as $item)
                                            <tr>
                                                <th scope="row">{{ $loop->iteration }}</th>
                                                <td>{{ $item->title }}</td>
                                                <td>{{ $item->skill_title }}</td>
                                                <td>{{ number_format($item->score, 0) }}</td>
                                                <td>40</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div> --}}
                    </div>
                </div>
        </main>
    </div>
@endsection
