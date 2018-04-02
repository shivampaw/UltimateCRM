<p>Thanks for logging in!</p>
<p>You can view your projects, invoices and make payments using the navigation menu above!</p>
@php
    $invoiceCount = $user->client->invoices()->where('paid', false)->count();
    $projectCount = $user->client->projects()->where('accepted', false)->count();
@endphp
<p>You have {{ $invoiceCount  }} {{ str_plural('invoice', $invoiceCount) }} unpaid.</p>
<p>You have {{ $projectCount  }} {{ str_plural('project', $projectCount) }} not accepted.</p>
<p>If you have any questions then be sure to email {{ DB::table('users')->find(1)->email }}
