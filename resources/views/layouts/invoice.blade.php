    <div id="invoice">
        <div class="row">
            <div class="col-md-6">
                <strong>Billed To</strong><br />
                {{ $invoice->client->full_name }}<br />
                {{ $invoice->client->address }}
            </div>
            <div class="col-md-6 text-sm-right">
                <strong>Invoice #{{ $invoice->id }}</strong>
                <div>Total Charge: <strong>{{ formatInvoiceTotal($invoice->total) }}</strong></div>
                @if($invoice->paid)
                    <div>Paid On: <strong>{{ $invoice->paid_at->toFormattedDateString() }}</strong></div>
                @endif
                <div>Created On: <strong>{{ $invoice->created_at->toFormattedDateString() }}</strong></div>
                <div>Due By: <strong>{{ $invoice->due_date->toFormattedDateString() }}</strong></div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
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
                <div class="col-xs-12">
                    <h5>Notes</h5>
                </div>
                <p>
                    {{ $invoice->notes }}
                </p>
            </div>
        @endif
    </div>