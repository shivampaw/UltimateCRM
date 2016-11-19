@extends('layouts.app')

@section('page_title', 'Add Admin')

@section('content')
    <form action="/admins" method="post">
        <div class="form-group">
            <label for="name" class="sr-only">Full Name</label>
            <input type="text" class="form-control" name="name" id="name" placeholder="Full Name" value="{{ old('name') }}">
        </div>
        <div class="form-group">
            <label for="email" class="sr-only">Email</label>
            <input type="email" class="form-control" name="email" id="email" placeholder="Email" value="{{ old('email') }}">
        </div>
        <div class="form-group">
            {{ csrf_field() }}
            <button class="btn btn-primary btn-block">Add Admin</button>
        </div>
    </form>
@endsection
