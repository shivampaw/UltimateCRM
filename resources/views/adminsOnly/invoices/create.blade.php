@extends('layouts.app')

@section('page_title', 'Create Invoice For '.$client->name)

@section('content')
    <form action="/clients/{{ $client->id }}/invoices" method="post">
        <div class="form-group">
            <input type="date" name="due_date" class="form-control" placeholder="Due Date">
        </div>
        <div class="form-group">
            <input type="number" name="project_id" placeholder="Project ID" class="form-control" value="{{ old('project_id', Input::get('project_id')) }}">
        </div>
        <hr />
        <p class="clearfix">
            <strong class="float-left">Invoice Items</strong>
            <a id="add_invoice_item" class="float-right"><span class="fa fa-plus"></span></a>
        </p>
        <div class="invoice-items">
            
        </div>
        <hr />
        <div class="form-group">
            <label class="custom-control custom-checkbox">
                <input type="checkbox" name="recurring" id="recurring_check" class="custom-control-input">
                <span class="custom-control-indicator"></span>
                <span class="custom-control-description">Check this if you want to make this invoice recurring.</span>
            </label>
        </div>
        <div class="form-group recurring">
            <input type="number" name="recurring_date" class="form-control" placeholder="Recurring Date">
            <small class="form-text text-muted">How many days should this invoice be generated after it's last generation.</small>
        </div>
        <div class="form-group recurring">
            <input type="number" name="recurring_due_date" class="form-control" placeholder="Reucrring Due Date">
            <small class="form-text text-muted">How many days after this invoices generation should the due date be.</small>
        </div>
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
