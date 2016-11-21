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
							<div>{{ $admin->email }}</div>
						</p>
						<p>
							<a href="/admins/{{ $admin->id}}/edit" title="{{ $admin->name }}" class="btn btn-primary">Edit Admin</a>
						</p>
						<form action="/admins/{{ $admin->id }}" method="post">
							{{ csrf_field() }}
							<input type="hidden" name="_method" value="delete">
							<button onclick="return confirm('Are you sure you want to delete {{ $admin->name }}')" class="btn btn-danger"><span class="fa fa-trash"></span> Delete Admin</button>
					    </form>
					</div>
				</div>
			</div>
		@endforeach
	</div>
@endsection
