@extends('layouts.app')

@section('page_title', 'All Invoices for '.$client->full_name)

@section('content')

<p>
	<a href="/clients/{{ $client->id }}/invoices/create" class="btn btn-success btn-block">Create Invoice</a>
</p>

@include("layouts.invoicesIndex")

@endsection