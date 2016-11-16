@extends('layouts.app')

@section('page_title', 'Clients')

@section('content')
	@foreach($clients as $client)
		<div class="client">
			<a href="/clients/{{ $client->id }}/">{{ $client->full_name }}</a><br />
		</div>
	@endforeach
@endsection
