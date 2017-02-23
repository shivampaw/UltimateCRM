@extends('layouts.app')

@section('page_title', 'Edit '.$admin->name)

@section('content') 

<form action="/admins/{{ $admin->id }}" method="post">
	<input type="hidden" name="_method" value="PUT">
	<div class="form-group">
		<label for="name" class="sr-only">Full Name</label>
		<input type="text" class="form-control" name="name" value="{{ $admin->name }}" id="name" placeholder="Full Name">
	</div>
	<div class="form-group">
		<label for="email" class="sr-only">Email</label>
		<input type="email" class="form-control" name="email" value="{{ $admin->email }}" id="email" placeholder="Email">
	</div>
	<div class="form-group">
		{{ csrf_field() }}
		<button class="btn btn-primary btn-block">Update Admin</button>
	</div>
</form>

<hr />

<p>
	<a href="/admins" class="btn btn-info"><span class="fa fa-angle-double-left"></span> Back to Admins</a>
</p>

@endsection