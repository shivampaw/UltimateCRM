<nav class="navbar navbar-light bg-faded navbar-static-top navbar-expand-md">
    <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#nav-content"
            aria-expanded="false">
        <span class="navbar-toggler-icon"></span>
    </button>
    <a class="navbar-brand" href="{{ url('/') }}">{{ config('crm.site_title') }}</a>
    <div id="nav-content" class="collapse navbar-collapse">
        <ul class="navbar-nav mr-auto mt-2 mt-md-0">
            @include("layouts.navbar.left")
        </ul>
        <ul class="navbar-nav my-2 my-md-0">
            @include("layouts.navbar.right")
        </ul>
    </div>
</nav>
