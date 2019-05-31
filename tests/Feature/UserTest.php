<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    /** @test */
    public function user_can_login()
    {
        $user = create(User::class);
        $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
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

    /** @test */
    public function user_can_sign_in_via_signed_url()
    {
        $user = create(User::class);
        $url = signedLoginUrl($user->id);
        $this->get($url)
            ->assertRedirect('update-password');

        $this->post('/logout');

        $url = signedLoginUrl($user->id, "clients");
        $this->get($url)
            ->assertRedirect('clients');
    }
}
