@extends('layouts.app')

@section('page_title', 'Home')

@section('content')
    <h1>Welcome {{ $user->name }}</h1>
    @if($user->isAdmin())
        @include('layouts.dashboard.admin')
    @else
        @include('layouts.dashboard.client')
    @endif
@endsection
