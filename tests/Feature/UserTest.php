<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class UserTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function user_can_login()
    {
        $user = create(User::class);
        $this->post('/login', [
            'email'    => $user->email,
            'password' => 'secret',
        ]);

        $this->seeIsAuthenticated();
    }

    /** @test */
    public function user_can_logout()
    {
        $this->signIn();
        $this->post('/logout');
        $this->dontSeeIsAuthenticated();
    }
}
