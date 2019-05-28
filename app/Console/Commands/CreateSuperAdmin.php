<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Services\UserService;
use Illuminate\Console\Command;

class CreateSuperAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'super_admin:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This will help create your first user (the super admin) on a fresh install.';

    /**
     * @var UserService
     */
    protected $userService;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if (User::find(1)) {
            $this->error('The Super Admin (user with ID 1) already exists!');

            return false;
        }

        $this->info('Time to create your super admin account.');

        $name = $this->ask('What is the full name for the super admin?');
        $email = $this->ask('What is the email for the super admin?');
        $password = $this->secret('What is the password for the super admin? (You won\'t be able to see what you are typing)');

        $this->userService->create([
            'name' => $name,
            'email' => $email,
            'password' => $password,
            'is_admin' => true
        ]);

        $this->info('Super Admin created.');
        return true;
    }
}
