<?php

namespace App\Http\Controllers;

use App\User;
use App\Client;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClientsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clients = Client::all();
        return view("clients.index", compact('clients'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("clients.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'full_name' => 'required',
            'email' => 'required|email|unique:clients|unique:users',
            'number' => 'numeric'
        ];
        $this->validate($request, $rules);

        $user = new User();
        $password = str_random(10);
        $user->name = $request->full_name;
        $user->password = bcrypt($password);
        $user->email = $request->email;
        $user->save();

        $client = new Client();
        $client->full_name = $request->full_name;
        $client->email = $request->email;
        $client->number = $request->number;
        $client->address = $request->address;
        $client->user_id = $user->id;
        $client->save();

        flash("Client Created!");
        return redirect('/clients');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Client $client)
    {
        $client->load('invoices');
        return view("clients.show", compact('client'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Client $client)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Client $client)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Client $client)
    {
        $client->delete();
        flash("Client Deleted!");
        return redirect('/clients');
    }
}
