<?php

namespace App\Services;

use App\Mail\NewUser;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class UserService
{
    public function create($data): User
    {
        $password = $data['password'] ?? str_random(10);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($password),
            'is_admin' => $data['is_admin'] ?? false,
        ]);

        Mail::send(new NewUser($user, $password));

        return $user;
    }
}
