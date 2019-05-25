@extends('layouts.app')

@section('page_title', 'Pay Invoice #'.$invoice->id)

@section('content')
    <p><strong>Invoice Total is {{ formatInvoiceTotal($invoice->total) }}</strong></p>
    <form action="/invoices/{{ $invoice->id }}" method="POST" id="payment-form">
        {{ csrf_field() }}
        <div class="payment-errors"></div>
        <div class="form-group">
            <label class="sr-only">Full Name</label>
            <input type="text" data-stripe="name" placeholder="Full Name" class="form-control"
                   value="{{ $invoice->client->name }}">
        </div>
        <div class="form-group">
            <label class="sr-only">Postal Code</label>
            <input type="text" data-stripe="address_zip" placeholder="Postal Code" class="form-control">
        </div>
        <div class="form-group">
            <label class="sr-only">Card Number</label>
            <input type="text" data-stripe="number" placeholder="Card Number" class="form-control">
        </div>
        <div class="form-group">
            <label class="sr-only">Expiration Date (MM/YYYY)</label>
            <div class="row">
                <div class="col-md-6">
                    <input type="text" data-stripe="exp_month" placeholder="Expiration Month (MM)" class="form-control">
                </div>
                <div class="col-md-6">
                    <input type="text" data-stripe="exp_year" placeholder="Expiration Year (YYYY)" class="form-control">
                </div>
            </div>
        </div>
        <div class="form-group">
            <label class="sr-only">CVC</label>
            <input type="text" data-stripe="cvc" placeholder="CVC" class="form-control">
        </div>
        <div class="form-group">
            <button id="payInvoiceBtn" type="submit" class="btn btn-primary btn-block">Pay Invoice</button>
        </div>
    </form>

    <hr/>

    <a href="/invoices/{{ $invoice->id }}" class="btn btn-danger"><span class="fa fa-angle-double-left"></span> Back to
        Invoice</a>
@endsection

@section('footer')
    <script type="text/javascript" src="https://js.stripe.com/v2/"></script>
    <script>
        (function () {
            Stripe.setPublishableKey('{{ config('services.stripe.key') }}');
        })();

        $(function () {
            var $form = $('#payment-form');
            $form.submit(function (event) {
                $form.find('.submit').prop('disabled', true);
                $form.find('.payment-errors').removeClass('alert alert-danger').text("");
                Stripe.card.createToken($form, stripeResponseHandler);
                return false;
            });
        });

        function stripeResponseHandler(status, response) {
            // Grab the form:
            var $form = $('#payment-form');
            if (response.error) {
                $form.find('.payment-errors').addClass('alert alert-danger').text(response.error.message);
                $form.find('.submit').prop('disabled', false);
            } else {
                var token = response.id;
                $form.append($('<input type="hidden" name="stripeToken">').val(token));
                $form.get(0).submit();
            }
        }
        ;

    </script>
@endsection
