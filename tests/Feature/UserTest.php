<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_login()
    {
        $user = create(User::class);
        $this->post('/login', [
            'email' => $user->email,
            'password' => 'secret',
        ]);
        $this->assertAuthenticated();
    }

    /** @test */
    public function user_can_logout()
    {
        $this->signIn();
        $this->post('/logout');
        $this->assertGuest();
    }
}
