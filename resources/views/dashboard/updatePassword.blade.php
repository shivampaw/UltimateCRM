@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Update Password</div>

                <div class="panel-body">
                    <p>Enter your current password and then your new password to update your password</p>
                    @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    @if (Session::has('success'))
                       <div class="alert alert-info">{{ Session::get('success') }}</div>
                    @endif
                    <form action="/update-password" method="post">
						<div class="form-group">
							<label for="currentPassword" class="sr-only">Current Password</label>
							<input type="password" name="currentPassword" id="currentPassword" placeholder="Current Password" class="form-control">
						</div>
                        <div class="form-group">
                            <label for="password" class="sr-only">New Password</label>
                            <input type="password" name="password" id="password" placeholder="New Password" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="confirmPassword" class="sr-only">Confirm Password</label>
                            <input type="password" name="confirmPassword" id="confirmPassword" placeholder="Confirm Password" class="form-control">
                        </div>
						<div class="form-group">
							<input type="hidden" name="_method" value="put">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <button class="btn btn-primary btn-block">Update Password</button>
						</div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
