<?php

namespace Tests\Feature;

use App\Models\Client;
use App\Models\Invoice;
use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ProjectTest extends TestCase
{
    use DatabaseMigrations;

    protected $admin;

    public function setUp()
    {
        parent::setUp();
        $this->admin = create(User::class, [
            'is_admin' => 1,
        ]);
    }

    /** @test */
    public function admins_can_create_and_delete_projects()
    {
        /*
         * Create the client and the project.
         */
        $client = create(Client::class);

        $this->signIn($this->admin)
             ->post('/clients/' . $client->id . '/projects', [
                 'pdf'   => UploadedFile::fake()->create('project.pdf', 200),
                 'title' => 'Test Project',
             ])
             ->assertRedirect('/clients/' . $client->id . '/projects');

        $project = $client->projects()->first();
        /*
         * Make sure the project has been uploaded
         * then delete it and make sure it has been
         * deleted
         */
        Storage::assertExists($project->pdf_path);
        $this->delete('/clients/' . $client->id . '/projects/' . $project->id);

        $this->delete('/clients/' . $client->id . '/projects' . $project->id);
        Storage::assertMissing($project->pdf_path);
    }

    /** @test */
    public function client_can_view_all_their_projects()
    {
        $project = create(Project::class);

        $this->signIn($project->client->user)
             ->get('/projects')
             ->assertSee($project->title)
             ->assertStatus(200);

        $project->delete();
        Storage::assertMissing($project->pdf_path);
    }

    /** @test */
    public function client_can_view_a_single_project()
    {
        $project = create(Project::class);

        $this->signIn($project->client->user)
             ->get('/projects/' . $project->id)
             ->assertSee($project->title)
             ->assertStatus(200);

        $project->delete();
        Storage::assertMissing($project->pdf_path);
    }

    /** @test */
    public function admins_can_view_projects()
    {
        $project = create(Project::class);
        $client = $project->client;

        $this->signIn($this->admin)
             ->get('/clients/' . $client->id . '/projects/' . $project->id)
             ->assertSee($project->title)
             ->assertStatus(200);

        $project->delete();
        Storage::assertMissing($project->pdf_path);
    }

    /** @test */
    public function admins_can_add_invoices_to_projects()
    {
        $project = create(Project::class);
        $client = $project->client;
        $invoice = create(Invoice::class, [
            'project_id' => $project->id,
            'client_id'  => $client->id,
        ]);

        $this->signIn($this->admin)
             ->get('/clients/' . $client->id . '/projects/' . $project->id)
             ->assertSee('Invoice #' . $invoice->id);

        $project->delete();
        Storage::assertMissing($project->pdf_path);
    }

    /** @test */
    public function deleting_project_deletes_the_invoices()
    {
        $project = create(Project::class);
        $client = $project->client;
        create(Invoice::class, [
            'project_id' => $project->id,
            'client_id'  => $client->id,
        ], 5);

        $project->delete();
        $this->assertEquals(0, $client->invoices->count());
        Storage::assertMissing($project->pdf_path);
    }
}
