@extends('layouts.app')

@section('page_title', 'All Recurring Invoices for '.$client->name)

@section('content')

    <p>
        <a href="/clients/{{ $client->id }}/recurring-invoices/create" class="btn btn-success btn-block"><span
                    class="fa fa-plus"></span> Create Recurring Invoice</a>
    </p>

    <div class="row">
        @forelse($recurringInvoices as $invoice)
            <div class="col-lg-4 col-sm-6 mt-3">
                <div class="card client text-center">
                    <div class="card-body">
                        <p class="card-title font-weight-bold ">Recurring Invoice For {{ $invoice->client->name }}</p>
                        <p class="text-info">Total Charge: {{ formatInvoiceTotal($invoice->total) }}</p>
                        <p class="text-success">
                            Next Generation: {{ $invoice->next_run->toFormattedDateString() }}
                        </p>
                        <p>
                            <a href="/clients/{{ $client->id }}/recurring-invoices/{{ $invoice->id}}/"
                               title="Invoice #{{ $invoice->id }}" class="mt-3 btn btn-primary">View Details</a>
                        </p>

                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 mt-3">
                <p>There are currently no recurring invoices.</p>
            </div>
        @endforelse
    </div>


    <hr/>

    <p>
        <a href="/clients/{{ $client->id }}" class="btn btn-info"><span class="fa fa-angle-double-left"></span> Back to
            Client</a>
    </p>

@endsection
