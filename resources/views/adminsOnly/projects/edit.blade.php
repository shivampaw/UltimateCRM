@extends('layouts.app')

@section('page_title', 'Edit Project ('.$project->title.') For '.$client->name)

@section('content')

<p>You can update the title and upload a new PDF file below. The updated PDF will be emailed to the client and the project will be marked as unaccpeted until the client logs in and accepts it.</p>

<form action="/clients/{{ $client->id }}/projects" method="post" enctype="multipart/form-data">
	{{ csrf_field() }}
	<div class="form-group">
		<label for="title" class="sr-only">Project Title</label>
		<input type="text" class="form-control" placeholder="Project Title" name="title" id="title" value="{{ $project->title }}">
	</div>
	<div class="form-group">
		<label class="custom-file">
		  <input type="file" id="pdf" name="pdf" value="{{ $project->pdf_path }}" class="custom-file-input">
		  <span class="custom-file-control"></span>
		</label>
	</div>
	<div class="form-group">
		<button class="btn btn-primary">Create Project</button>
	</div>
</form>

@endsection

@section('footer')
<script>
   $("#pdf").change(function (e) {
        var path = this.value;
        $('<style>.custom-file-control:lang(en)::after{ content: "'+ path.substring(12, path.length)+'"; }</style>').appendTo('head');
   });
</script>
@endsection