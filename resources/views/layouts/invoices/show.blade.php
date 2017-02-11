    <div id="invoice">
        <div class="row">
            <div class="col-sm-6 text-center text-sm-left">
                <strong>Billed To</strong><br />
                {{ $invoice->client->name }}<br />
                {!! nl2br($invoice->client->address) !!}
            </div>
            <span class="hidden-sm-up invoice_break"></span>
            <div class="col-sm-6 text-sm-right text-center">
                <strong>Invoice #{{ $invoice->id }}</strong>
                <div>Total Charge: {{ formatInvoiceTotal($invoice->total) }}</div>
                @if($invoice->paid)
                    <div>Paid On: {{ $invoice->paid_at->toFormattedDateString() }}</div>
                @endif
                <div>Created On: {{ $invoice->created_at->toFormattedDateString() }}</div>
                <div>Due By: {{ $invoice->due_date->toFormattedDateString() }}</div>
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
                                <td>{{ formatInvoiceTotal($item->price * 100) }}</td>
                                <td>{{ formatInvoiceTotal(($item->price * 100) * $item->quantity) }}</td>
                            </tr>
                        @endforeach
                        <tr scope="row">
                            <td colspan="3"><strong>Total</strong></td>
                            <td>{{ formatInvoiceTotal($invoice->total) }}
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        @if($invoice->notes !== "")
            <div class="row">
                <div class="col-12">
                    <h5>Notes</h5>
                </div>
                <div class="col-12">
                    <p>{{ $invoice->notes }}</p>
                </div>
            </div>
        @endif
    </div>