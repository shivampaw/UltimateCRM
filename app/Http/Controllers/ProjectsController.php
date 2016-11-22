<?php

namespace App\Http\Controllers;

use App\Client;
use App\Project;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Mail;

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
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Client $client)
    {
        $this->validate($request, [
            'pdf'   => 'required|file',
            'title' => 'required'
        ]);

        $pdfExt = $request->pdf->extension();
        if (strtolower($pdfExt) === 'pdf') {
            $fileUrlPath= '/project_files/'.$client->id.'/';
            $fileUrlName = time().'.pdf';
            $path = $request->pdf->move(public_path().$fileUrlPath, $fileUrlName);

            $project = new Project();
            $project->title = $request->title;
            $project->pdf_path = $fileUrlPath.$fileUrlName;

            $client->addProject($project);

            Mail::send('emails.projects.new', ['client' => $client, 'project' => $project], function ($mail) use ($client, $project) {
                $mail->to($client->email, $client->full_name);
                $mail->attach(public_path().$project->pdf_path);
                $mail->subject('['.$client->full_name.'] New Project Created');
            });

            flash('The project has been created!');
            return redirect('/clients/'.$client->id.'/projects');
        } else {
            flash('The uploaded file must be a PDF', 'danger');
            return back();
        }
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
        return view('adminsOnly.projects.show', compact('project'));
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
