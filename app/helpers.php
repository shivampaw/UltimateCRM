<?php

use App\User;
use Illuminate\Http\Request;

function flash($message, $level = 'success')
{
	session()->flash('status', $message);
	session()->flash('status_level', $level);
}

function addUser(Request $request, $admin = false){
	$user = new User();
    $password = str_random(10);
    $user->name = $request->name;
    $user->password = bcrypt($password);
    $user->email = $request->email;
    $user->is_admin = $admin;
    $user->save();

    Mail::raw('Password for '.$user->email.' is '.$password, function ($mail) {
        $mail->to('shivam@shivampaw.com');    
    });

    return $user;
}