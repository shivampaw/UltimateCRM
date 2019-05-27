<li class="nav-item"><a href="{{ url('/') }}" class="nav-link">Home</a></li>

@if (Auth::user() && (Auth::user()->isSuperAdmin()))
    <li class="nav-item"><a href="{{ url('/admins') }}" class="nav-link">Admins</a></li>
@endif
@if (Auth::user() && (Auth::user()->isAdmin()))
    <li class="nav-item"><a href="{{ url('/clients') }}" class="nav-link">Clients</a></li>
@elseif (Auth::user() && (!Auth::user()->isAdmin()))
    <li class="nav-item"><a href="{{ url('/invoices') }}" class="nav-link">Invoices</a></li>
    <li class="nav-item"><a href="{{ url('/projects') }}" class="nav-link">Projects</a></li>
@endif

