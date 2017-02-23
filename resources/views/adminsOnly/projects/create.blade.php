@extends('layouts.app')

@section('page_title', 'Create Project For '.$client->name)

@section('content')

<p>Enter a title and upload a PDF file below with the project details. The client will be able to view the PDF by logging in and it will also be emailed to them.</p>

<form action="/clients/{{ $client->id }}/projects" method="post" enctype="multipart/form-data">
	{{ csrf_field() }}
	<div class="form-group">
		<label for="title" class="sr-only">Project Title</label>
		<input type="text" class="form-control" placeholder="Project Title" value="{{ old('title') }}" name="title" id="title">
	</div>
	<div class="form-group">
		<label class="custom-file">
		  <input type="file" id="pdf" name="pdf" class="custom-file-input">
		  <span class="custom-file-control"></span>
		</label>
	</div>
	<div class="form-group">
		<button class="btn btn-primary">Create Project</button>
	</div>
</form>

<hr />

<p>
    <a href="/clients/{{ $client->id }}/projects" class="btn btn-info"><span class="fa fa-angle-double-left"></span> Back to Client Projects</a>
</p>

@endsection

@section('footer')
<script>
   $("#pdf").change(function (e) {
        var path = this.value;
        $('<style>.custom-file-control:lang(en)::after{ content: "'+ path.substring(12, path.length)+'"; }</style>').appendTo('head');
   });
</script>
@endsection