@extends('layouts.app')

@section('page_title', 'Clients')

@section('content')
	<p>
		<a href="/clients/create" class="btn btn-success btn-block" title="Create New Client"><span class="fa fa-plus"></span> Create Client</a>
	</p>
	<div class="row">
		@foreach($clients as $client)
			<div class="col-lg-4 col-sm-6">
				<div class="card text-xs-center">
					<div class="card-block">
						<h4 class="card-title">{{ $client->name }}</h4>
						<p class="card-text">
							<div class="text-success">Paid Invoices: {{ $client->invoices()->where('paid', true)->count() }}</div>
							<div class="text-danger">Unpaid Invoices: {{ $client->invoices()->where('paid', false)->count() }}</div>
							<div class="text-info">Total Projects: {{ $client->projects()->count() }}</div>
						</p>
						<a href="/clients/{{ $client->id}}/" title="{{ $client->name }}" class="btn btn-primary">View Client</a>
					</div>
				</div>
			</div>
		@endforeach
	</div>
@endsection
