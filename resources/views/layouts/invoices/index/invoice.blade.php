<h4 class="card-title">Invoice #{{ $invoice->id }}</h4>
<p class="text-info">Total Charge: {{ formatInvoiceTotal($invoice->total) }}</p>
@if($invoice->paid)
    <p class="text-success">Invoice Paid on {{ $invoice->paid_at->toFormattedDateString() }}</p>
@elseif($invoice->due_date->isPast())
    <p class="text-danger">Payment Due By: {{ $invoice->due_date->toFormattedDateString() }}</p>
@else
    <p class="text-warning">Payment Due By: {{ $invoice->due_date->toFormattedDateString() }}</p>
@endif
<p>
    @if(Auth::user()->isAdmin())
        <a href="/clients/{{ $client->id }}/invoices/{{ $invoice->id}}/"
           title="Invoice #{{ $invoice->id }}" class="mt-3 btn btn-primary">View Invoice</a>
    @else
        <a href="/invoices/{{ $invoice->id}}/" title="Invoice #{{ $invoice->id }}"
           class="mt-3 btn btn-primary">View Invoice</a>
    @endif
</p>
