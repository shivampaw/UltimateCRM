<?php

namespace App\Http\Controllers;

use App\Client;
use App\Invoice;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class InvoicesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    public function index(Client $client)
    {
    	return $client->load('invoices');
    }

    public function create(Client $client)
    {
    	return view("invoices.create", compact('client'));
    }

    public function store(Request $request, Client $client)
    {
    	$rules = [
            'due_date'	=> 'date|required',
        ];
        $this->validate($request, $rules);

    	$invoice = new Invoice();
    	$invoice->item_details = json_encode($request->item_details);
    	$invoice->due_date = $request->due_date;
    	$invoice->paid = FALSE;
    	$invoice->notes = $request->notes;
        $invoice->total = 0;
        foreach($request->item_details as $item){
            $invoice->total += $item['quantity'] * $item['price'];
        }
        $invoice->total = $invoice->total * 100;

    	$client->addInvoice($invoice);

        Mail::send('emails.newInvoice', ['client' => $client, 'invoice' => $invoice], function($mail) use ($client){
            $mail->to($client->email, $client->full_name);
            $mail->subject('['.$client->full_name.'] New Invoice Generated');
        });

    	flash("Invoice Created!");
        return redirect('/clients/'.$client->id)->withInput();
    }

    public function show(Client $client, Invoice $invoice)
    {
        return $invoice;
    }

    public function destroy(Client $client, Invoice $invoice)
    {
        return $client->invoices()->findOrFail($invoice->id);
    }
}
