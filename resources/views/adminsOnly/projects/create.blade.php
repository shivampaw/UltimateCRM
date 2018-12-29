@extends('layouts.app')

@section('page_title', 'Create Project For '.$client->name)

@section('content')

    <p>Enter a title and upload a PDF file below with the project details. The client will be able to view the PDF by
        logging in and it will also be emailed to them.</p>

    <form action="/clients/{{ $client->id }}/projects" method="post" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="form-group">
            <label for="title" class="sr-only">Project Title</label>
            <input type="text" class="form-control" placeholder="Project Title" value="{{ old('title') }}" name="title"
                   id="title">
        </div>
        <div class="form-group">
            <div class="custom-file">
                <input type="file" class="custom-file-input" id="pdf" name="pdf" required>
                <label class="custom-file-label" for="pdf">Choose file...</label>
            </div>
        </div>
        <div class="form-group">
            <button class="btn btn-success">Create Project</button>
        </div>
    </form>

    <hr/>

    <p>
        <a href="/clients/{{ $client->id }}/projects" class="btn btn-info"><span class="fa fa-angle-double-left"></span>
            Back to Client Projects</a>
    </p>

@endsection

@section('footer')
    <script>
        $("#pdf").change(function (e) {
            var path = this.value;
            $('.custom-file-label').text(path.substring(12, path.length));
        });
    </script>
@endsection