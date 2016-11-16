@extends('layouts.app')

@section('page_title', $client->full_name)

@section('content')
    {{ $client }}
    <form action="/clients/{{ $client->id }}" method="post">
		{{ csrf_field() }}
		<input type="hidden" name="_method" value="delete">
		<button>Delete Client</button>
    </form>
@endsection
