@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Clients</div>

                <div class="panel-body">
                	@if (Session::has('success'))
                       <div class="alert alert-success">{{ Session::get('success') }}</div>
                    @endif
                	<div class="row">
						@foreach($clients as $client)
							<div class="client">
								Name:{{ $client->full_name }}<br />
							</div>
						@endforeach
					</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
