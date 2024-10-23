@extends('layouts.guest')
@section('content')
    <style>
        .login-form {
            padding-top: 20vh;
            max-width: 380px;
            align-items: center;
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            margin: auto;
            padding-left: 10px;
            padding-right: 10px;
        }
    </style>
    <div class="container">
        <div class="login-form">
            <div class="card rounded-4">
                <div class="card-body ">
                    <div class="text-center mb-4">
                        <img src="{{ url('sites/img/renbo-1.png') }}" alt="" width="60%">
                    </div>

                    @if ($errors->any())
                        <div class="alert alert-danger text-danger" role="alert">
                            <h5 class="alert-heading">{{$errors}}</h5>
                        </div>
                    @else
                        <div class="alert alert-success text-center" role="alert">
                            <h5 class="alert-heading">Lets Monitoring Your Production With Porting</h5>
                        </div>
                    @endif
                    <hr>
                    <form action="{{ route('login-post') }}" method="POST">
                        @csrf
                        <div class="input-group mb-4">
                            <span class="input-group-addon" id="prefixId" style="width: 40px"><i class="fa fa-envelope"
                                    aria-hidden="true"></i></span>
                            <input type="email" name="username" id="username" class="form-control" placeholder="email"
                                aria-describedby="prefixId" required>
                        </div>
                        <div class="input-group mb-4">
                            <span class="input-group-addon" id="prefixId" style="width: 40px"><i class="fa fa-lock"
                                    aria-hidden="true"></i></span>
                            <input type="password" name="password" id="password" class="form-control"
                                placeholder="password" aria-describedby="prefixId" required>
                        </div>
                        <center>
                            <button type="submit" class="btn btn-primary my-2 py-2" style="width: 100%">Sign In</button>
                        </center>
                        <hr>
                    </form>
                    <div class="row">
                        <div class="col-6"></div>
                        <div class="col-6">
                            <div class="text-right">
                                <a href="" class="text-dark"><u>Reset Password</u></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
@endsection
