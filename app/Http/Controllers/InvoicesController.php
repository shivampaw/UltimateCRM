<?php

namespace App\Http\Controllers;

use App\Client;
use App\Invoice;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

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
            'item_details.0.description' => 'required',
            'item_details.0.price' => 'required',
            'item_details.0.quantity' => 'required',
            'due_date'	=> 'date|required',
        ];
        $messages = [
        	'item_details.0.description.required' => 'You need to have at least one product description',
        	'item_details.0.quantity.required' => 'You need to have at least one product quantity',
        	'item_details.0.price.required' => 'You need to have at least one product price'
        ];
        $this->validate($request, $rules, $messages);

    	$invoice = new Invoice();
    	$invoice->item_details = json_encode($request->item_details);
    	$invoice->due_date = $request->due_date;
    	$invoice->paid = FALSE;
    	$invoice->notes = $request->notes;
    	$client->addInvoice($invoice);

    	flash("Invoice Created!");
        return redirect('/clients/'.$client->id);
    }
}
