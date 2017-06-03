<?php

namespace Tests\Unit;

use App\Models\Client;
use App\Models\Project;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ProjectTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function projects_belong_to_a_client()
    {
        $project = create(Project::class);
        $this->assertInstanceOf(Client::class, $project->client);
    }
}
