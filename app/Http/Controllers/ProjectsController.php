<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProjectRequest;
use App\Models\Client;
use App\Models\Project;

class ProjectsController extends Controller
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
    public function index(Client $client)
    {
        $projects = $client->projects;
        $projects->load('invoices');

        return view('adminsOnly.projects.index', compact('client', 'projects'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Client $client)
    {
        return view('adminsOnly.projects.create', compact('client'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreProjectRequest|\Illuminate\Http\Request $request
     * @param Client                                       $client
     *
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProjectRequest $request, Client $client)
    {
        $request->storeProject();

        flash('The project has been created!');

        return redirect('/clients/'.$client->id.'/projects');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Client $client, Project $project)
    {
        $project->load('invoices');

        return view('adminsOnly.projects.show', compact(['client', 'project']));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Client $client, Project $project)
    {
        $client->projects()->findOrFail($project->id)->delete();

        flash('Project Deleted!');

        return redirect('/clients/'.$client->id.'/projects');
    }
}
