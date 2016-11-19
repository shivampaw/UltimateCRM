@extends('layouts.app')

@section('page_title', 'Invoice #'.$invoice->id)

@section('content')
    
    @include("layouts.invoices.show")

    <div class="row">
        @if(!$invoice->paid)
            <div class="col-xs-12 text-sm-right text-xs-center">
                <form action="/clients/{{ $invoice->client->id }}/invoices/{{ $invoice->id }}" method="post">
                    {{ csrf_field() }}
                    <input type="hidden" name="_method" value="delete">
                    <button class="btn btn-danger"><span class="fa fa-trash"></span> Delete Invoice</button>
                </form>
            </div>
        @else
            <div class="col-xs-12 text-sm-right text-xs-center">
                <button class="btn btn-success">Invoice Paid on {{ $invoice->paid_at->toFormattedDateString() }}</button>
            </div>
        @endif
    </div>

@endsection