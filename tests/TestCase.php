<?php
namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Tests\Traits\CreatesApplication;

abstract class TestCase extends BaseTestCase
{

    use CreatesApplication;

    protected function signIn($user = null)
    {
        $user = $user ?: create(User::class);
        $this->actingAs($user);

        return $this;
    }
}
