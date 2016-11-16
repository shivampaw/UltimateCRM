@extends('layouts.app')

@section('page_title', $client->full_name)

@section('content')
    {{ $client }}
@endsection
