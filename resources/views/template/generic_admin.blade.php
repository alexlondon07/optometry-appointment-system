<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Citas</title>

    <link href="{{ asset('/css/app.css') }}" rel="stylesheet">

    <!-- Fonts -->
    <link href='//fonts.googleapis.com/css?family=Roboto:400,300' rel='stylesheet' type='text/css'>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    @yield('head_content')
</head>
<body>
    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="{{ url('/') }}/admin/main">Sistema de citas - Laravel 5.1</a>
            </div>

            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    @if (Auth::user())
                    <li><a href="{{URL::to('/')}}/admin/user" title="Usuarios">Usuarios</a></li>
                    <li><a href="{{URL::to('/')}}/admin/course" title="Cursos">Cursos</a></li>
                    <li><a href="{{URL::to('/')}}/admin/student" title="Estudiantes">Estudiantes</a></li>
                    @endif
                </ul>

                <ul class="nav navbar-nav navbar-right">
                    @if (Auth::guest())
                        <li><a href="{{ url('/auth/login') }}">Login</a></li>
                        <li><a href="{{ url('/auth/register') }}">Register</a></li>
                    @else
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">{{ Auth::user()->name }} <span class="caret"></span></a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="{{ url('/auth/logout') }}">Logout</a></li>
                            </ul>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>
        <div id="body_wrapper">
            @yield('body_content')
        </div>
    <!-- Scripts -->
    <!-- Scripts -->
        <!-- Bootstrap core JavaScript
        ================================================== -->
        <!-- Placed at the end of the document so the pages load faster -->
        <script type="text/javascript" src="{!! URL::to('js/jquery/jquery-1.11.3.min.js') !!}"></script>
        <script type="text/javascript" src="{!! URL::to('js/bootstrap/bootstrap.min.js') !!}"></script>
        <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
        <script type="text/javascript" src="{!! URL::to('/') !!}/js/jquery/ie10-viewport-bug-workaround.js"></script>

        <!-- js de bootstrap 3 datepicker-->
        <script type="text/javascript" src="{!! URL::to('/') !!}/js/bootstrap/datepicker/js/bootstrap-datepicker.js"></script>
        <script type="text/javascript">var rootUrl = "{!! URL::to('/') !!}/";</script>
        <script type="text/javascript" src="{!! URL::to('/') !!}/js/Util.js"></script>
    @yield('javascript_content')
</body>
</html>
