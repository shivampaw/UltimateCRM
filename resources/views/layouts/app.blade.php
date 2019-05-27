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
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans|Lato:400|Lato:700">

    <!-- Styles -->
    <link rel="stylesheet" href="/css/app.css">
</head>
<body id="app-layout">

@include("layouts.navbar.navbar")

<div class="container">
    <div class="row">
        <div class="col-lg-10 offset-lg-1 col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h3>@yield('page_title')</h3>
                </div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-{{ session('status_level') ?: "success" }}">
                            <p>{{ session('status') }}</p>
                        </div>
                    @endif
                    @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            @foreach($errors->all() as $error)
                                <p>
                                    {{ $error }}
                                </p>
                            @endforeach
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
