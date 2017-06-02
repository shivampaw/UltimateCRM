<?php

namespace Tests\Feature;

use App\Models\Client;
use App\Models\User;
use Faker\Factory;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class AdminTest extends TestCase
{

    use DatabaseMigrations;

    protected $admin;
    protected $faker;

    public function setUp()
    {
        parent::setUp();

        // Create super admin user so don't test it
        create(User::class, ['is_admin' => true]);

        $this->admin = create(User::class, [
            'is_admin' => true,
        ]);

        $this->faker = Factory::create();
    }

    /** @test */
    public function only_admins_can_create_client()
    {
        $client = [
            'name'    => $this->faker->name,
            'email'   => $this->faker->email,
            'number'  => $this->faker->phoneNumber,
            'address' => $this->faker->address,
        ];

        /**
         * Non auth tests (guests & non admins)
         */
        $this->post('/clients')
            ->assertRedirect('/login');

        $this->signIn()
            ->post('/clients')
            ->assertStatus(403);

        $this->assertDatabaseMissing('clients', $client);

        /**
         * Auth test (admins)
         */
        $this->signIn($this->admin)
            ->post('/clients', $client)
            ->assertRedirect('/clients');

        $this->assertDatabaseHas('clients', $client);
    }

    /** @test */
    public function only_admins_can_delete_client()
    {
        $client = create(Client::class);

        /**
         * Non auth tests (guests & non admins)
         */
        $this->delete('/clients/1')
            ->assertRedirect('/login');

        $this->signIn()
            ->delete('/clients/' . $client->id)
            ->assertStatus(403);

        $this->assertDatabaseHas('clients', $client->toArray());

        /**
         * Auth test (admins)
         */
        $this->signIn($this->admin)
            ->delete('/clients/' . $client->id)
            ->assertRedirect('/clients');

        $this->assertDatabaseMissing('clients', $client->toArray());
    }

}