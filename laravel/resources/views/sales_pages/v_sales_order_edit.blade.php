@extends('layouts.app_sales')
@section('content')
<style>
    .select2-container--default .select2-selection--single {
      background-color: rgba(0,0,0,0);
      border-radius: 0;
      padding-bottom: 5px;
    }
    .select2-container--default .select2-selection--single .select2-selection__rendered {
      color: #495057;
      padding-left: 20;
      padding-right: 0;
    }
    .bg-none{
        background-color: rgba(0,0,0,0);
    }
  </style>
  
    <div class="container-fluid">
        <div class="row pt-2">
            <div class="col-12 col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-12 mb-2">
                                <h2>Sales Order/ <u>{{$header->quotation_name}}</u> / <u>@if ($header->so_number == '') Draft @else {{$header->so_number}} @endif</u></h2> 
                            </div>
                            <div class="col-6">
                                <div class="text-left">
                                    @if ($header->so_status == 1)
                                        <button class="btn btn-success mb-3" onclick="setApprove(2)">Request Approval</button>
                                    @elseif($header->so_status == 2)
                                        @if($role==1)
                                        <button class="btn btn-primary mb-3" onclick="setApprove(3)">Approve Orders</button>
                                        <button class="btn btn-danger mb-3" onclick="setApprove(1)">Reject Orders</button>
                                        @endif
                                        <button class="btn btn-success mb-3" onclick="setApprove(1)">Edit Customer PO</button>
                                        @else
                                        <button type="button" class="btn btn-primary btn-lg mb-3" data-toggle="modal" data-target="#modelId"> 
                                            Create Invoice
                                        </button>
                                        <button class="btn btn-success mb-3" onclick="setApprove(1)">Edit Customer PO</button>
                                    
                                        @endif       
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="text-right">
                                    
                                    @if($header->so_status > 2)
                                    <a target="_blank" href="{{route('sales-order-export',$header->so_token)}}" class=" btn btn-warning mb-3">Print</a>&nbsp
                                    @endif
                                    <a  href="{{route('sales-order')}}" class=" btn btn-primary mb-3">Back</a>&nbsp
                                </div>
                            </div> 
                            <div class="col-12"><hr></div>
                            <div class="col-lg-6"></div>
                            <div class="col-12 col-sm-12 col-md-12 col-lg-6 border mb-1">
                                <div class="row">
                                    <div class="col-12 col-sm-12 col-md-12 col-lg-4 border text-center @if ($header->so_status == 1) bg-warning @endif">
                                        Draft
                                    </div>
                                    <div class="col-12 col-sm-12 col-md-12 col-lg-4 border text-center @if ($header->so_status == 2) bg-warning @endif">
                                        Wait Approval
                                    </div>
                                    <div class="col-12 col-sm-12 col-md-12 col-lg-4 border text-center @if ($header->so_status >= 3) bg-success @endif">
                                        SO Approved
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body pr-2">
                        <div class="row">
                           
                            <div class="col-12 col-md-12 col-lg-6"> 
                                <div class="form-group">
                                  <label for="">Customer PO</label>
                                  <input type="text"
                                    class="form-control" @if ($header->so_status > 1) disabled @endif name="" id="so_cust_po" onchange="updateCustPO()" aria-describedby="helpId" placeholder="" value="{{$header->so_po_customer}}">
                                  <small id="helpId" class="form-text text-muted">Help text</small>
                                </div>                               
                                <div class="form-group row">
                                    <label for="staticEmail" class="col-sm-2 col-form-label">Customer</label>
                                    <div class="col-sm-10" style="max-width: 100%">
                                        <select @if($header->quotation_status > 1) disabled @endif class="form-control border-top-1 select2_demo_1" onchange="updateHeaders()" id="h_cust_id" style="width: 100%">
                                            @foreach ($customer as $item)
                                                <option value="{{$item->customer_id}}" @if($item->customer_id == $header->customer_id) selected @endif>{{$item->customer_name}} ({{$item->customer_company}})</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                  <textarea class="form-control" name="" id="address" rows="3" readonly>{{$header->customer_address}}
                                  </textarea>
                                </div>
                            </div>
                            <div class="col-12 col-md-12 col-lg-6">
                                <div class="form-group row mb-1">
                                    <label for="staticEmail" class="col-3 col-form-label">Title</label>
                                    <div class="col-9">
                                      <input type="text" @if($header->quotation_status > 1) disabled @endif onchange="updateHeaders()" class="form-control" id="h_quotation_name" value="{{$header->quotation_name}}">
                                    </div>
                                </div>
                                <div class="form-group row mb-1">
                                    <label for="staticEmail" class="col-3 col-form-label">Date</label>
                                    <div class="col-9">
                                      <input type="date" @if($header->quotation_status > 1) disabled @endif onchange="updateHeaders()" class="form-control" id="h_quotation_date" value="{{ \Carbon\Carbon::parse($header->quotation_date)->format('Y-m-d') }}">
                                    </div>
                                </div>
                                <div class="form-group row mb-1">
                                    <label for="staticEmail" class="col-3 col-form-label">Expired</label>
                                    <div class="col-9">
                                      <input type="date" @if($header->quotation_status > 1) disabled @endif onchange="updateHeaders()" class="form-control" id="h_quotation_exp" value="{{ \Carbon\Carbon::parse($header->quotation_exp)->format('Y-m-d') }}">
                                    </div>
                                </div>
                                <div class="form-group row mb-1">
                                    <label for="staticEmail" class="col-3 col-form-label">Payment Terms</label>
                                    <div class="col-9">
                                        <select @if($header->quotation_status > 1) disabled @endif class="form-control border-top-1 select2_demo_1" onchange="updateHeaders()" id="h_top_id" style="width: 100%">
                                            @foreach ($tops as $item)
                                                <option value="{{$item->top_id}}" @if($item->top_id == $header->top_id) selected @endif>{{$item->top_desc}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row mb-1">
                                    <label for="staticEmail" class="col-3 col-form-label">Sales Person</label>
                                    <div class="col-9">
                                        <select @if($header->quotation_status > 1) disabled @endif class="form-control border-top-1 select2_demo_1" onchange="updateHeaders()" id="h_sales_id" style="width: 100%">
                                            @foreach ($sales as $is)
                                                <option value="{{$is->user_id}}" @if($is->user_id == $header->sales_id) selected @endif>{{$is->user_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <form class=""  id="myForm" action="{{route('sales-quotation-update')}}" method="POST" >
                            <div class="row">
                                <div class="col-12 mb-3">
                                    <button type="submit" id="save" class="d-none btn btn-primary add-section">Save Change</button>
                                </div>
                                <input type="hidden" name="quotation_id" value="{{$header->quotation_id}}">
                            </div>
                            @csrf
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered" id="table-main" style="width: 100%">
                                    <thead>
                                        <tr>
                                            <th style="min-width: 30px; width:30px"></th>
                                            <th style="min-width: 200px">Item</th>
                                            <th style="min-width: 200px">Desc</th>
                                            <th style="min-width: 60px; width: 60px">Qty</th>
                                            <th style="min-width: 70px; width: 70px">Unit</th>
                                            <th style="min-width: 200px" width="200">Unit Price</th>
                                            <th style="min-width: 200px">Total</th>
                                            <th style="min-width: 30px; width:30px"></th>
                                        </tr>
                                    </thead>
    
                                    <tbody id="sortable">
                                        @foreach ($sub as $sub)
                                            @if ($sub->line_type == 1)
                                            <tr id='row_{{$sub->quotation_order}}'>
                                                <td class='py-0' style='vertical-align:middle'><i class='fa fa-th'></i></td>
                                                <td colspan='6' class='py-0 px-0'>
                                                    <input type='hidden' name='product_id[]' value='0'>
                                                    <input @if($header->quotation_status > 1) readonly @endif type='text' placeholder='input section desc' onchange="openSave()" name='quotation_desc[]' value="{{$sub->quotation_desc}}" class='form-control border-none bg-none rounded-0' style='background-color: rgba(0,0,0,0)'>
                                                    <input type='hidden' name='quotation_qty[]' value='0'>
                                                    <input type='hidden' name='unit_id[]' value='1'>
                                                    <input type='hidden' name='quotation_price[]' value='0'>
                                                    <input type='hidden' name='quotation_total[]' value='0'>
                                                    <input type='hidden' name='line_type[]' value='1'>
                                                </td>
                                                <td class='py-0 px-0'><button type='button' class='btn bg-none' onclick='removeRow({{$sub->quotation_order}})'><i class='fa fa-trash'></i></button></td>
                                            </tr>
                                            @elseif($sub->line_type == 2)
                                            <tr id='row_{{$sub->quotation_order}}'>
                                                <td class='py-0' style='vertical-align:middle'><i class='fa fa-th'></i></td>
                                                <td class='py-0 px-0' style='vertical-align:middle'>
                                                    <select @if($header->quotation_status > 1) disabled @endif class='select2_demo_1 form-control border-none rounded-none pb-5' onchange="openSave()" name='product_id[]' style='width: 100%;'  required>
                                                       @foreach ($list_options as $item)
                                                           <option value="{{$item->product_id}}" @if($item->product_id == $sub->product_id) selected @endif>{{$item->product_name}}</option>
                                                       @endforeach
                                                    </select>
                                                </td>
                                                <td class='py-0 px-0'><input @if($header->quotation_status > 1) readonly @endif type='text' value="{{$sub->quotation_desc}}" placeholder='input product' name='quotation_desc[]' class='form-control border-none bg-none rounded-0' onchange="openSave()" required>
                                                    <input type='hidden' name='line_type[]' value='2'>
                                                </td>
                                                <td class='py-0 px-0'><input @if($header->quotation_status > 1) readonly @endif type='number' value="{{$sub->quotation_qty}}" id='qty{{$sub->quotation_order}}'  value='1' onchange='priceNumber({{$sub->quotation_order}})'  name='quotation_qty[]' class='form-control border-none bg-none rounded-0' required> </td>
                                                <td class='py-0 px-0' style='vertical-align:middle'>
                                                    <select @if($header->quotation_status > 1) disabled @endif class='select2_demo_1 form-control border-none rounded-none pb-5 text-center' name='unit_id[]' style='width: 100%;' required>
                                                        
                                                            @foreach ($list_options1 as $item1)
                                                                <option value="{{$item1->unit_id}}"  @if($sub->unit_id == $item1->unit_id) selected @endif>{{$item1->unit_desc}}</option>
                                                            @endforeach
                                                        
                                                    </select>
                                                </td>
                                                <td class='py-0 px-0'><input @if($header->quotation_status > 1) readonly @endif type='text' placeholder='0' value='{{ number_format($sub->quotation_price, 0, '.', ',') }}' id='price{{$sub->quotation_order}}' name='quotation_price[]' onchange='priceNumber({{$sub->quotation_order}})' class='text-right form-control border-none bg-none rounded-0 price-number' required> </td>
                                                <td class='py-0 px-0'><input  type='text' placeholder='0' value='{{ number_format($sub->quotation_total, 0, '.', ',') }}'  id='total{{$sub->quotation_order}}'  name='quotation_total[]' class='text-right form-control border-none bg-none rounded-0' readonly> </td>
                                                <td class='py-0 px-0'><button type='button' class='btn bg-none' onclick='removeRow({{$sub->quotation_order}})'><i class='fa fa-trash'></i></button></td>
                                            </tr>
                                            @else
                                            <tr id='row_{{$sub->quotation_order}}'>
                                                <td class='py-0' style='vertical-align:middle'><i class='fa fa-th'></i></td>
                                                <td colspan='6' class='py-0 px-0'>
                                                    <input type='hidden' name='product_id[]' value='0'>
                                                    <textarea @if($header->quotation_status > 1) readonly @endif type='text' placeholder='input section desc' onchange="openSave()" name='quotation_desc[]' value="" class='form-control border-none bg-none rounded-0' style='background-color: rgba(0,0,0,0)'>{{$sub->quotation_desc}}</textarea>
                                                    <input type='hidden' name='quotation_qty[]' value='0'>
                                                    <input type='hidden' name='unit_id[]' value='1'>
                                                    <input type='hidden' name='quotation_price[]' value='0'>
                                                    <input type='hidden' name='quotation_total[]' value='0'>
                                                    <input type='hidden' name='line_type[]' value='1'>
                                                </td>
                                                <td class='py-0 px-0'><button type='button' class='btn bg-none' onclick='removeRow({{$sub->quotation_order}})'><i class='fa fa-trash'></i></button></td>
                                            </tr>
                                            @endif
                                            
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            
                        </form>
                        <div class="row">
                            <div class="col-12 @if($header->quotation_status > 1) d-none @endif">
                                <button onclick="addSection()" class="btn btn-light add-section">Add Section</button>
                                <button onclick="addProduct()" class="btn btn-light add-product">Add Product</button>
                                <button onclick="addNote()" class="btn btn-light add-note">Add Note</button>
                            </div>
                            <div class="col-12 col-sm-12 col-md-6 col-lg-8 d-none d-md-block d-sm-none">
                                <div class="form-group">
                                  <textarea type="text" onchange="updateHeaders()" class="form-control" id="h_quotation_note" rows="3">{{$header->quotation_note}}</textarea>
                                </div>
                            </div>
                            <div class="col-12 col-sm-12 col-md-6 col-lg-4 pr-5">
                                <div class="form-group row mb-1">
                                    <label for="staticEmail" class="col-4 col-form-label">Total :</label>
                                    <div class="col-8">
                                    <input type="text" class="form-control text-right" id="ammount" readonly>
                                    </div>
                                </div>
                                <div class="form-group row mb-1">
                                    <label for="staticEmail" class="col-4 col-form-label">Disc (%):</label>
                                    <div class="col-8">
                                        <input type="number" @if($header->quotation_status > 1) disabled @endif onchange="updateHeaders()" class="form-control text-right" value="{{$header->quotation_disc}}" id="quotation_disc">
                                    </div>
                                </div>
                                <div class="form-group row mb-1">
                                    <label for="staticEmail" class="col-4 col-form-label">After Disc:</label>
                                    <div class="col-8">
                                        <input type="text" class="form-control text-right"  id="after_disc" readonly>
                                    </div>
                                </div>
                                <div class="form-group row mb-1">
                                    <label for="staticEmail" class="col-4 col-form-label">Tax (%):</label>
                                    <div class="col-8">
                                        <input type="number" @if($header->quotation_status > 1) disabled @endif onchange="updateHeaders()" class="form-control text-right" value="{{$header->quotation_tax}}" id="quotation_tax">
                                    </div>
                                </div>
                                <div class="form-group row mb-1">
                                    <label for="staticEmail"  class="col-4 col-form-label">Total Tax:</label>
                                    <div class="col-8">
                                        <input type="text" class="form-control text-right" id="total_tax" readonly>
                                    </div>
                                </div>
                                
                                <div class="form-group row mb-1">
                                    <label for="staticEmail" class="col-4 col-form-label">Total Quotation:</label>
                                    <div class="col-8">
                                    <input type="text" class="form-control text-right" id="ammount_total" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-12 col-md-6 col-lg-8 d-block d-md-none d-sm-block">
                                <div class="form-group">
                                  <label for="staticEmail" class=" col-form-label">Note :</label>
                                  <textarea type="text" onchange="updateHeaders()" class="form-control" id="h_quotation_note" rows="3">{{$header->quotation_note}}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modelId" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Create SO</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                </div>
                <form action="{{route('sales-invoice-post')}}" method="post">
                    <div class="modal-body">
                        @csrf
                        <div class="form-group">
                        <label for="">Input Invoice Tittle Rate</label>
                        <input type="text" name="invoice_tittle" id="" class="form-control" placeholder="" aria-describedby="helpId" required>
                        <small id="helpId" class="text-muted">example: payment #1 / payment rate 50%</small>
                        </div>
                        <div class="form-group">
                          <label for="">Invoice Rate</label>
                          <input type="number" step="any"
                            class="form-control" name="invoice_rate" max="{{ 100 - $header->invoice_created }}" id="" aria-describedby="helpId" placeholder="" required>
                          <small id="helpId" class="form-text text-muted">Help text</small>
                        </div>
                        <div class="form-group">
                        <label for="">Invoice Date</label>
                        <input type="date"
                            class="form-control" name="invoice_date" id="" aria-describedby="helpId" placeholder="" required>
                        
                        </div>
                        <div class="form-group">
                            <label for="">Invoice Due Date</label>
                            <input type="date"
                                class="form-control" name="invoice_exp" id="" aria-describedby="helpId" placeholder="" required>
                        </div>
                        <input type="hidden" name="quotation_id" value="{{$header->quotation_id}}">
                        <input type="hidden" name="so_id" value="{{$header->so_id}}">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                 </form>
            </div>
        </div>
    </div>
@endsection
@section('script')
  
    <script>
        var itot = document.getElementsByName('quotation_total[]');
        var disc = document.getElementById('quotation_disc').value;
        var tax= document.getElementById('quotation_tax').value;
        var iammount = 0
            for (let ii = 0; ii < itot.length; ii++) {
                var ia = removeCommas(itot[ii].value);
                iammount += parseFloat(ia);
            }
        iammount1 = String(iammount)
        var iamm = addCommas(iammount1);
        $("#ammount").val(iamm);
        var after_disc = iammount - (iammount*(parseFloat(disc)/100));
        var after_disc1 = String(after_disc.toFixed(0));
        var ad1 = addCommas(after_disc1);
        $("#after_disc").val(ad1);

        var h_t1 = after_disc*(parseFloat(tax)/100);
        var h_t2 = String(h_t1.toFixed(0));
        var h_t3 = addCommas(h_t2);
        $("#total_tax").val(h_t3);

        var h_a1 = after_disc + (after_disc*(parseFloat(tax)/100));
        var h_a2 = String(h_a1.toFixed(0));
        var h_a3 = addCommas(h_a2);
        $("#ammount_total").val(h_a3);
    
        

        $("#sortable").sortable();
        $(".select2_demo_1").select2();
        $(".select2_demo_2").select2();
        $(".select2_demo_3").select2();
        var sub = @json($sub_length);
        var rowIndex = 0+ parseInt(sub);
        function addSection() {
            rowIndex++;
            var markup = "<tr id='row_" + rowIndex + "'>" +
                            "<td class='py-0' style='vertical-align:middle'><i class='fa fa-th'></i></td>" +
                            "<td colspan='6' class='py-0 px-0'>"+
                                "<input type='hidden' name='product_id[]' value='0'>" +
                                "<input type='text' placeholder='input section desc' name='quotation_desc[]' class='form-control border-none bg-none rounded-0' style='background-color: rgba(0,0,0,0)'>" +
                                "<input type='hidden' name='quotation_qty[]' value='0'>" +
                                "<input type='hidden' name='unit_id[]' value='1'>" +
                                "<input type='hidden' name='quotation_price[]' value='0'>" +
                                "<input type='hidden' name='quotation_disc[]' value='0'>" +
                                "<input type='hidden' name='line_type[]' value='1'>"+
                            "</td>" +
                            "<td class='py-0 px-0'><button type='button' class='btn bg-none' onclick='removeRow(" + rowIndex + ")'><i class='fa fa-trash'></i></button></td>"+
                         "</tr>";
            tableBody = $("#table-main");
            tableBody.append(markup);
            $("#save").addClass("d-block");
            $("#save").removeClass("d-none");
        }
        function addProduct() {
            rowIndex++;
            var options = @json($list_options);
            var element = ''
            for (let i = 0; i < options.length; i++) {
                element += "<option value='"+options[i].product_id+"'>"+options[i].product_name+"</option>";
            }
            var options1 = @json($list_options1);
            var element1 = ''
            for (let i1 = 0; i1 < options1.length; i1++) {
                element1 += "<option class='px-5 text-center' value='"+options1[i1].unit_id+"'>"+options1[i1].unit_desc+"</option>";
            }
            var markup = "<tr id='row_" + rowIndex + "'>" +
                            "<td class='py-0' style='vertical-align:middle'><i class='fa fa-th'></i></td>" +
                            "<td class='py-0 px-0' style='vertical-align:middle'>"+
                            "<select onchange='openSave()' class='select2_demo_1 form-control border-none rounded-none pb-5' name='product_id[]' style='width: 100%;' required>"+element+"</select>"+
                            "</td>" +
                            "<td class='py-0 px-0'><input type='text' placeholder='input product' name='quotation_desc[]' class='form-control border-none bg-none rounded-0' required>"+
                                "<input type='hidden' name='line_type[]' value='2'>"+
                            "</td>" +
                            "<td class='py-0 px-0'><input type='number' id='qty"+rowIndex+"'  value='1' onchange='priceNumber("+rowIndex+")'  name='quotation_qty[]' class='form-control border-none bg-none rounded-0' required> </td>" +
                            "<td class='py-0 px-0' style='vertical-align:middle'>"+
                            "<select class='select2_demo_1 form-control border-none rounded-none pb-5 text-center' name='unit_id[]' style='width: 100%;' required>"+element1+"</select>"+
                            "</td>" +
                           "<td class='py-0 px-0'><input type='text' placeholder='0' value='0' id='price"+rowIndex+"' name='quotation_price[]' onchange='priceNumber("+rowIndex+")' class='text-right form-control border-none bg-none rounded-0 price-number' required> </td>" +
                            "<td class='py-0 px-0'><input type='text' placeholder='0' value='0'  id='total"+rowIndex+"'  name='quotation_total[]' class='text-right form-control border-none bg-none rounded-0' readonly> </td>" +
                            "<td class='py-0 px-0'><button type='button' class='btn bg-none' onclick='removeRow(" + rowIndex + ")'><i class='fa fa-trash'></i></button></td>"+
                         "</tr>";
            tableBody = $("#table-main");
            tableBody.append(markup);
            rowIndex++;
            $(".select2_demo_1").select2();
            $("#save").addClass("d-block");
            $("#save").removeClass("d-none");
        }
        function addNote() {
            rowIndex++;
            var markup = "<tr id='row_" + rowIndex + "'>" +
                            "<td class='py-0' style='vertical-align:middle'><i class='fa fa-th'></i></td>" +
                            "<td colspan='6' class='py-0 px-0'>"+
                                "<input type='hidden' name='product_id[]' value='0'>" +
                                "<textarea type='text' placeholder='input section desc' name='quotation_desc[]' class='form-control border-none bg-none rounded-0' style='background-color: rgba(0,0,0,0)' required>Input Note</textarea>" +
                                "<input type='hidden' name='quotation_qty[]' value='0'>" +
                                "<input type='hidden' name='unit_id[]' value='1'>" +
                                "<input type='hidden' name='quotation_price[]' value='0'>" +
                                "<input type='hidden' name='quotation_total[]' value='0'>" +
                                "<input type='hidden' name='line_type[]' value='3'>"+
                            "</td>" +
                            "<td class='py-0 px-0'><button type='button' class='btn bg-none' onclick='removeRow(" + rowIndex + ")'><i class='fa fa-trash'></i></button></td>"+
                         "</tr>";
            tableBody = $("#table-main");
            tableBody.append(markup);
            $("#save").addClass("d-block");
            $("#save").removeClass("d-none");
        }

        function priceNumber(id) {
            var data = document.getElementById('price'+id+'').value;
            var v = removeCommas(data);
            var after = addCommas(v);
            $("#price" + id).val(after);
            var qty= document.getElementById('qty'+id+'').value;
            var total = ((parseFloat(qty) * parseFloat(v))) ;
            var t_s = String(total.toFixed(0));
            var t_a = addCommas(t_s);
            
            
            $("#total" + id).val(t_a);
            $("#save").addClass("d-block");
            $("#save").removeClass("d-none");
            var itot = document.getElementsByName('quotation_total[]');
            var disc = document.getElementById('quotation_disc').value;
            var tax= document.getElementById('quotation_tax').value;
            var iammount = 0
                for (let ii = 0; ii < itot.length; ii++) {
                    var ia = removeCommas(itot[ii].value);
                    iammount += parseFloat(ia);
                }
            iammount1 = String(iammount)
            var iamm = addCommas(iammount1);
            $("#ammount").val(iamm);
            var after_disc = iammount - (iammount*(parseFloat(disc)/100));
            var after_disc1 = String(after_disc.toFixed(0));
            var ad1 = addCommas(after_disc1);
            $("#after_disc").val(ad1);

            var h_t1 = after_disc*(parseFloat(tax)/100);
            var h_t2 = String(h_t1.toFixed(0));
            var h_t3 = addCommas(h_t2);
            $("#total_tax").val(h_t3);

            var h_a1 = after_disc + (after_disc*(parseFloat(tax)/100));
            var h_a2 = String(h_a1.toFixed(0));
            var h_a3 = addCommas(h_a2);
            $("#ammount_total").val(h_a3);
        }

        function addCommas(num) {
            return num.replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        }

        function removeCommas(str) {
            let num1 = str.replace(/[^0-9.]/g, '');
            let periodCount = (num1.match(/\./g) || []).length;
            if (periodCount <= 1) {
                return num1.replace(/,/g, '');
            } else {
                return '0';
            }
        }
        function removeRow(index){
            $('#row_'+index+'').remove();
            $("#save").addClass("d-block");
            $("#save").removeClass("d-none");
        }
        function openSave(){
            $("#save").addClass("d-block");
            $("#save").removeClass("d-none");
        }
        function updateHeaders(){
            var cust_id = document.getElementById('h_cust_id').value;
            var top_id = document.getElementById('h_top_id').value;
            var q_name = document.getElementById('h_quotation_name').value;
            var q_date = document.getElementById('h_quotation_date').value;
            var q_exp = document.getElementById('h_quotation_exp').value;
            var q_note = document.getElementById('h_quotation_note').value;
            var q_disc = document.getElementById('quotation_disc').value;
            var q_tax = document.getElementById('quotation_tax').value;
            var itot = document.getElementsByName('quotation_total[]');
            var disc = document.getElementById('quotation_disc').value;
            var tax= document.getElementById('quotation_tax').value;
            var sales_id= document.getElementById('h_sales_id').value;
            var iammount = 0
                for (let ii = 0; ii < itot.length; ii++) {
                    var ia = removeCommas(itot[ii].value);
                    iammount += parseFloat(ia);
                }
            iammount1 = String(iammount)
            var iamm = addCommas(iammount1);
            $("#ammount").val(iamm);
            var after_disc = iammount - (iammount*(parseFloat(disc)/100));
            var after_disc1 = String(after_disc.toFixed(0));
            var ad1 = addCommas(after_disc1);
            $("#after_disc").val(ad1);

            var h_t1 = after_disc*(parseFloat(tax)/100);
            var h_t2 = String(h_t1.toFixed(0));
            var h_t3 = addCommas(h_t2);
            $("#total_tax").val(h_t3);

            var h_a1 = after_disc + (after_disc*(parseFloat(tax)/100));
            var h_a2 = String(h_a1.toFixed(0));
            var h_a3 = addCommas(h_a2);
            $("#ammount_total").val(h_a3);
          
            $.ajax({
                url: '{{route("sales-quotation-edit-head")}}',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    quotation_id: '{{$header->quotation_id}}',
                    customer_id: cust_id,
                    quotation_name: q_name,
                    quotation_date: q_date,
                    quotation_exp: q_exp,
                    quotation_tax: q_tax,
                    quotation_disc: q_disc,
                    quotation_note: q_note,
                    top_id: top_id,
                    sales_id: seles_id,
                },
                success: function(data) {
                    $("#address").val(data.customer_address);
                }
            })
        }
        function setApprove(status){
            
            $.ajax({
                url: '{{route("sales-order-update-status")}}',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    id: '{{$header->so_token}}',
                    status: status
                },
                success: function(data) {
                    console.log(data);
                    location.reload();
                }
            })
           
        }
        function updateCustPO(){
            var po = document.getElementById('so_cust_po').value;
            $.ajax({
                url: '{{route("sales-order-edit-header")}}',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    id: '{{$header->so_token}}',
                    status: po
                },
                success: function(data) {
                    console.log(data);
                    location.reload();
                }
            })
           
        }
        
    </script>
@endsection
