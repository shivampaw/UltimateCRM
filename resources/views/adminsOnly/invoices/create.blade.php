@extends('layouts.app')

@section('page_title', 'Create Invoice For '.$client->full_name)

@section('content')
    <form action="/clients/{{ $client->id }}/invoices" method="post">
        <div class="form-group">
            <input type="date" name="due_date" class="form-control" placeholder="Due Date" value="{{ old('due_date') }}">
        </div>
        <hr />
        <p class="clearfix">
            <strong class="pull-left">Invoice Items</strong>
            <a id="add_invoice_item" class="pull-right"><span class="fa fa-plus"></span></a>
        </p>
        <div class="invoice-items">
            
        </div>
        <hr />
        <div class="form-group">
            <textarea name="notes" id="notes" rows="5" placeholder="Notes" class="form-control">{{ old(('notes')) }}</textarea>
        </div>
        <div class="form-group">
            {{ csrf_field() }}
            <button class="btn-primary btn btn-block" onClick="onInvoiceSubmit(event)">Create Invoice</button>
        </div>
    </form>

    <p>
        <a href="/clients/{{ $client->id }}/invoices" class="btn btn-info"><span class="fa fa-angle-double-left"></span> Back to Client Invoices</a>
    </p>

    <script type="text/jQuery-tpl" id="invoiceItemTemplate">
        <div class="form-group invoice_item">
            <a href="#" class="text-danger" onClick="removeItem({i})">Remove Item</a>
            <div class="error_space_{i}"></div>
            <div class="row">
                <div class="col-md-6">
                    <input type="text" name="item_details[{i}][description]" class="form-control" placeholder="Description">
                </div>
                <div class="col-md-3">
                    <input type="number" class="form-control" name="item_details[{i}][quantity]" placeholder="Quantity">
                </div>
                <div class="col-md-3">
                    <input type="text" class="form-control" name="item_details[{i}][price]" placeholder="Price">
                </div>
            </div>
        </div>
    </script>

@endsection

@section('footer')
<script type="text/javascript" src="/js/newInvoice.js"></script>
@endsection
