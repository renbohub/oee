<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Production Dashboard</title>
    <link href="{{ url('sites/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ url('sites/css/bootstrap-multiselect.css') }}" rel="stylesheet">
    <link href="{{ url('sites/font-awesome/css/font-awesome.css') }}" rel="stylesheet">
    <link href="{{ url('sites/css/animate.css') }}" rel="stylesheet">
    <link href="{{ url('sites/css/style.css') }}" rel="stylesheet">
    <link href="{{ url('sites/css/plugins/select2/select2.min.css') }}" rel="stylesheet">
    <link href="{{ url('sites/css/plugins/dataTables/datatables.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ url('sites/js/multiselect/dist/filter_multi_select.css') }}" />
    <script src="{{ url('sites/js/multiselect/dist/filter-multi-select-bundle.min.js') }}"></script>
    <script src="{{ url('sites/js/mqtt.js') }}"></script>
    <script src="{{ url('sites/js/apex.js') }}"></script>
    <script src="{{ url('sites/js/jquery-3.1.1.min.js') }}"></script>
</head>
<body class="top-navigation" style="background-color: rgb(229, 225, 225)">
    
    <div class="">
        @yield('content')
    </div>
    <script src="{{ url('sites/js/popper.min.js') }}"></script>
    <script src="{{ url('sites/js/bootstrap.js') }}"></script>

    <script src="{{ url('sites/js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
    <script src="{{ url('sites/js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>

    <!-- Custom and plugin javascript -->
    <script src="{{ url('sites/js/inspinia.js') }}"></script>
    <script src="{{ url('sites/js/plugins/pace/pace.min.js') }}"></script>

    <!-- Flot -->
    <script src="{{ url('sites/js/plugins/flot/jquery.flot.js') }}"></script>
    <script src="{{ url('sites/js/plugins/flot/jquery.flot.tooltip.min.js') }}"></script>
    <script src="{{ url('sites/js/plugins/flot/jquery.flot.resize.js') }}"></script>
    <script src="{{ url('sites/js/plugins/dataTables/datatables.min.js') }}"></script>
    <script src="{{ url('sites/js/plugins/dataTables/dataTables.bootstrap4.min.js') }}"></script>

    <!-- ChartJS-->


    <!-- Peity -->
    <script src="{{ url('sites/js/plugins/peity/jquery.peity.min.js') }}"></script>
    <!-- Peity demo -->
    <script src="{{ url('sites/js/demo/peity-demo.js') }}"></script>
    <script src="{{ url('sites/js/bootstrap-multiselect.js') }}"></script>
    <script src="{{ url('sites/js/plugins/select2/select2.full.min.js') }}"></script>
    <script src="{{ url('sites/js/easy-number-separator.js') }}"></script>
    @yield('script')
</body>
</html>
