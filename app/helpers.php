<?php

use App\Models\User;
use App\Mail\NewUser;
use Illuminate\Http\Request;

function flash($message, $level = 'success')
{
    session()->flash('status', $message);
    session()->flash('status_level', $level);
}

function addUser($name, $email, $password = null, $admin = false)
{
    $password = $password ?: str_random(10);
    $user = User::create([
        'name'     => $name,
        'email'    => $email,
        'password' => bcrypt($password),
        'is_admin' => $admin
    ]);

    if(config('app.env') !== "testing"){
        Mail::send(new NewUser($user, $password));
    }

    return $user;
}

function formatInvoiceTotal($number)
{
    return config('crm.currency').number_format($number/100, 2);
}
