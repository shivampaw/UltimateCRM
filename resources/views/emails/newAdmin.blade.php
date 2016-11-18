<p>Hi {{ $user->name }},</p>
<p>An admin account has just been created for you on my client portal.</p>
<p>You will be able to use this account to manage clients, their invoices and agreements.</p>
<p>You can login at <strong>{!! url('/'); !!}</strong>.</p>
<p>Your email is <strong>{{ $user->email }}</strong> and your password is <strong>{{ $password }}</strong>.</p>
<p>You can reset your password once you have logged in.</p>
<p>If you have any questions or problems be sure to email me, you can do so by replying to this email.</p>
<p>Thanks!<br />Shivam</p>