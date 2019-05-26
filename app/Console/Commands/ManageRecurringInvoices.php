<?php

namespace App\Console\Commands;

use App\Mail\NewInvoice;
use App\Models\Invoice;
use App\Models\RecurringInvoice;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

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
        $toMakeInvoices = RecurringInvoice::whereDate('next_run', '=', Carbon::today())
            ->whereDate('last_run', '!=', Carbon::today())
            ->get();

        foreach ($toMakeInvoices as $completedInvoice) {
            $oldInvoice = Invoice::find($completedInvoice->invoice_id);
            $newInvoice = $oldInvoice->replicate();
            $newInvoice->paid = false;
            $newInvoice->paid_at = null;
            $newInvoice->stripe_charge_id = null;
            $newInvoice->due_date = Carbon::today()->addDays($completedInvoice->due_date);
            $newInvoice->save();

            $completedInvoice->last_run = Carbon::today();
            $completedInvoice->next_run = Carbon::today()->addDays($completedInvoice->how_often);
            $completedInvoice->save();

            Mail::send(new NewInvoice($newInvoice->client, $newInvoice));
        }
    }
}
