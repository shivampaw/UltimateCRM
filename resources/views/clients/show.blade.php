@extends('layouts.app')

@section('page_title', $client->full_name)

@section('content')
    
    <p>
		<strong>Email: </strong>
		{{ $client->email }}
	</p>
	
	<p>
		<strong>Number: </strong>
		{{ $client->number }}
	</p>
	
	<p>
		<strong>Address: </strong>
		{{ $client->address }}
	</p>
	
	<p>
		<strong>Unpaid Invoices: </strong>
		{{ $client->invoices()->where('paid', false)->count() }}
	</p>

	<p>
		<strong>Paid Invoices: </strong>
		{{ $client->invoices()->where('paid', true)->count() }}
	</p>


    <form action="/clients/{{ $client->id }}" class="float-sm-left" method="post">
		{{ csrf_field() }}
		<input type="hidden" name="_method" value="delete">
		<button class="btn btn-danger btn-block">Delete Client</button>
    </form>
	<p class="float-sm-right">
		<a href="/clients/{{ $client->id }}/invoices" title="View Client Invoices" class="btn btn-info btn-block">View Invoices</a>
	</p>
@endsection
