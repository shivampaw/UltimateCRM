<?php

namespace App\Http\Controllers;

use App\Invoice;
use Carbon\Carbon;
use Stripe\Charge;
use Stripe\Stripe;
use Stripe\Customer;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class ClientsOnlyController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('client');
    }

    public function allInvoices()
    {
        $invoices =  Auth::user()->client->invoices;
        return view("clientsOnly.invoices.index", compact('invoices'));
    }

    public function showInvoice($id)
    {
        $invoice = Auth::user()->client->invoices()->findOrFail($id);
        return view("clientsOnly.invoices.show", compact('invoice'));
    }

    public function payInvoice($id)
    {
        $invoice = Auth::user()->client->invoices()->where('paid', false)->findOrFail($id);
        return view("clientsOnly.invoices.pay", compact("invoice"));
    }

    public function paidInvoice(Request $request, $id)
    {
        $client = Auth::user()->client;
        $invoice = $client->invoices()->findOrFail($id);

        Stripe::setApiKey(config('services.stripe.secret'));

        try {
            $charge = Charge::create([
                'amount' => $invoice->total,
                'description' => config('app.name') . ' - Invoice #'.$invoice->id,
                'source' => $request->stripeToken,
                'currency' => 'gbp',
                'receipt_email' => $client->email
            ]);

            $invoice->stripe_charge_id = $charge->id;
            $invoice->paid = true;
            $invoice->paid_at = Carbon::now();
            $invoice->save();

            Mail::send('emails.invoices.paid', ['client' => $client, 'invoice' => $invoice], function ($mail) use ($client, $invoice) {
                $mail->to($client->email, $client->full_name);
                $mail->subject('['.$client->full_name.'] Invoice #'.$invoice->id.' Has Been Paid For');
            });

            flash("Invoice Paid!");
            return redirect("/invoices/".$id);
        } catch (\Stripe\Error\Card $e) {
            flash("Your credit card was declined! Please try a different card.", "danger");
            return back();
        }
        flash("There was an error processing your payment. Please try again.", "danger");
        return back();
    }


    public function allProjects()
    {
        $projects =  Auth::user()->client->projects;
        return view("clientsOnly.projects.index", compact('projects'));
    }

    public function showProject($id)
    {
        $project = Auth::user()->client->projects()->findOrFail($id);
        return view("clientsOnly.projects.show", compact('project'));
    }

    public function acceptProject($id)
    {
        $project = Auth::user()->client->projects()->findOrFail($id);
        $project->accepted = true;
        $project->accepted_at = Carbon::now();
        $project->save();

        flash("Project Accepted");
        return redirect("/projects/".$project->id);
    }
}
