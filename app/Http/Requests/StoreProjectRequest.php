<?php

namespace App\Http\Requests;

use App\Models\Project;
use App\Mail\NewProject;
use Illuminate\Support\Facades\Mail;
use Illuminate\Foundation\Http\FormRequest;

class StoreProjectRequest extends FormRequest
{
    protected $client;
   
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
            'pdf'   => 'required|file|mimes:pdf',
            'title' => 'required'
        ];
    }

    /**
     * Get the validation rule messages that apply to
     * the request.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'pdf.*'          => 'You must upload a PDF with the project details.',
            'title.required' => 'You must enter a project title',
        ];
    }

    /**
     * Main method to be called to initiate save
     * for project.
     *
     * @return App\Models\Project
     */
    public function storeProject()
    {
        $this->client = $this->route('client');
        $project = new Project();
        $project->title = $this->title;
        $project->pdf_path = $this->storeUploadedFile();

        $this->client->addProject($project);
        Mail::send(new NewProject($this->client, $project));

        return $project;
    }

    /**
     * Stores the uploaded PDF to the /project_files
     * directory.
     *
     * @return string
     */
    protected function storeUploadedFile()
    {
        $fileUrlPath= '/project_files/'.$this->client->id.'/';
        $fileUrlName = time().'.pdf';
        $this->pdf->move(public_path().$fileUrlPath, $fileUrlName);

        return $fileUrlPath.$fileUrlName;
    }
}
