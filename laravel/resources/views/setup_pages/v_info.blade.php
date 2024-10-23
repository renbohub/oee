@extends('layouts.app_setup')
@section('content')
@endsection
@section('script')
    <div class="container-fluid">
        <div class="row pt-2">
            
            <div class="col-12 col-sm-12 col-md-6 col-lg-8 mb-3">
                <div class="card">
                    <div class="card-header">
                       <div class="row">
                         <div class="col-8 pt-2">
                            <i class="fa fa-cube" aria-hidden="true"></i> <b>Company Information</b>
                         </div>
                         <div class="col-4 text-right">
                            <a name="" id="" class="btn btn-primary" href="{{route('company-edit')}}" role="button"> <i class="fa fa-pencil" aria-hidden="true"></i> Edit</a>
                         </div>
                       </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group mb-4 text-center">
                                    <label for="">Client Main Logo</label>
                                    <div class="form-group border pt-3">
                                        <img src="data:image/jpeg;base64,{{ $client->client_main_logo }}"
                                            style="height: 60px" alt="App Logo" class="img-fluid form-group" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group mb-4 text-center">
                                    <label for="">Client Small Logo</label>
                                    <div class="form-group border pt-3">
                                        <img src="data:image/jpeg;base64,{{ $client->client_small_logo }}"
                                            style="height: 60px" alt="App Logo" class="img-fluid form-group" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group mb-4">
                                    <label for="">ID Company</label>
                                    <input type="text" name="" id="" class="form-control"
                                        placeholder="{{ $client->client_name }}" aria-describedby="helpId" disabled>
                                </div>
                                <div class="form-group mb-4">
                                    <label for="">Company Name</label>
                                    <input type="text" name="" id="" class="form-control"
                                        placeholder="{{ $client->client_company }}" aria-describedby="helpId" disabled>
                                </div>
                                <div class="form-group">
                                    <label for="">Address</label>
                                    <textarea class="form-control" name="" id="" rows="3" disabled>{{ $client->client_address }}</textarea>
                                </div>
                                <div class="form-group mb-4">
                                    <label for="">Client Email</label>
                                    <input type="text" name="" id="" class="form-control"
                                        placeholder="{{ $client->client_email }}" aria-describedby="helpId" disabled>
                                </div>
                                <div class="form-group mb-4">
                                    <label for="">Client Allias</label>
                                    <input type="text" name="" id="" class="form-control"
                                        placeholder="{{ $client->client_allias }}" aria-describedby="helpId" disabled>
                                </div>
                            </div>
                        </div>
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
