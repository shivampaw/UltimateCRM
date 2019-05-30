@extends('layouts.app')

@section('page_title', $client->name)

@section('content')

    <div class="row text-center">
        <div class="col-md-6 mt-3">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Client Details</h4>
                    <div class="card-text">
                        <div class="text-success">{{ $client->name }}</div>
                        <div class="text-warning">{{ $client->email }}</div>
                        <div class="text-info">{{ $client->number }}</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 mt-3">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Client Address</h4>
                    <div class="card-text">
                        <p class="text-info">
                            {!! nl2br($client->address) !!}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 mt-3">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Invoices</h4>
                    <div class="card-text">
                        <div class="text-success">
                            Paid Invoices: {{ $client->invoices->where('paid', true)->count() }}
                        </div>
                        <div class="text-warning">
                            Unpaid Invoices: {{ $client->invoices->where('paid', false)->count() }}
                        </div>
                        <div class="text-info">
                            <a href="/clients/{{ $client->id }}/invoices" title="View Client Invoices">
                                View Invoices
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 mt-3">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Recurring Invoices</h4>
                    <div class="card-text">
                        <div class="text-success">
                            Number of Recurring Invoices: {{ $client->recurringInvoices->count() }}
                        </div>
                        <div>&nbsp;</div>
                        <div class="text-info">
                            <a href="/clients/{{ $client->id }}/recurring-invoices" title="View Recurring Invoices">
                                View Recurring Invoices
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-12 mt-3">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Projects</h4>
                    <div class="card-text">
                        <div class="text-success">
                            Agreed Projects: {{ $client->projects->where('accepted', true)->count() }}
                        </div>
                        <div class="text-warning">
                            Unagreed Projects: {{ $client->projects->where('accepted', false)->count() }}
                        </div>
                        <div class="text-info">
                            <a href="/clients/{{ $client->id }}/projects" title="View Client Projects">
                                View Projects
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <hr/>

    <div class="text-center">
        <form action="/clients/{{ $client->id }}" method="post">
            {{ csrf_field() }}
            <input type="hidden" name="_method" value="delete">
            <button onclick="return confirm('Are you sure you want to delete {{ $client->name }}')"
                    class="btn btn-danger float-left"><span class="fa fa-trash"></span>
                Delete Client
            </button>
        </form>
        <a href="/clients/{{ $client->id }}/edit" class="btn btn-info float-right" title="Edit Client">
            <span class="fa fa-pencil"></span>
            Edit Client
        </a>
    </div>
@endsection
