<p><strong>Invoice #{{ $invoice->id }}</strong></p>
<p>Total Charge: {{ formatInvoiceTotal($invoice->total) }}</p>
@if($invoice->paid)
    <p>Paid On: {{ $invoice->paid_at->toFormattedDateString() }}</p>
@endif
<p>Created On: {{ $invoice->created_at->toFormattedDateString() }}</p>
<p>Due By: {{ $invoice->due_date->toFormattedDateString() }}</p>

@if($invoice->due_date->isPast())
    <p class="text-danger h4">Payment Overdue</p>
@endif
