@if (Auth::guest())
    <li class="nav-item"><a href="{{ url('/login') }}" class="nav-link">Login</a></li>
@else
    <li class="dropdown nav-item">
        <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown" role="button"
           aria-expanded="false">
            {{ Auth::user()->name }} <span class="caret"></span>
        </a>
        <ul class="dropdown-menu" role="menu">
            <li class="dropdown-item"><a href="{{ url('/update-password') }}"><i
                            class="fa fa-btn fa-cog"></i>Update Password</a></li>
            <li class="dropdown-item">
                <a href="{{ url('/logout') }}" data-method="post" data-token="{{ csrf_token() }}"><i
                            class="fa fa-btn fa-sign-out"></i> Logout</a>
            </li>
        </ul>
    </li>
@endif

