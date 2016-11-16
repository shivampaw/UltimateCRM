@extends('layouts.app')

@section('page_title', 'Home')

@section('content')
    <h1>Welcome {{ $user->name }}</h1>
    @if($user->isAdmin())
        @include('dashboard.admin')
    @else
        @include('dashboard.client')
    @endif
@endsection
