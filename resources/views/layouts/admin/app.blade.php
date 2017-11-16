<!DOCTYPE html>
<html>

    <head>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>Laravel | @yield('title')</title>

        <link href="/css/bootstrap.min.css" rel="stylesheet">
        <link href="/font-awesome/css/font-awesome.css" rel="stylesheet">

        <!-- Data Tables -->
        <link href="/css/plugins/dataTables/dataTables.bootstrap.css" rel="stylesheet">
        <link href="/css/plugins/dataTables/dataTables.responsive.css" rel="stylesheet">
        <link href="/css/plugins/dataTables/dataTables.tableTools.min.css" rel="stylesheet">

        <!-- Morris -->
        <link href="/css/plugins/morris/morris-0.4.3.min.css" rel="stylesheet">

        <!-- Gritter -->
        <link href="/js/plugins/gritter/jquery.gritter.css" rel="stylesheet">

        <link href="/css/animate.css" rel="stylesheet">
        <link href="/css/style.css" rel="stylesheet">
        <!-- App styles -->
        @stack('styles')
    </head>

    <body>
        <div id="wrapper">
            <nav class="navbar-default navbar-static-side" role="navigation">
                <div class="sidebar-collapse">
                    @include('/admin/inc/menu')
                </div>
            </nav>

            <div id="page-wrapper" class="gray-bg">
                <div class="row border-bottom">
                    <nav class="navbar navbar-static-top white-bg" role="navigation" style="margin-bottom: 0">
                        <div class="navbar-header">
                            <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>
                            <!--                                                    <form role="search" class="navbar-form-custom" method="post" action="search_results.html">
                                                                                    <div class="form-group">
                                                                                        <input type="text" placeholder="Search for something..." class="form-control" name="top-search" id="top-search">
                                                                                    </div>
                                                                                </form>-->
                        </div>
                        <ul class="nav navbar-top-links navbar-right">
                            <li>
                                <span class="m-r-sm text-muted welcome-message">Welcome to JSM Admin Panel.</span>
                            </li>
                            <li>
                                <a href="{{ url('/logout') }}" onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();">
                                    <i class="fa fa-sign-out"></i> Log out
                                </a>
                                <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                            </li>
                        </ul>

                    </nav>
                </div>
                <div class="row wrapper border-bottom white-bg page-heading" id='tahir'>
                    <div class="col-sm-4">

                        <h2>@yield('title')</h2>
                        {!! Breadcrumbs::renderIfExists() !!}
                    </div>
                </div>
                <div class="wrapper wrapper-content animated fadeIn">

                    @yield('content')

                </div>

                <div class="footer">
                    <div class="pull-right">
                        Powered by <strong>Laravel {{App::version()}}</strong>
                    </div>
                    <div>
                        <strong>Copyright</strong> Laravel &copy; 2016
                    </div>
                </div>
            </div>
        </div>

        @include('/admin/inc/footer_scripts')
        @stack('scripts')
    </body>
</html>
