<?php

namespace App\Console;

use App\Console\Commands\RunInstall;
use App\Console\Commands\CreateSuperAdmin;
use Illuminate\Console\Scheduling\Schedule;
use App\Console\Commands\ManageOverdueInvoices;
use App\Console\Commands\ManageRecurringInvoices;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        CreateSuperAdmin::class,
        ManageRecurringInvoices::class,
        ManageOverdueInvoices::class,
        RunInstall::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param \Illuminate\Console\Scheduling\Schedule $schedule
     *
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('invoices:recurring')->hourly();
        $schedule->command('invoices:overdue')->hourly();
    }
    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }
}
