@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Create Client</div>

                <div class="panel-body">

                    @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="/clients" method="post">
                        <div class="form-group">
                            <label for="name" class="sr-only">Full Name</label>
                            <input type="text" class="form-control" name="full_name" id="full_name" placeholder="Full Name">
                        </div>
                        <div class="form-group">
                            <label for="email" class="sr-only">Email</label>
                            <input type="email" class="form-control" name="email" id="email" placeholder="Email">
                        </div>
                        <div class="form-group">
                            <label for="number" class="sr-only">Contact Number</label>
                            <input type="number" class="form-control" name="number" id="number" placeholder="Contact Number">
                        </div>
                        <div class="form-group">
                            <label for="address" class="sr-only">Address</label>
                            <textarea class="form-control" name="address" id="address" placeholder="Address" rows="5"></textarea>
                        </div>
                        <div class="form-group">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <button class="btn btn-primary btn-block">Add Client</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
