<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Client;
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
        return view('adminsOnly.clients.index', compact('clients'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('adminsOnly.clients.create');
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
            'name'   => 'required',
            'email'  => 'required|email|unique:clients|unique:users',
            'number' => 'numeric'
        ];
        $this->validate($request, $rules);

        $user = addUser($request);
        $client = new Client($request->all());
        $user->client()->save($client);

        flash('Client Created!');
        return redirect('/clients');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Client $client
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Client $client)
    {
        return view('adminsOnly.clients.show', compact('client'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Client $client
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Client $client)
    {
        return view('adminsOnly.clients.edit', compact('client'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Client       $client
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Client $client)
    {
        $client->update($request->all());
        $client->user->update($request->all());

        flash('Client Updated!');
        return redirect('/clients/'.$client->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Client $client
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Client $client)
    {
        $client->delete();
        flash('Client Deleted!');
        return redirect('/clients');
    }
}
