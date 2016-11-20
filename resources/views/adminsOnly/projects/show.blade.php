@extends('layouts.app')

@section('page_title', 'Project: '.$project->title)

@section('content')

@include("layouts.projects.show")

<hr />


<div class="row">
    @if(!$project->accepted)
        <div class="col-xs-12 text-sm-right text-xs-center">
            <form action="/clients/{{ $project->client->id }}/projects/{{ $project->id }}" method="post">
                {{ csrf_field() }}
                <input type="hidden" name="_method" value="delete">
                <button onclick="return confirm('Are you are you want to delete this project? It will delete all invoices related to this project as well.')" class="btn btn-danger"><span class="fa fa-trash"></span> Delete Project</button>
            </form>
        </div>
    @else
        <div class="col-xs-12 text-sm-right text-xs-center">
            <button class="btn btn-success">Project Accepted on {{ $project->accepted_at->toFormattedDateString() }}</button>
        </div>
    @endif
</div>

@endsection