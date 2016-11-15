@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    <h1>Welcome {{ $user->name }}</h1>
                    @if($user->isAdmin())
                        @include('dashboard.admin')
                    @else
                        @include('dashboard.client')
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
