<?php

namespace App\Console\Commands;

use App\Mail\InvoiceOverdue;
use App\Models\Invoice;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class ManageOverdueInvoices extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'invoices:overdue';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sends email to client when an invoice goes overdue.';

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
        $overdueInvoices = Invoice::whereDate('due_date', '<', Carbon::today()->toDateString())
            ->where('paid', false)
            ->where('overdue_notification_sent', false)
            ->get();

        foreach ($overdueInvoices as $invoice) {
            Mail::send(new InvoiceOverdue($invoice->client, $invoice));
            $invoice->overdue_notification_sent = true;
            $invoice->save();
        }
    }
}
