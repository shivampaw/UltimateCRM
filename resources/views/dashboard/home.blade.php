@extends('layouts.app')

@section('page_title', 'Home')

@section('content')
    <h1>Welcome {{ $user->name }}</h1>
    @if($user->isAdmin())
        @include('layouts.dashboard.admin')
    @else
        @include('layouts.dashboard.client')
    @endif
    @if($user->isSuperAdmin())
        <p>You are a super admin (ID = 1)</p>
    @else
        <p>You are not a super admin (ID != 1)</p>
    @endif

    @if($user->isAdmin())
        <p>You are a normal admin</p>
    @else
        <p>You are not an admin either.</p>
    @endif
@endsection
