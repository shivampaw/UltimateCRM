@extends('layouts.app')

@section('page_title', 'Clients')

@section('content')
	<p>
		<a href="/clients/create" class="btn btn-success btn-block" title="Create New Client">Create Client</a>
	</p>
	<div class="card-columns">
		@foreach($clients as $client)
			<div class="card client text-xs-center">
				<div class="card-block">
					<h4 class="card-title">{{ $client->full_name }}</h4>
					<p class="card-text">
						<div class="text-success">Paid Invoices: {{ $client->invoices()->where('paid', true)->count() }}</div>
						<div class="text-danger">Unpaid Invoices: {{ $client->invoices()->where('paid', false)->count() }}</div>
					</p>
					<a href="/clients/{{ $client->id}}/" title="{{ $client->name }}" class="btn btn-primary">View Client</a>
				</div>
			</div>
		@endforeach
	</div>
@endsection
