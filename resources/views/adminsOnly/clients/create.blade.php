@extends('layouts.app')

@section('page_title', 'Add Client')

@section('content')
    <form action="/clients" method="post">
        <div class="form-group">
            <label for="name" class="sr-only">Full Name</label>
            <input type="text" class="form-control" name="name" id="name" placeholder="Full Name" value="{{ old('name') }}">
        </div>
        <div class="form-group">
            <label for="email" class="sr-only">Email</label>
            <input type="email" class="form-control" name="email" id="email" placeholder="Email" value="{{ old('email') }}">
        </div>
        <div class="form-group">
            <label for="number" class="sr-only">Contact Number</label>
            <input type="text" class="form-control" name="number" id="number" placeholder="Contact Number" value="{{ old('number') }}">
        </div>
        <div class="form-group">
            <label for="address" class="sr-only">Address</label>
            <textarea class="form-control" name="address" id="address" placeholder="Address" rows="5">{{ old('address') }}</textarea>
        </div>
        <div class="form-group">
            {{ csrf_field() }}
            <button class="btn btn-primary btn-block">Add Client</button>
        </div>
    </form>
@endsection
