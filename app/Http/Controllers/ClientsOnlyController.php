<?php

namespace App\Http\Controllers;

use App\Mail\ProjectAccepted;
use App\Models\Invoice;
use App\Services\InvoiceService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class ClientsOnlyController extends Controller
{

    /**
     * @var InvoiceService
     */
    protected $invoiceService;

    public function __construct(InvoiceService $invoiceService)
    {
        $this->invoiceService = $invoiceService;
        $this->middleware('auth');
        $this->middleware('client');
    }

    public function allInvoices()
    {
        $invoices = Auth::user()->client->invoices;

        return view('clientsOnly.invoices.index', compact('invoices'));
    }

    public function showInvoice($id)
    {
        $invoice = Auth::user()->client->invoices()->findOrFail($id);

        return view('clientsOnly.invoices.show', compact('invoice'));
    }

    public function payInvoice($id)
    {
        $invoice = Auth::user()->client->invoices()->where('paid', false)->findOrFail($id);

        return view('clientsOnly.invoices.pay', compact('invoice'));
    }

    public function attemptInvoiceCharge(Request $request, $id)
    {
        /** @var Invoice $invoice */
        $invoice = Invoice::findOrFail($id);

        $response = $this->invoiceService->attemptInvoiceCharge($invoice, $request->stripeToken);

        if ($response['success']) {
            $invoice->markAsPaid($response['stripe_charge_id']);

            flash('Invoice Paid!');
            return redirect('/invoices/' . $id);
        }

        flash($response['message'], 'danger');
        return back();
    }

    public function allProjects()
    {
        $projects = Auth::user()->client->projects;
        $projects->load('invoices');

        return view('clientsOnly.projects.index', compact('projects'));
    }

    public function showProject($id)
    {
        $project = Auth::user()->client->projects()->findOrFail($id);

        return view('clientsOnly.projects.show', compact('project'));
    }

    public function acceptProject($id)
    {
        $project = Auth::user()->client->projects()->findOrFail($id);
        $project->accepted = true;
        $project->accepted_at = Carbon::now();
        $project->save();

        Mail::send(new ProjectAccepted($project->client, $project));

        flash('Project Accepted');

        return redirect('/projects/' . $project->id);
    }
}
