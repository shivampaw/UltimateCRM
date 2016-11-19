@extends('layouts.app')

@section('page_title', $client->full_name)

@section('content')
    
    <div class="row text-xs-center">
		<div class="col-md-6">
			<div class="card">
				<div class="card-block">
					<h4 class="card-title">Client Details</h4>
					<p class="card-text">
						<div class="text-success">{{ $client->full_name }}</div>
						<div class="text-warning">{{ $client->email }}</div>
						<div class="text-info">{{ $client->number }}</div>
					</p>
				</div>
			</div>
		</div>

		<div class="col-md-6">
			<div class="card">
				<div class="card-block">
					<h4 class="card-title">Client Address</h4>
					<p class="card-text">
						<p class="text-info">
							{!! nl2br($client->address) !!}
						</p>
					</p>
				</div>
			</div>
		</div>

		<div class="col-md-6">
			<div class="card">
				<div class="card-block">
					<h4 class="card-title">Invoices</h4>
					<p class="card-text">
						<div class="text-success">Paid Invoices: {{ $client->invoices()->where('paid', true)->count() }}</div>
						<div class="text-warning">Unpaid Invoices: {{ $client->invoices()->where('paid', false)->count() }}</div>
						<div class="text-info"><a href="/clients/{{ $client->id }}/invoices" title="View Client Invoices">View Invoices</a></div>
					</p>
				</div>
			</div>
		</div>

		<div class="col-md-6">
			<div class="card">
				<div class="card-block">
					<h4 class="card-title">Projects</h4>
					<p class="card-text">
						<div class="text-success">Agreed Projects: {{ $client->projects()->where('accepted', true)->count() }}</div>
						<div class="text-warning">Total Projects: {{ $client->projects()->count() }}</div>
						<div class="text-info"><a href="/clients/{{ $client->id }}/projects" title="View Client Projects">View Projects</a></div>
					</p>
				</div>
			</div>
		</div>

    </div>
	
	<hr />

	<div class="text-xs-center">
	    <form action="/clients/{{ $client->id }}" method="post">
			{{ csrf_field() }}
			<input type="hidden" name="_method" value="delete">
			<button onclick="return confirm('Are you sure you want to delete {{ $client->full_name }}')" class="btn btn-danger float-md-left"><span class="fa fa-trash"></span> Delete Client</button>
	    </form>
	    <a href="/clients/{{ $client->id }}/edit" class="btn btn-info float-md-right" title="Edit Client"><span class="fa fa-pencil"></span> Edit Client</a>
    </div>
@endsection
