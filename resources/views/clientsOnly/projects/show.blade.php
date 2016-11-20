@extends('layouts.app')

@section('page_title', 'Project: '.$project->title)

@section('content')

@include("layouts.projects.show")

@endsection