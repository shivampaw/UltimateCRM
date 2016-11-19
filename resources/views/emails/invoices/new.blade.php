<p>Hi {{ $client->full_name }},</p>
<p>An invoice has just been generated for you.</p>
<p>You can pay for this invoice by logging on at <strong>{!! url('/'); !!}</strong> and viewing your invoices.</p>
<p>The total charge for this invoice is <strong>{{ formatInvoiceTotal($invoice->total) }}</strong>.</p>
<p>The invoice is due by <strong>{{ $invoice->due_date->toFormattedDateString() }}</strong>.</p>
<p>If you have any questions or problems be sure to email me, you can do so by replying to this email.</p>
<p>Thanks!<br />
{{ DB::table('users')->find(1)->name }}
</p>