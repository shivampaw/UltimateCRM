@extends('layouts.app')

@section('page_title', 'Create Invoice For '.$client->name)

@section('content')
    <div id="newInvoice">
        <div class="alert alert-danger" v-if="errors.length > 0">
            <ul>
                <li v-for="error in errors">
                    @{{ error }}
                </li>
            </ul>
        </div>
        <form action="/clients/{{ $client->id }}/invoices" method="post" @submit.prevent="submitForm">
            <div class="form-group">
                <input type="date" v-model="due_date" class="form-control" placeholder="Due Date" required>
            </div>
            <div class="form-group">
                <input type="number" v-model="project_id" placeholder="Project ID" class="form-control">
            </div>
            <hr/>
            <p class="clearfix">
                <strong class="float-left">Invoice Items</strong>
                <a @click.prevent="addInvoiceItem" class="float-right text-info">Add Invoice Item</a>
            </p>

            <div class="form-group" v-for="(invoiceItem, i) in invoiceItems">
                <div class="row">
                    <div class="col-md-6">
                        <input type="text" class="form-control" placeholder="Description"
                               v-model="invoiceItem.description" required>
                    </div>
                    <div class="col-md-3">
                        <input type="number" class="form-control" placeholder="Quantity" v-model="invoiceItem.quantity"
                               required>
                    </div>
                    <div class="col-md-3">
                        <input type="number" class="form-control" placeholder="Price" step="0.01"
                               v-model="invoiceItem.price" required>
                    </div>
                </div>
                <a class="text-danger" @click="removeInvoiceItem(i)">Remove Item</a>
            </div>

            <hr/>
            <div class="form-group">
                <label class="custom-control custom-checkbox">
                    <input type="checkbox" v-model="recurringChecked" class="custom-control-input">
                    <span class="custom-control-indicator"></span>
                    <span class="custom-control-description">Check this if you want to make this invoice recurring.</span>
                </label>
            </div>
            <div class="form-group" v-if="recurringChecked">
                <input type="number" v-model="recurring_date" class="form-control" placeholder="Recurring Date"
                       required>
                <small class="form-text text-muted">How many days should this invoice be generated after it's last
                    generation.
                </small>
            </div>
            <div class="form-group" v-if="recurringChecked">
                <input type="number" v-model="recurring_due_date" class="form-control" placeholder="Reucrring Due Date"
                       required>
                <small class="form-text text-muted">How many days after this invoice generates should the due date be.
                </small>
            </div>
            <div class="form-group">
                <textarea v-model="notes" id="notes" rows="5" placeholder="Notes" class="form-control"></textarea>
            </div>
            <div class="form-group">
                <input type="number" class="form-control" placeholder="Discount" step="0.01" v-model="discount">
            </div>
            <div class="form-group">
                <input type="submit" class="btn-primary btn btn-block" value="Create Invoice">
            </div>
        </form>
        <div class="alert alert-danger" v-if="errors.length > 0">
            <ul>
                <li v-for="error in errors">
                    @{{ error }}
                </li>
            </ul>
        </div>

        <hr/>

        <p>
            <a href="/clients/{{ $client->id }}/invoices" class="btn btn-info"><span
                        class="fa fa-angle-double-left"></span> Back to Client Invoices</a>
        </p>
    </div>

@endsection

@section('footer')
    <script type="text/javascript" src="/js/newInvoice.js"></script>
@endsection
