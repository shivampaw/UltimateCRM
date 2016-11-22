<?php

namespace App\Http\Controllers;

use App\User;
use App\Admin;
use App\Http\Requests;
use Illuminate\Http\Request;

class AdminsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('super_admin');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $admins = User::where('is_admin', 1)->get();
        return view('superAdminOnly.admins.index', compact('admins'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('superAdminOnly.admins.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'name'  => 'required',
            'email' => 'required|email|unique:clients|unique:users',
        ];
        $this->validate($request, $rules);
        $user = addUser($request, true);
        flash('Admin Created!');
        return redirect('/admins');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $admin = User::where('is_admin', 1)->findOrFail($id);
        return view('superAdminOnly.admins.edit', compact('admin'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $admin)
    {
        $admin->update($request->all());
        flash('Admin ('.$admin->name.') Updated!');
        return redirect('/admins');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::where('is_admin', 1)->findOrFail($id)->delete();
        flash('Admin Deleted!');
        return redirect('/admins');
    }
}
