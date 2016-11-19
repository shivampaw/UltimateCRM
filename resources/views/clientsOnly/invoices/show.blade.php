@extends('layouts.app')

@section('page_title', 'Invoice #'.$invoice->id)

@section('content')
    
    @include("layouts.invoices.show")

    <div class="row">
        @if(!$invoice->paid)
            <div class="col-xs-12 text-sm-right text-xs-center">
                <a href="/invoices/{{ $invoice->id }}/pay" class="btn btn-info" title="Pay Invoice #{{ $invoice->id }}">Pay Invoice</a>
            </div>
        @else
            <div class="col-xs-12 text-sm-right text-xs-center">
                <button class="btn btn-success">Invoice Paid on {{ $invoice->paid_at->toFormattedDateString() }}</button>
            </div>
        @endif
    </div>

@endsection