<?php

namespace Tests\Feature;

use App\Mail\NewUser;
use App\Models\Client;
use App\Models\User;
use Faker\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class AdminTest extends TestCase
{
    use RefreshDatabase;

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
    public function admins_can_create_client()
    {
        $client = [
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'number' => $this->faker->phoneNumber,
            'address' => $this->faker->address,
        ];

        Mail::fake();

        $this->signIn($this->admin)
            ->post('/clients', $client)
            ->assertRedirect('/clients');

        Mail::assertSent(NewUser::class, function (NewUser $mail) use ($client) {
            $mail->build();
            return $mail->hasTo($client['email']);
        });

        $this->assertDatabaseHas('clients', $client);
    }

    /** @test */
    public function admins_can_delete_client()
    {
        $client = create(Client::class);

        $this->signIn($this->admin)
            ->delete('/clients/' . $client->id)
            ->assertRedirect('/clients');

        $this->assertDatabaseMissing('clients', $client->toArray());
    }
}
