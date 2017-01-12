<div class="row">
    @foreach($invoices as $invoice)
        <div class="col-lg-4 col-sm-6">
            <div class="card client text-center">
                <div class="card-block">
                    <h4 class="card-title">Invoice #{{ $invoice->id }}</h4>
                    <p class="card-text">
                        <div class="text-info">Total Charge: {{ formatInvoiceTotal($invoice->total) }}</div>
                        @if($invoice->paid)
                            <div class="text-success">Invoice Paid on {{ $invoice->paid_at->toFormattedDateString() }}</div>
                        @else
                            <div class="text-danger">Payment Due By: {{ $invoice->due_date->toFormattedDateString() }}</div>
                        @endif
                    </p>
                    @if(Auth::user()->isAdmin())
                        <a href="/clients/{{ $invoice->client->id }}/invoices/{{ $invoice->id}}/" title="Invoice #{{ $invoice->id }}" class="btn btn-primary">View Invoice</a>
                    @else
                        <a href="/invoices/{{ $invoice->id}}/" title="Invoice #{{ $invoice->id }}" class="btn btn-primary">View Invoice</a>
                    @endif
                </div>
            </div>
        </div>
    @endforeach
</div>