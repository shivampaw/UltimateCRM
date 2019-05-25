<?php

namespace App\Http\Controllers;

use App\Mail\InvoicePaid;
use App\Mail\ProjectAccepted;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Stripe\Charge;
use Stripe\Error\Base;
use Stripe\Stripe;

class ClientsOnlyController extends Controller
{
    public function __construct()
    {
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

    public function paidInvoice(Request $request, $id)
    {
        $client = Auth::user()->client;
        $invoice = $client->invoices()->findOrFail($id);

        Stripe::setApiKey(config('services.stripe.secret'));

        try {
            $charge = Charge::create([
                'amount' => $invoice->total,
                'description' => config('app.name') . ' - Invoice #' . $invoice->id,
                'source' => $request->stripeToken,
                'currency' => (config('crm.currency')),
                'receipt_email' => $client->email,
            ]);

            $invoice->stripe_charge_id = $charge->id;
            $invoice->paid = true;
            $invoice->paid_at = Carbon::now();
            $invoice->save();

            Mail::send(new InvoicePaid($invoice));

            flash('Invoice Paid!');

            return redirect('/invoices/' . $id);
        } catch (Base $e) {
            flash($e->getMessage(), 'danger');

            return back();
        } catch (Exception $e) {
            flash('An unknown error occurred. Please try again.', 'danger');

            return back();
        }
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
