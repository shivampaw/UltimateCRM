<?php

use App\Models\User;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class MainTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * Test the homepage returns ok.
     *
     * @return void
     */
    public function testHomePageResponse()
    {
        $this->visit('/')
             ->assertResponseOk();
    }

    /**
     * Add a user and then try to delete it.
     *
     * @return void
     */
    public function testAddAndDeleteUser()
    {
        fwrite(STDERR, print_r(PHP_EOL.'Starting Test', true));
        fwrite(STDERR, print_r(PHP_EOL.'Number of users: '.User::count(), true));
        $user = new User();
        $password = str_random(10);
        $user->name = 'PHPUnitTest';
        $user->password = bcrypt($password);
        $user->email = 'PHPUnitTest@PHPUnitTest.com';
        $user->is_admin = true;
        $user->save();
        fwrite(STDERR, print_r(PHP_EOL.'Added user with ID: '.$user->id, true));
        fwrite(STDERR, print_r(PHP_EOL.'Number of users: '.User::count(), true));
        $user->delete();
        fwrite(STDERR, print_r(PHP_EOL.'Deleted user with ID: '.$user->id, true));
        fwrite(STDERR, print_r(PHP_EOL.'Number of users: '.User::count(), true));
    }
}
