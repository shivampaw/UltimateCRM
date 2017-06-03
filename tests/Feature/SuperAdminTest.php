<?php

namespace Tests\Feature;

use App\Models\User;
use Faker\Factory;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class SuperAdminTest extends TestCase
{
    use DatabaseMigrations;

    protected $admin;

    protected $faker;

    public function setUp()
    {
        parent::setUp();

        $this->admin = create(User::class, [
            'is_admin' => true,
        ]);

        $this->faker = Factory::create();
    }

    /** @test */
    public function only_super_admin_can_create_admin()
    {
        $admin = [
            'name'  => $this->faker->name,
            'email' => $this->faker->safeEmail,
        ];

        $this->signIn($this->admin)
             ->post('/admins', $admin)
             ->assertRedirect('/admins');

        $this->assertDatabaseHas('users', $admin);
    }

    /** @test */
    public function only_super_admin_can_delete_admin()
    {
        $admin = create(User::class, [
            'is_admin' => true,
        ]);

        $this->signIn($this->admin)
             ->delete('/admins/' . $admin->id)
             ->assertRedirect('/admins');

        $this->assertDatabaseMissing('users', $admin->toArray());
    }
}
