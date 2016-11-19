<p>Hi {{ $client->full_name }},</p>
<p>The invoice #{{ $invoice->id }} has just been paid for.</p>
<p>The total charge for this invoice was <strong>{{ formatInvoiceTotal($invoice->total) }}</strong>.</p>
<p>The invoice was due by <strong>{{ $invoice->due_date->toFormattedDateString() }}</strong>.</p>
<p>If you have any questions or problems be sure to email me, you can do so by replying to this email.</p>
<p>Thanks!<br />
{{ DB::table('users')->find(1)->name }}
</p>