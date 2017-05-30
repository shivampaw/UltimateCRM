<?php

namespace Tests\Browser;

use Faker\Factory;
use App\Models\User;
use App\Mail\NewUser;
use App\Models\Client;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class AdminTest extends DuskTestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->faker = Factory::create();
        $this->admin = factory(User::class)->create([
                'is_admin'  => true,
                'password'  => bcrypt('secret'),
            ]);
    }

    public function test_admin_login()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                    ->type('email', $this->admin->email)
                    ->type('password', 'secret')
                    ->press('Login')
                    ->assertPathIs('/')
                    ->assertAuthenticated();
        });
    }

    public function test_super_admin_can_create_admins()
    {
        $this->browse(function (Browser $browser) {
            $admin = [
                'name'  => $this->faker->name,
                'email' => $this->faker->email,
            ];

            $browser->loginAs($this->admin)
                    ->visit('/admins/create')
                    ->type('name', $admin['name'])
                    ->type('email', $admin['email'])
                    ->press('Add Admin')
                    ->assertPathIs('/admins')
                    ->assertSee($admin['name'])
                    ->assertSee($admin['email'])
                    ->assertSee($this->admin->name)
                    ->assertSee($this->admin->email);
        });
    }

    public function test_admin_can_create_clients()
    {
        $this->browse(function (Browser $browser) {
            $admin = factory(User::class)->create([
                'is_admin'  => true
            ]);

            $client = [
                'name'    => $this->faker->name,
                'email'   => $this->faker->email,
                'number'  => $this->faker->phoneNumber,
                'address' => $this->faker->address,
            ];

            $browser->loginAs($admin)
                ->visit('/clients/create')
                ->type('name', $client['name'])
                ->type('email', $client['email'])
                ->type('number', $client['number'])
                ->type('address', $client['address'])
                ->press('Add Client')
                ->assertPathIs('/clients')
                ->assertSee($client['name']);
        });
    }
}
