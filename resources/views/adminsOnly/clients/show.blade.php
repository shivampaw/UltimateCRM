@extends('layouts.app')

@section('page_title', $client->full_name)

@section('content')
    
    <div class="row text-xs-center">
		<div class="col-md-3 col_row">
			<h5>Client Details</h5>
			<p class="text-success">{{ $client->full_name }}</p>
			<p class="text-warning">{{ $client->email }}</p>
			<p class="text-info">{{ $client->number }}</p>
		</div>
		<div class="col-md-3 col_row">
			<h5>Client Address</h5>
			<p class="text-info">
				{!! nl2br($client->address) !!}
			</p>
		</div>
		<div class="col-md-3 col_row">
			<h5>Invoices</h5>
			<p class="text-success">Paid Invoices: {{ $client->invoices()->where('paid', true)->count() }}</p>
			<p class="text-warning">Unpaid Invoices: {{ $client->invoices()->where('paid', false)->count() }}</p>
			<a href="/clients/{{ $client->id }}/invoices" title="View Client Invoices">View Invoices</a>
		</div>
		<div class="col-md-3 col_row">
			<h5>Projects</h5>
			<p class="text-success">Agreed Projects: {{ $client->projects()->where('accepted', true)->count() }}</p>
			<p class="text-warning">Total Projects: {{ $client->projects()->count() }}</p>
			<a href="/clients/{{ $client->id }}/projects" title="View Client Projects">View Projects</a>
		</div>
    </div>
	<div class="text-xs-center">
	    <form action="/clients/{{ $client->id }}" method="post">
			{{ csrf_field() }}
			<input type="hidden" name="_method" value="delete">
			<button onclick="return confirm('Are you sure you want to delete {{ $client->full_name }}')" class="btn btn-link float-md-left"><span class="fa fa-trash"></span> Delete Client</button>
	    </form>
	    <a href="/clients/{{ $client->id }}/edit" class="btn btn-link float-md-right" title="Edit Client"><span class="fa fa-pencil"></span> Edit Client</a>
    </div>
@endsection
