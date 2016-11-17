@extends('layouts.app')

@section('page_title', 'Reset Password')

@section('content')
    <form role="form" method="POST" action="{{ url('/password/email') }}">
        {{ csrf_field() }}

        <div class="form-group">
            <input id="email" type="email" class="form-control" name="email" placeholder="E-Mail Address" value="{{ old('email') }}">
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-block btn-primary">
                <i class="fa fa-btn fa-envelope"></i> Send Password Reset Link
            </button>
        </div>
    </form>
@endsection
