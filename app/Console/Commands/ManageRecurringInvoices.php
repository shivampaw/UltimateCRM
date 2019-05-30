<?php

namespace App\Console\Commands;

use App\Models\RecurringInvoice;
use App\Services\RecurringInvoiceService;
use Carbon\Carbon;
use Illuminate\Console\Command;

class ManageRecurringInvoices extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'invoices:recurring';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Checks for any invoices that need to be recurred and manages them accordingly.';

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
        RecurringInvoice::where('next_run', Carbon::today())->get()->each(
            function (RecurringInvoice $recurringInvoice) {
                app(RecurringInvoiceService::class)->createInvoiceFromRecurringInvoice($recurringInvoice);
            }
        );

        return true;
    }
}
