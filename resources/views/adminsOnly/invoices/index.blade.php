@extends('layouts.app')

@section('page_title', 'All Invoices for '.$client->name)

@section('content')

<p>
	<a href="/clients/{{ $client->id }}/invoices/create" class="btn btn-success btn-block"><span class="fa fa-plus"></span> Create Invoice</a>
</p>

@include("layouts.invoices.index")

<hr />

<p>
	<a href="/clients/{{ $client->id }}" class="btn btn-info"><span class="fa fa-angle-double-left"></span> Back to Client</a>
</p>

@endsection