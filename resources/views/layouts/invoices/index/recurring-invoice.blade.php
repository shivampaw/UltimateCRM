<h4 class="card-title">Recurring Invoice #{{ $invoice->id }}</h4>
<p class="text-info">Total Charge: {{ formatInvoiceTotal($invoice->total) }}</p>
<p class="text-success">Next Generation: {{ $invoice->next_run->toFormattedDateString() }}</p>
<p>
    <a href="/clients/{{ $client->id }}/recurring-invoices/{{ $invoice->id}}/"
       title="Invoice #{{ $invoice->id }}" class="mt-3 btn btn-primary">View Details</a>
</p>
