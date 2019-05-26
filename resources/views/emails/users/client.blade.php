<p>Hi {{ $user->name }},</p>
<p>A client account has just been created for you on my client portal.</p>
<p>You will be able to use this account to see the status of your project, view agreements and also securely pay and
    view any invoices.</p>
<p>You can login at <strong>{!! $login_url; !!}</strong>.</p>
<p>Your email is <strong>{{ $user->email }}</strong> and your password is <strong>{{ $password }}</strong>.</p>
<p>You can reset your password once you have logged in.</p>
<p>If you have any questions or problems be sure to email me, you can do so by replying to this email.</p>
<p>Thanks!<br/>
    {{ DB::table('users')->find(1)->name }}
</p>
