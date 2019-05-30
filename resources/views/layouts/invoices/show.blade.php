<div id="invoice">
    <div class="row">
        <div class="col-sm-6 text-center text-sm-left">
            <strong>Billed To</strong><br/>
            {{ $invoice->client->name }}<br/>
            {!! nl2br($invoice->client->address) !!}
        </div>
        <span class="d-sm-none invoice_break"></span>
        <div class="col-sm-6 text-sm-right text-center">
            @if($invoice instanceof  App\Models\Invoice)
                @include("layouts.invoices.show.invoice")
            @else
                @include("layouts.invoices.show.recurring-invoice")
            @endif
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <h5>Invoice Breakdown</h5>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>Item Description</th>
                    <th>Quantity</th>
                    <th>Unit Price</th>
                    <th>Total Price</th>
                </tr>
                </thead>
                <tbody>
                @foreach(json_decode($invoice->item_details) as $item)
                    <tr scope="row">
                        <td>{{ $item->description }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>{{ formatInvoiceTotal($item->price) }}</td>
                        <td>{{ formatInvoiceTotal($item->price * $item->quantity) }}</td>
                    </tr>
                @endforeach
                <tr scope="row">
                    <td colspan="3"><strong>Discount</strong></td>
                    <td>{{ formatInvoiceTotal($invoice->discount) }}
                </tr>
                <tr scope="row">
                    <td colspan="3"><strong>Total</strong></td>
                    <td>{{ formatInvoiceTotal($invoice->total) }}
                </tr>
                </tbody>
            </table>
        </div>
    </div>
    @if(!empty($invoice->notes))
        <div class="row">
            <div class="col-12">
                <h5>Notes</h5>
            </div>
            <div class="col-12">
                <p>{!! nl2br($invoice->notes) !!}</p>
            </div>
        </div>
    @endif
</div>
