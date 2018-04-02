<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('crm.site_title') }} - @yield('page_title')</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">

    <!-- Styles -->
    <link rel="stylesheet" href="/css/app.css">
</head>
<body id="app-layout">

    <nav class="navbar navbar-light bg-faded navbar-static-top navbar-toggleable-sm">
        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#nav-content" aria-expanded="false">
            <span class="navbar-toggler-icon"></span>
        </button>
        <a class="navbar-brand" href="{{ url('/') }}">{{ config('crm.site_title') }}</a>
        <div id="nav-content" class="collapse navbar-collapse">
            <ul class="navbar-nav mr-auto mt-2 mt-md-0">
                <li class="nav-item"><a href="{{ url('/') }}" class="nav-link">Home</a></li>
                
                @if ( Auth::user() && (Auth::user()->isSuperAdmin()) )
                    <li class="nav-item"><a href="{{ url('/admins') }}" class="nav-link">Admins</a></li>
                @endif
                @if ( Auth::user() && (Auth::user()->isAdmin()) )
                    <li class="nav-item"><a href="{{ url('/clients') }}" class="nav-link">Clients</a></li>
                @elseif ( Auth::user() && (!Auth::user()->isAdmin()) )
                    <li class="nav-item"><a href="{{ url('/invoices') }}" class="nav-link">Invoices</a></li>
                    <li class="nav-item"><a href="{{ url('/projects') }}" class="nav-link">Projects</a></li>
                @endif
            </ul>
            <ul class="navbar-nav my-2 my-md-0">
                @if ( Auth::guest() )
                    <li class="nav-item"><a href="{{ url('/login') }}" class="nav-link">Login</a></li>
                @else
                    <li class="dropdown nav-item">
                        <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown" role="button"aria-expanded="false">
                            {{ Auth::user()->name }} <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu" role="menu">
                            <li class="dropdown-item"><a href="{{ url('/update-password') }}"><i class="fa fa-btn fa-cog"></i>Update Password</a></li>
                            <li class="dropdown-item">
                                <a href="{{ url('/logout') }}" data-method="post" data-token="{{ csrf_token() }}"><i class="fa fa-btn fa-sign-out"></i> Logout</a>
                            </li>
                        </ul>
                    </li>
                @endif
            </ul>
        </div>
    </nav>

    <div class="container">
        <div class="row">
            <div class="col-lg-10 offset-lg-1 col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h3>@yield('page_title')</h3>
                    </div>
                    <div class="card-block">
                        @if (session('status'))
                            <div class="alert alert-{{ session('status_level') ?: "success" }}">
                                <div>{{ session('status') }}</div>
                            </div>
                        @endif

                        @if (count($errors) > 0)
                            <div class="alert alert-danger">
                                    @foreach ($errors->all() as $error)
                                        <div>{{ $error }}</div>
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
    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
    </script>
    <script src="/js/manifest.js"></script>
    <script src="/js/vendor.js"></script>
    <script src="/js/app.js"></script>

    @yield('footer')
</body>
</html>
