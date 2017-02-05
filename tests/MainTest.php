<?php

use App\Models\User;
use App\Http\Requests\StoreUserRequest;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class MainTest extends BrowserKitTest
{
    use DatabaseMigrations;

    /**
     * Add a user and then try to delete it.
     *
     * @return void
     */
    public function testAddAndDeleteUser()
    {
        fwrite(STDERR, print_r(PHP_EOL.'Starting Test', true));
        fwrite(STDERR, print_r(PHP_EOL.'Number of users: '.User::count(), true));
        
        $user = (new StoreUserRequest())->storeUser('phpunit', 'phpunit@example.com');
        fwrite(STDERR, print_r(PHP_EOL.'Added user with ID: '.$user->id, true));
       
        fwrite(STDERR, print_r(PHP_EOL.'Number of users: '.User::count(), true));

        $user->delete();
        fwrite(STDERR, print_r(PHP_EOL.'Deleted user with ID: '.$user->id, true));

        fwrite(STDERR, print_r(PHP_EOL.'Number of users: '.User::count(), true));
    }
}
