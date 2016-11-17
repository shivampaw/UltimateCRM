<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>CRM - @yield('page_title')</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700">

    <!-- Styles -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.5/css/bootstrap.min.css" integrity="sha384-AysaV+vQoT3kOAXZkl02PThvDr8HYKPZhNT5h/CXfBThSRXQ6jW5DO2ekP5ViFdi" crossorigin="anonymous">
    <link rel="stylesheet" href="/css/app.css">
</head>
<body id="app-layout">
    <nav class="navbar navbar-light bg-faded navbar-static-top">
        <div class="container">
            <button type="button" class="navbar-toggler hidden-md-up float-xs-right" data-toggle="collapse" data-target="#nav-content" aria-expanded="false"></button>
            <a class="navbar-brand" href="{{ url('/') }}">CRM</a>

            <div id="nav-content" class="collapse navbar-toggleable-sm">
                <!-- Left Side Of Navbar -->
                <ul class="nav navbar-nav">
                    <li class="nav-item"><a href="{{ url('/') }}" class="nav-link">Home</a>
                    @if ( (!Auth::guest()) && (Auth::user()->isAdmin()) )
                        <li class="nav-item"><a href="{{ url('/clients') }}" class="nav-link">Clients</a>
                    @elseif ( (!Auth::guest()) && (Auth::user()) )
                        <li class="nav-item"><a href="{{ url('/me') }}" class="nav-link">Me</a>
                    @endif
                    </li>
                </ul>
                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav float-md-right">
                    <!-- Authentication Links -->
                    @if (Auth::guest())
                    <li class="nav-item"><a href="{{ url('/login') }}" class="nav-link">Login</a>
                    </li>
                    @else
                    <li class="dropdown nav-item"> <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown" role="button"
                        aria-expanded="false">

                                        {{ Auth::user()->name }} <span class="caret"></span>

                                    </a>
                        <ul class="dropdown-menu" role="menu">
                            <li class="dropdown-item"><a href="{{ url('/update-password') }}"><i class="fa fa-btn fa-cog"></i>Update Password</a>
                            </li>
                            <li class="dropdown-item"><a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i>Logout</a>
                            </li>
                        </ul>
                    </li>@endif
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="row">
            <div class="col-lg-10 offset-lg-1 col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h5>@yield('page_title')</h5>
                    </div>
                    <div class="card-block">
                        @if (session('status'))
                            <div class="alert alert-{{ session('status_level') }}">
                                {{ session('status') }}
                            </div>
                        @endif

                        @if (count($errors) > 0)
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        @yield('content')
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.3/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.3.7/js/tether.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.5/js/bootstrap.min.js" integrity="sha384-BLiI7JTZm+JWlgKa0M0kGRpJbF2J8q+qreVrKBC47e3K6BW78kGLrCkeRX6I9RoK" crossorigin="anonymous"></script>
    <script src="/js/app.js"></script>

    @yield('footer')
</body>
</html>
