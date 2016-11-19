@extends('layouts.app')

@section('page_title', 'Project: '.$project->title)

@section('content')

<p><strong>Project ID: {{ $project->id }}</strong></p>

@include("layouts.projects.show")

<form action="/clients/{{ $project->client->id }}/projects/{{ $project->id }}" method="post">
	<input type="hidden" name="_method" value="delete">
	{{ csrf_field() }}
	<button onclick="return confirm('Are you are you want to delete this project? It will delete all invoices related to this project as well.')" class="btn btn-danger"><span class="fa fa-trash"></span> Delete Project</button>
</form>
@endsection