<p>Hi {{ $client->full_name }},</p>
<p>An invoice has just been generated for you.</p>
<p>You can pay for this invoice by logging on at <strong>{!! url('/'); !!}</strong> and viewing your invoices.</p>
<p>The total charge for this invoice is <strong>£{!! number_format($invoice->total/100, 2); !!}</strong>.</p>
<p>If you have any questions or problems be sure to email me, you can do so by replying to this email.</p>
<p>Thanks!<br />Shivam</p>