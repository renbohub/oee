@extends('layouts.menu')
@section('content')
    <style>
        .login-form {
            padding-top: 20vh;
            align-items: center;
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            max-width: 600px;
            margin: auto;
            padding-left: 10px;
            padding-right: 10px;
        }

        .card-body:hover {
            background-color: rgb(5, 77, 77)
        }
    </style>
    <div class="container">
        <div class="login-form">
            <div class="row px-4">
                @foreach ($menu as $menu)
                    <div class="col-4 col-lg-3 col-sm-4 mb-2 mx-0 px-1">
                        <a class="text-dark" href="{{route(''.$menu->app_name.'')}}">
                            <div class="card border-none" style="background-color: rgb(85, 138, 124)">
                                <div class="card-body text-center">
                                    <img src="data:image/jpeg;base64,{{ $menu->app_logo }}" width="60%" alt="App Logo"
                                        class="img-fluid" />
                                </div>
                            </div>
                            <h5 class="text-center">
                                {{ $menu->app_name }}
                            </h5>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
@section('script')
@endsection
