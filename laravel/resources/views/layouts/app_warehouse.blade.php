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
    <link href="{{ url('sites/css/plugins/dataTables/datatables.css') }}" rel="stylesheet">
    <link href="{{ url('sites/css/plugins/dataTables/responsive.datatable.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ url('sites/js/multiselect/dist/filter_multi_select.css') }}" />
    <script src="{{ url('sites/js/multiselect/dist/filter-multi-select-bundle.min.js') }}"></script>
    <script src="{{ url('sites/js/mqtt.js') }}"></script>
    <script src="{{ url('sites/js/apex.js') }}"></script>
    <script src="{{ url('sites/js/jquery-3.1.1.min.js') }}"></script>
</head>

<body class="top-navigation" style="background-color: rgb(229, 225, 225)">
    <nav class="navbar navbar-dark navbar-expand-lg navbar-static-top" role="navigation" style="z-index: 999!important">
        <a href="{{ route('home') }}" class="navbar-brand bg-dark"><img src="{{ url('sites/img/renbo.png') }}"
                alt="" width="21px"></a>
        <div class="navbar-collapse collapse justify-content-center" id="navbar">
            <ul class="nav justify-content-center">       
            </ul>
        </div>
        <div class="">
            <ul class="nav navbar-top-links navbar-right">
                <li class="dropdown border">
                    <a aria-expanded="false" role="button" href="#" class="dropdown-toggle pl-3 pr-2"
                        data-toggle="dropdown"><i class="fa fa-envelope" aria-hidden="true"></i>
                    </a>
                    <ul role="menu" class="dropdown-menu">
                        <li><a href="{{ url('logout-action') }}"><i class="fa fa-sign-out"></i> Log out</a></li>
                        <li>
                            <form action="{{ url('edit.user.cp') }}" method="post">
                                @csrf
                                <input type="hidden" value="{{ session('Users.id') }}" name="id">
                                <button style="font-size: 14px" type="submit" class="btn btn-white border-0 py-2">
                                    &nbsp; <i class="fa fa-cog"></i> Change Password</button>
                            </form>
                        </li>
                        @if (session('Users.role_id') == 1)
                            <li><a href="{{ url('edit.user') }}"><i class="fa fa-sliders"></i> Edit User</a></li>
                            <li><a href="{{ url('edit.permission') }}"><i class="fa fa-sliders"></i> Edit
                                    Permisiion</a></li>
                        @elseif(session('Users.role_id') == 2)
                            <li><a href="{{ url('edit.user') }}"><i class="fa fa-sliders"></i> Edit User</a></li>
                        @endif

                    </ul>
                </li>
                <li class="dropdown border">
                    <a aria-expanded="false" role="button" href="#" class="dropdown-toggle pl-3 pr-2"
                        data-toggle="dropdown">
                        <i class="fa fa-bell" aria-hidden="true"></i>
                    </a>
                    <ul role="menu" class="dropdown-menu">
                        <li><a href="{{ url('logout-action') }}"><i class="fa fa-sign-out"></i> Log out</a></li>
                        <li>
                            <form action="{{ url('edit.user.cp') }}" method="post">
                                @csrf
                                <input type="hidden" value="{{ session('Users.id') }}" name="id">
                                <button style="font-size: 14px" type="submit" class="btn btn-white border-0 py-2">
                                    &nbsp; <i class="fa fa-cog"></i> Change Password</button>
                            </form>
                        </li>
                        @if (session('Users.role_id') == 1)
                            <li><a href="{{ url('edit.user') }}"><i class="fa fa-sliders"></i> Edit User</a></li>
                            <li><a href="{{ url('edit.permission') }}"><i class="fa fa-sliders"></i> Edit
                                    Permisiion</a></li>
                        @elseif(session('Users.role_id') == 2)
                            <li><a href="{{ url('edit.user') }}"><i class="fa fa-sliders"></i> Edit User</a></li>
                        @endif

                    </ul>
                </li>
                <li class="dropdown border">
                    <a aria-expanded="false" role="button" href="#" class="dropdown-toggle pl-3 pr-2"
                        data-toggle="dropdown"><i class="fa fa-user-circle-o "></i>
                    </a>
                    <ul role="menu" class="dropdown-menu">
                        <li><a href="{{ url('logout-action') }}"><i class="fa fa-sign-out"></i> Log out</a></li>
                        <li>
                            <form action="{{ url('edit.user.cp') }}" method="post">
                                @csrf
                                <input type="hidden" value="{{ session('Users.id') }}" name="id">
                                <button style="font-size: 14px" type="submit" class="btn btn-white border-0 py-2">
                                    &nbsp; <i class="fa fa-cog"></i> Change Password</button>
                            </form>
                        </li>
                        @if (session('Users.role_id') == 1)
                            <li><a href="{{ url('edit.user') }}"><i class="fa fa-sliders"></i> Edit User</a></li>
                            <li><a href="{{ url('edit.permission') }}"><i class="fa fa-sliders"></i> Edit
                                    Permisiion</a></li>
                        @elseif(session('Users.role_id') == 2)
                            <li><a href="{{ url('edit.user') }}"><i class="fa fa-sliders"></i> Edit User</a></li>
                        @endif

                    </ul>
                </li>
            </ul>
        </div>
    </nav>
    <div class="row bg-light" style="max-width:104%">
        <div class="col-12 col-md-3 col-lg-2 d-none d-md-block">
            RENBO ERP
        </div>
        <div class="col-12 col-md-9 col-lg-10 pt-2">
            <nav class="nav nav-tabs nav-stacked justify-content-end">
                <a class="nav-link  text-dark {{ Route::currentRouteName() == 'setup' ? 'active' : '' }}" href="{{route('setup')}}">Company Info</a>
                <a class="nav-link  text-dark {{ Route::currentRouteName() == 'setup-user' ? 'active' : '' }}" href="{{route('setup-user')}}">User Management</a>
                <a class="nav-link  text-dark {{ Route::currentRouteName() == 'setup-role' ? 'active' : '' }}" href="{{route('setup-role')}}">List Roles</a>
                <a class="nav-link  text-dark {{ Route::currentRouteName() == 'setup-route' ? 'active' : '' }}" href="{{route('setup-route')}}">List Routes</a>
                <a class="nav-link  text-dark {{ Route::currentRouteName() == 'setup-app' ? 'active' : '' }}" href="{{route('setup-app')}}">List Apps</a>
                <a class="nav-link  text-dark {{ Route::currentRouteName() == 'setup-route-permission' ? 'active' : '' }}" href="{{route('setup-route-permission')}}">Permission Route</a>
                <a class="nav-link  text-dark {{ Route::currentRouteName() == 'setup-app-permission' ? 'active' : '' }}" href="{{route('setup-app-permission')}}">Permission App</a>
            </nav>
        </div>
    </div>
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
    <script src="{{ url('sites/js/plugins/dataTables/datatables.js') }}"></script>
    <script src="{{ url('sites/js/plugins/dataTables/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ url('sites/js/plugins/dataTables/dataTable.responsive.js') }}"></script>

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
