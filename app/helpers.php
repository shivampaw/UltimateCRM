<?php

use App\User;
use Illuminate\Http\Request;

function flash($message, $level = 'success')
{
	session()->flash('status', $message);
	session()->flash('status_level', $level);
}

function addUser(Request $request, $admin = false)
{
	$user = new User();
    $password = str_random(10);
    $user->name = $request->name;
    $user->password = bcrypt($password);
    $user->email = $request->email;
    $user->is_admin = $admin;
    $user->save();

    Mail::send('emails.newClient', ['user' => $user, 'password' => $password], function($mail) use ($user){
        $mail->to($user->email, $user->name);
        $mail->subject('['.$user->name.'] Your New Client Account');
    });

    return $user;
}