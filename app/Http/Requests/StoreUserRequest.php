<?php

namespace App\Http\Requests;

use App\Models\User;
use App\Mail\NewUser;
use Illuminate\Support\Facades\Mail;
use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'   => 'required',
            'email'  => 'required|email|unique:clients|unique:users',
            'number' => 'nullable|numeric'
        ];
    }

    /**
     * Create a user and save it to databse.
     *
     * @return App\Models\User
     */
    public function storeUser($name = null, $email = null, $password = null, $admin = false)
    {
        $password = $password ?: str_random(10);
        $user = User::create([
            'name'     => ($name) ?: $this->name,
            'email'    => ($email) ?: $this->email,
            'password' => bcrypt($password),
            'is_admin' => $admin
        ]);

        if (config('app.env') !== 'testing') {
            Mail::send(new NewUser($user, $password));
        }

        return $user;
    }
}
