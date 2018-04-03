@extends('layouts.app')

@section('page_title', 'Admins')

@section('content')
    <p>
		<a href="/admins/create" class="btn btn-success btn-block" title="Create New Admin"><span
                    class="fa fa-plus"></span> Create Admin</a>
	</p>
    <div class="row justify-content-center mt-4">
		{{ $admins->links('vendor.pagination.bootstrap-4') }}
	</div>
    <div class="row">
		@foreach($admins as $admin)
            <div class="col-lg-4 col-sm-6 mt-3">
				<div class="card admin text-center">
					<div class="card-body">
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
							<button onclick="return confirm('Are you sure you want to delete {{ $admin->name }}')"
                                    class="btn btn-danger"><span class="fa fa-trash"></span> Delete Admin</button>
					    </form>
					</div>
				</div>
			</div>
        @endforeach
	</div>
    <div class="row justify-content-center mt-4">
		{{ $admins->links('vendor.pagination.bootstrap-4') }}
	</div>
@endsection
