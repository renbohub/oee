@extends('layouts.app_accounting')
@section('content')
    <div class="container-fluid">
        <div class="row pt-2">
            <div class="col-12 col-sm-12 col-md-6 col-lg-3 mb-3">
                <div class="card">
                    <div class="card-header">
                        Total Assets
                    </div>
                    <div class="card-body">
                        <div id="q-price" style="font-size: 20px">
                            Rp. 0,-
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-12 col-md-6 col-lg-3 mb-3">
                <div class="card">
                    <div class="card-header">
                        Account Payables
                    </div>
                    <div class="card-body">
                        <div id="s-price" style="font-size: 20px">
                            Rp. 0,-
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-12 col-md-6 col-lg-3 mb-3">
                <div class="card">
                    <div class="card-header">
                        Total Invoices
                    </div>
                    <div class="card-body">
                        <div id="i-price" style="font-size: 20px">
                            Rp. 0,-
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-12 col-md-6 col-lg-3 mb-3">
                <div class="card">
                    <div class="card-header">
                       Account Receivables
                    </div>
                    <div class="card-body">
                        <div id="q-price" style="font-size: 20px">
                            Rp. 0,-
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        Invoices Chart
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 text-right">
                                <button type="button" class="btn btn-primary">
                                    Yearly
                                </button>
                                <button type="button" class="btn btn-info">
                                    Monthly
                                </button>
                                <button type="button" class="btn btn-success">
                                    Daily
                                </button>                            
                            </div>
                            <div class="col-12">
                                <div id="mixedChart" style="height: 200px"></div>
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
        var options = {
            series: [{
                name: 'Quotations',
                data: []
            }, {
                name: 'Sales Orders',
                data: []
            }, {
                name: 'Invoices',
                data: []
            }],
            chart: {
                type: 'bar',
                height: 350,
                events: {
                    click: function(event, chartContext, config) {
                        var a = chartContext.w.config.series;
                        var b = config.dataPointIndex;
                        var c = a[0].data[b].x
                        $.ajax({
                            url: '{{ route('sales-data') }}',
                            type: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}',
                                data: c
                            },
                            success: function(respone) {
                                mixedChart.updateSeries([{
                                    name: 'Quotations',
                                    data: respone.data.quotation
                                }, {
                                    name: 'Sales Orders',
                                    data: respone.data.sales_order
                                }, {
                                    name: 'Invoices',
                                    data: respone.data.invoice
                                }])

                                var q_price = 0
                                for (let i = 0; i < respone.data.quotation.length; i++) {
                                    q_price += parseFloat(respone.data.quotation[i].y).toFixed(2);

                                }
                                q_p = String(q_price.toFixed(0)).replace(/\B(?=(\d{3})+(?!\d))/g, ',')

                                var i_price = 0
                                for (let i = 0; i < respone.data.invoice.length; i++) {
                                    i_price += parseFloat(respone.data.invoice[i].y).toFixed(2);

                                }
                                i_p = String(i_price.toFixed(0)).replace(/\B(?=(\d{3})+(?!\d))/g, ',')

                                var s_price = 0
                                for (let i = 0; i < respone.data.sales_order.length; i++) {
                                    s_price += parseFloat(respone.data.sales_order[i].y).toFixed(2);

                                }
                                s_p = String(s_price.toFixed(0)).replace(/\B(?=(\d{3})+(?!\d))/g, ',')


                                $('#q-price').text('Rp. ' + q_p);
                                $('#i-price').text('Rp. ' + i_p);
                                $('#s-price').text('Rp. ' + s_p);
                            }
                        })
                    }
                }
            },
            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: '90%',
                    endingShape: 'rounded'
                },
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                show: true,
                width: 2,
                colors: ['transparent']
            },
            yaxis: {
                title: {
                    text: 'IDR (Rupiah)'
                }
            },
            xaxis: {
                type: ''
            },
            fill: {
                opacity: 1
            },
            tooltip: {
                y: {
                    formatter: function(val) {
                        return "Rp. " + String(val.toFixed(0)).replace(/\B(?=(\d{3})+(?!\d))/g, ',') + ""
                    }
                }
            }
        };
        var mixedChart = new ApexCharts(document.querySelector("#mixedChart"), options);
        mixedChart.render();
    </script>
@endsection
