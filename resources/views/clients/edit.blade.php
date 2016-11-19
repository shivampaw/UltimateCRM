@extends('layouts.app')

@section('page_title', 'Edit '.$client->full_name)

@section('content') 

<form action="/clients/{{ $client->id }}" method="post">
	<input type="hidden" name="_method" value="PUT">
	<div class="form-group">
		<label for="full_name" class="sr-only">Full Name</label>
		<input type="text" class="form-control" name="full_name" value="{{ $client->full_name }}" id="full_name" placeholder="Full Name">
	</div>
	<div class="form-group">
		<label for="email" class="sr-only">Email</label>
		<input type="email" class="form-control" name="email" value="{{ $client->email }}" id="email" placeholder="Email">
	</div>
	<div class="form-group">
		<label for="number" class="sr-only">Contact Number</label>
		<input type="number" class="form-control" name="number" value="{{ $client->number }}" id="number" placeholder="Contact Number">
	</div>
	<div class="form-group">
		<label for="address" class="sr-only">Address</label>
		<textarea class="form-control" name="address" id="address" placeholder="Address" rows="5">{{ $client->address }}</textarea>
	</div>
	<div class="form-group">
		{{ csrf_field() }}
		<button class="btn btn-primary btn-block">Update Client</button>
	</div>
</form>

<p>
	<a href="/clients/{{ $client->id }}" class="btn btn-info"><span class="fa fa-angle-double-left"></span> Back to Client</a>
</p>

@endsection