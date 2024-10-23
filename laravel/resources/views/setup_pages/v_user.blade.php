@extends('layouts.app_setup')
@section('content')
    <div class="container-fluid">
        <div class="row pt-2">
            <div class="col-12 col-sm-12 col-md-6 col-lg-8 mb-3">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-8 pt-2">
                                <i class="fa fa-list-ul " aria-hidden="true"></i> <b> List User</b>
                            </div>
                            <div class="col-4 text-right">
                                <a name="" id="" class="btn btn-primary" href="{{ route('company-edit') }}"
                                    role="button"><i class="fa fa-plus" aria-hidden="true"></i> Add User</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table display table-striped" id="table-main" style="width:100%">
                            <thead>
                                <tr>
                                    @foreach ($thead as $th)
                                        <td>{{ $th['value'] }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($tbody as $row)
                                    <tr>
                                        @foreach ($row as $cell)
                                            <td>{!! $cell['value'] !!}</td>
                                        @endforeach
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-12 col-md-6 col-lg-4 px-lg-1 px-3 ">
                <div class="card">
                    <div class="card-header">
                        Log Activity
                    </div>
                    <div class="card-body">
                        <h4 class="card-title">Title</h4>
                        <p class="card-text">Text</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $('#table-main').DataTable({
            responsive: true,
        });
    </script>
@endsection
