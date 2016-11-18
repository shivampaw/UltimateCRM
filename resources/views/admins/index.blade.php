@extends('layouts.app')

@section('page_title', 'Admins')

@section('content')
	<p>
		<a href="/admins/create" class="btn btn-success btn-block" title="Create New Admin">Create Admin</a>
	</p>
	<div class="row">
		@foreach($admins as $admin)
			<div class="col-lg-4 col-sm-6">
				<div class="card admin text-xs-center">
					<div class="card-block">
						<h4 class="card-title">{{ $admin->name }}</h4>
						<p class="card-text">
							<div class="text-info">Email: {{ $admin->email }}</div>
							<div class="text-info">Created On: {{ $admin->created_at->toFormattedDateString() }}</div>
							<div class="text-info">Updated On: {{ $admin->updated_at->toFormattedDateString() }}</div>
						</p>
						<a href="/admins/{{ $admin->id}}/" title="{{ $admin->name }}" class="btn btn-primary">View Admin</a>
					</div>
				</div>
			</div>
		@endforeach
	</div>

	<div class="text-xs-center">
		{{ $admins->links() }}
	</div>
@endsection
