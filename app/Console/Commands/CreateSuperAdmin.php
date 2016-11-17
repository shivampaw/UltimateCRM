<?php

namespace App\Console\Commands;

use App\User;
use Illuminate\Console\Command;

class CreateSuperAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'super_admin:create
                            {name : The name of the Super Admin}
                            {email : The email of the Super Admin}
                            {password : The password for the Super Admin}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This will help create your first user (the super admin) on a fresh install.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $name = $this->argument('name');
        $email = $this->argument('email');
        $password = $this->argument('password');

        if(User::find(1)){
            $this->error("The Super Admin (user with ID 1) already exists!");
            return false;
        }

        User::create([
                'email' => $email,
                'name' => $name,
                'password' => bcrypt($password),
                'is_admin' => TRUE
            ]);
    }
}
