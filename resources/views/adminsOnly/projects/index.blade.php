@extends('layouts.app')

@section('page_title', 'All Projects for '.$client->name)

@section('content')

<p>
	<a href="/clients/{{ $client->id }}/projects/create" class="btn btn-success btn-block"><span class="fa fa-plus"></span> Create Project</a>
</p>

@include("layouts.projects.index")

<p>
	<a href="/clients/{{ $client->id }}" class="btn btn-info"><span class="fa fa-angle-double-left"></span> Back to Client</a>
</p>

@endsection