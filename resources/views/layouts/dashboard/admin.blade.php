<p>You are an admin! This means you can manage clients, their invoices and their projects.</p>
<p>To get started use the navigation menu above!</p>

@if($user->isSuperAdmin())
    <p>You are a super admin (ID = 1)</p>
@else
    <p>You are not a super admin (ID != 1)</p>
@endif

@if($user->isAdmin())
    <p>You are a normal admin</p>
@endif