<?php

namespace Tests\Feature;

use App\Models\Client;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MiddlewareTest extends TestCase
{
    use RefreshDatabase;

    protected $superAdmin;

    protected $admin;

    protected $client;
    
    public function setUp()
    {
        parent::setUp();
        $this->superAdmin = create(User::class, ['is_admin' => true]);
        $this->admin = create(User::class, ['is_admin' => true]);
        $this->client = create(Client::class);
    }

    /** @test */
    public function only_super_admin_can_manage_admins()
    {
        $this->get('/admins')
            ->assertRedirect('/login');

        $this->signIn($this->client->user)
            ->get('/admins')
            ->assertStatus(403);

        $this->signIn($this->admin)
            ->get('/admins')
            ->assertStatus(403);

        $this->signIn($this->superAdmin)
            ->get('/admins')
            ->assertStatus(200);
    }

    /** @test */
    public function only_admins_can_manage_clients()
    {
        $this->get('/clients')
            ->assertRedirect('/login');

        $this->signIn($this->client->user)
            ->get('/clients')
            ->assertStatus(403);

        $this->signIn($this->admin)
            ->get('/clients')
            ->assertStatus(200);

        $this->signIn($this->superAdmin)
            ->get('/clients')
            ->assertStatus(200);
    }

    /** @test */
    public function only_admins_can_manage_client_projects()
    {
        $this->get('/clients/' . $this->client->id . '/projects')
            ->assertRedirect('/login');

        $this->signIn($this->client->user)
            ->get('/clients/' . $this->client->id . '/projects')
            ->assertStatus(403);

        $this->signIn($this->admin)
            ->get('/clients/' . $this->client->id . '/projects')
            ->assertStatus(200);

        $this->signIn($this->superAdmin)
            ->get('/clients/' . $this->client->id . '/projects')
            ->assertStatus(200);
    }

    /** @test */
    public function only_admins_can_manage_client_invoices()
    {
        $this->get('/clients/' . $this->client->id . '/invoices')
            ->assertRedirect('/login');

        $this->signIn($this->client->user)
            ->get('/clients/' . $this->client->id . '/invoices')
            ->assertStatus(403);

        $this->signIn($this->admin)
            ->get('/clients/' . $this->client->id . '/invoices')
            ->assertStatus(200);

        $this->signIn($this->superAdmin)
            ->get('/clients/' . $this->client->id . '/invoices')
            ->assertStatus(200);
    }

    /** @test */
    public function only_client_can_access_client_pages()
    {
        $this->get('/invoices')
            ->assertRedirect('/login');

        $this->signIn($this->client->user)
            ->get('/invoices')
            ->assertStatus(200);

        $this->signIn($this->admin)
            ->get('/invoices')
            ->assertStatus(403);

        $this->signIn($this->superAdmin)
            ->get('/invoices')
            ->assertStatus(403);
    }
}