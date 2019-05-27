@extends('layouts.app')

@section('page_title', 'Project: '.$project->title)

@section('content')

    @include("layouts.projects.show")

    <hr/>

    <div class="text-center">
        <a href="/projects" class="btn btn-info float-left">
            <span class="fa fa-angle-double-left"></span>
            Back to Projects
        </a>
        @if(!$project->accepted)
            <a href="/projects/{{ $project->id }}/accept" class="btn btn-success float-right">Accept Project</a>
        @else
            <button class="btn btn-success float-md-right">
                Project Accepted on {{ $project->accepted_at->toFormattedDateString() }}
            </button>
        @endif
    </div>

@endsection
