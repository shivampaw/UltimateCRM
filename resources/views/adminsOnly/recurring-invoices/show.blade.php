@extends('layouts.app')

@section('page_title', 'Invoice #'.$invoice->id)

@section('content')

    @include("layouts.invoices.show")

    <div class="text-center">
        <a href="/clients/{{ $invoice->client->id }}/invoices" class="btn btn-info float-left">
            <span class="fa fa-angle-double-left"></span>
            Back to Client Recurring Invoices</a>
        @if(!$invoice->paid)
            <form action="/clients/{{ $invoice->client->id }}/invoices/{{ $invoice->id }}" method="post">
                {{ csrf_field() }}
                <input type="hidden" name="_method" value="delete">
                <button onclick="return confirm('Are you are you want to delete this recurring invoice?')"
                        class="btn btn-danger float-md-right">
                    <span class="fa fa-trash"></span>
                    Delete Invoice
                </button>
            </form>
        @else
            <button class="btn btn-success float-right">
                Invoice Paid on {{ $invoice->paid_at->toFormattedDateString() }}
            </button>
        @endif
    </div>

@endsection
