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
    	return $invoices;
    }

    public function showInvoice($id)
    {
    	$invoice = Auth::user()->client->invoices()->where('id', $id)->firstOrFail();
    	return $invoice;
    }

    public function payInvoice($id)
    {
    	$invoice = Auth::user()->client->invoices()->where('id', $id)->where('paid', false)->firstOrFail();
    	return view("clientsOnly.payInvoice", compact("invoice"));
    }

    public function paidInvoice(Request $request, $id)
    {
    	$client = Auth::user()->client;
		$invoice = $client->invoices()->where('id', $id)->firstOrFail();

       	Stripe::setApiKey(config('services.stripe.secret'));
       	if(!$client->stripe_customer_id):
	    	$customer = Customer::create([
	    		'email' => Auth::user()->email,
	    		'source' => $request->stripeToken
	    	]);
	    	$client->stripe_customer_id = $customer->id;
	    	$client->save();
	    endif;

	    try{
	    	$charge = Charge::create([
	    		'amount' => $invoice->total,
	    		'customer' => $client->stripe_customer_id,
	    		'currency' => 'gbp',
                'invoice' => $invoice->id,
                'receipt_email' => $client->email
	    	]);

	    	$invoice->stripe_charge_id = $charge->id;
			$invoice->paid = TRUE;
			$invoice->paid_at = Carbon::now();
			$invoice->save();

            Mail::send('emails.paidInvoice', ['client' => $client, 'invoice' => $invoice], function($mail) use ($client, $invoice){
                $mail->to($client->email, $client->full_name);
                $mail->subject('['.$client->full_name.'] Invoice #'.$invoice->id.' Has Been Paid For');
            });

			flash("Invoice Paid!");
			return redirect("/invoices/".$id);

		} catch(\Stripe\Error\Card $e) {
    		flash("Your credit card was declined! Please try a different card.", "danger");
    		return back();
    	}
    	flash("There was an error processing your payment. Please try again.", "danger");
    	return back();
    }
}
