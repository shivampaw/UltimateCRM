<?php

use App\Models\User;
use App\Http\Requests\StoreUserRequest;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class MainTest extends BrowserKitTest
{
    use DatabaseMigrations;

    /** @test */
    public function add_and_delete_user()
    {
        $user = (new StoreUserRequest())->storeUser('phpunit', 'phpunit@example.org');
        $user->delete();
    }
}
