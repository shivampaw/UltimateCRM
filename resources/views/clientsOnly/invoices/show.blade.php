@extends('layouts.app')

@section('page_title', 'Invoice #'.$invoice->id)

@section('content')
    
    @include("layouts.invoices.show")

    <div class="text-center">
        <a  href="/invoices" class="btn btn-info float-md-left"><span class="fa fa-angle-double-left"></span> Back to Invoices</a>
        @if(!$invoice->paid)
            <a href="/invoices/{{ $invoice->id }}/pay" class="btn btn-success float-md-right" title="Pay Invoice #{{ $invoice->id }}">Pay Invoice</a>
        @else
            <button class="btn btn-success float-md-right">Invoice Paid on {{ $invoice->paid_at->toFormattedDateString() }}</button>
        @endif
    </div>

@endsection