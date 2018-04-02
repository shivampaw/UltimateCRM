@extends('layouts.app')

@section('page_title', 'Project: '.$project->title)

@section('content')

    @include("layouts.projects.show")

    <hr/>

    <div class="text-center">
        <a href="/clients/{{ $client->id }}/projects" class="btn btn-info float-md-left"><span
                    class="fa fa-angle-double-left"></span> Back to Client Projects</a>
        <form action="/clients/{{ $client->id }}/projects/{{ $project->id }}" method="post">
            {{ csrf_field() }}
            <input type="hidden" name="_method" value="delete">
            <button onclick="return confirm('Are you are you want to delete this project? It will delete all invoices related to this project as well.')"
                    class="btn btn-danger float-md-right"><span class="fa fa-trash"></span> Delete Project</button>
        </form>
    </div>

@endsection