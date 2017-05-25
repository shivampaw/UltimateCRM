<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class RunInstall extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install the app';

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
        if (User::find(1)) {
            $this->error('The app seems to already be installed!');
            return false;
        }

        $this->info('Running this command will install this application. Please ensure you have setup your .env file with valid database and email settings.');



        $this->call('key:generate');
        $this->call('migrate');
        $this->call('storage:link');
        $this->call('super_admin:create');

        $this->info('Setup completed!');
    }
}
