<p>Hi {{ $user->name }},</p>
<p>You have requested a password reset to the client portal.</p>
<p>Click here to reset your password: <a href="{{ $link = url('password/reset', $token).'?email='.urlencode($user->getEmailForPasswordReset()) }}"> {{ $link }} </a></p>
<p>If you didn't request this, you can safely ignore this.</p>
<p>Thanks!<br />Shivam</p>
