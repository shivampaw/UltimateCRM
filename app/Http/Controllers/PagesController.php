<?php

namespace app\Http\Controllers;

use App\User;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class PagesController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('dashboard.home', ['user' => Auth::user()]);
    }

    public function showUpdatePasswordForm()
    {
        return view('dashboard.updatePassword');
    }

    public function updatePassword(Request $request)
    {
        $rules = [
            'currentPassword' => 'required',
            'password' => 'required|same:confirmPassword|min:6',
            'confirmPassword' => 'required'
        ];
        $validator = Validator::make($request->all(), $rules);

        $validator->after(function ($validator) use ($request) {
            $check = Auth::validate([
                'email'    => Auth::user()->email,
                'password' => $request->currentPassword
            ]);
            if (!$check):
                $validator->errors()->add('current_password', 'Your current password is incorrect.');
            endif;
        });

        if ($validator->passes()) {
            Auth::user()->password = Hash::make($request->password);
            Auth::user()->save();
            flash("Your password was updated!");
            return back();
        }
        return back()->withErrors($validator);
    }
}
