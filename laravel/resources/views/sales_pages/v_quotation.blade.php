@extends('layouts.app_sales')
@section('content')
    <div class="container-fluid">
        <div class="row pt-2">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-8 pt-2">
                                <h4><i class="fa fa-list" aria-hidden="true"></i> List Quotation</h4>
                            </div>
                            <div class="col-4 text-right"><!-- Button trigger modal -->
                                <button type="button" class="btn btn-primary btn-lg" data-toggle="modal"
                                    data-target="#modelId">
                                    New
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped table-bordered" id="table-main">
                            <thead>
                                <tr>
                                    <th>Quot Number</th>
                                    <th>Quot Title</th>
                                    <th>Customer Name</th>
                                    <th>Quot Status</th>
                                    <th>Quot Created</th>
                                    <th>Quot Expired</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>

                    <!-- Modal -->
                    <div class="modal fade bd-example-modal-xl" id="modelId" tabindex="-1" role="dialog"
                        aria-labelledby="modelTitleId" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Create New Quotation</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form action="{{route('sales-quotation-create')}}" method="post">
                                    <div class="modal-body">
                                        @csrf
                                        <div class="form-group">
                                            <label for="">Quotation Title</label>
                                            <input type="text" class="form-control" name="quotation_name" id=""
                                                aria-describedby="helpId" placeholder="input quotation title" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="">Quotation Date</label>
                                            <input type="date" class="form-control" name="quotation_date" id=""
                                                aria-describedby="helpId" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="">Quotation Expired</label>
                                            <input type="date" class="form-control" name="quotation_exp" id=""
                                                aria-describedby="helpId" required>
                                        </div>
                                        <div class="form-group">
                                          <label for="">Select Customer</label>
                                          <select class="form-control" name="customer_id" id="" required>
                                            @foreach ($customer as $item)
                                                <option value="{{$item->customer_id}}">{{$item->customer_name}} ({{$item->customer_company}})</option>
                                            @endforeach
                                          </select>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Create</button>
                                    </div>
                                </form>
                            </div>
                        </div>
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
            ajax: {
                "url": "{{ route('sales-quotation-data') }}",
                "type": "GET",
            },
            columns: [{
                    "data": "quotation_number"
                }, {
                    "data": "quotation_name"
                },
                {
                    "data": null,
                    "render": function(data, type, row) {
                        return ''+ row.customer_name+' ('+row.customer_company+')'
                    }
                },
                {
                    "data": null,
                    "render": function(data, type, row) {
                        if(row.quotation_status==1){
                            return '<a href="#" class="btn btn-danger active" role="button">Drafted</a>'
                        }else if(row.quotation_status==2){
                            return '<a href="#" class="btn btn-warning active" role="button">Wait Approval</a>'
                        }else if(row.quotation_status==3){
                            return '<a href="#" class="btn btn-success active" role="button">Quotation Approved</a>'
                        }else if(row.quotation_status==4){
                            return '<a href="#" class="btn btn-info active" role="button">Quotation Sended</a>'
                        }else{
                            return '<a href="#" class="btn btn-primary active" role="button">Quotation Ordered</a>'
                        }
                    }
                },
                {
                    "data": null,
                    "render": function(data, type, row) {
                        return row.quotation_date.split('T')[0]
                    }
                },
                {
                    "data": null,
                    "render": function(data, type, row) {
                        return row.quotation_exp.split('T')[0]
                    }
                }, {
                    "data": null,
                    "render": function(data, type, row) {
                        return '<div class="btn-group" role="group" aria-label=""><a href="{{ url('sales/quotation/edit') }}/' +
                            row.quotation_token +
                            '"><button type="button" class="btn btn-warning "> <i class="text-dark fa fa-pencil" aria-hidden="true"></i></button></a><a href="{{ url('sales/quotation/delete') }}/' +
                            row.quotation_token +
                            '"><button type="button" class="btn btn-danger text-dark"><i class="text-dark fa fa-trash" aria-hidden="true"></i></button></a></div>';
                    }
                }
            ],
            processing: true,
            serverSide: true
        });
    </script>
@endsection
