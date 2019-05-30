@extends('layouts.app')

@section('page_title', 'Create Recurring Invoice For '.$client->name)

@section('content')
    <div id="newInvoice">
        <div class="alert alert-danger" v-if="errors.length > 0">
            <ul>
                <li v-for="error in errors">
                    @{{ error }}
                </li>
            </ul>
        </div>
        <form action="/clients/{{ $client->id }}/recurring-invoices" method="post" @submit.prevent="submitForm">
            <div class="form-group">
                <p class="clearfix">
                    <strong>Project ID:</strong>
                </p>
                <input type="number" v-model="project_id" placeholder="Project ID" class="form-control">
            </div>
            <hr/>
            <p class="clearfix">
                <strong class="float-left">Invoice Items</strong>
                <a @click.prevent="addInvoiceItem" class="float-right text-info">Add Invoice Item</a>
            </p>

            <div class="form-group" v-for="(invoiceItem, i) in item_details">
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
                <select v-model="how_often" class="form-control" required>
                    <option value="">Select...</option>
                    <option value="Every day">Every day</option>
                    <option value="Every week">Every week</option>
                    <option value="Every two weeks">Every two weeks</option>
                    <option value="Every month">Every month</option>
                    <option value="Every six months">Every six months</option>
                    <option value="Every year">Every year</option>
                </select>
                <small class="form-text text-muted">How often this invoice be generated after it's last
                    generation.
                </small>
            </div>
            <div class="form-group">
                <input type="number" v-model="due_date" class="form-control" placeholder="Recurring Due Date"
                       required>
                <small class="form-text text-muted">
                    How many days after this invoice generates should the due date be.
                </small>
            </div>
            <div class="form-group">
                <input type="date" v-model="next_run" min="{{ \Carbon\Carbon::yesterday()->format('Y-M-D') }}"
                       class="form-control" placeholder="First Run" required>
                <small class="form-text text-muted">
                    Date this invoice should first be generated (now or at a later date).
                </small>
            </div>
            <div class="form-group">
                <textarea v-model="notes" id="notes" rows="5" placeholder="Notes" class="form-control"></textarea>
            </div>
            <div class="form-group">
                <input type="number" class="form-control" placeholder="Discount" step="0.01" v-model="discount">
            </div>
            <div class="form-group">
                <input type="submit" class="btn-primary btn btn-block" value="Create Recurring Invoice">
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
                        class="fa fa-angle-double-left"></span> Back to Client Recurring Invoices</a>
        </p>
    </div>

@endsection

@section('footer')
    <script type="text/javascript" src="/js/newInvoice.js"></script>
@endsection
