<p><strong>Recurring Invoice #{{ $invoice->id }}</strong></p>
<p>Next Creation: {{ $invoice->next_run->toFormattedDateString() }}</p>
<p>Due After: {{ $invoice->due_date }} Days</p>
<p>Repeats: {{ $invoice->how_often }}</p>
<p>Total Charge: {{ formatInvoiceTotal($invoice->total) }}</p>
