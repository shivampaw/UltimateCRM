<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreInvoiceRequest;
use App\Models\Client;
use App\Models\Invoice;

class InvoicesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    public function index(Client $client)
    {
        $invoices = $client->invoices;
        $invoices->load('client');

        return view('adminsOnly.invoices.index', compact('client', 'invoices'));
    }

    public function create(Client $client)
    {
        return view('adminsOnly.invoices.create', compact('client'));
    }

    public function store(StoreInvoiceRequest $request)
    {
        $request->storeInvoice();

        flash('Invoice Created!');
    }

    public function show($client, Invoice $invoice)
    {
        $invoice->load('client');

        return view('adminsOnly.invoices.show', compact('invoice'));
    }

    public function destroy(Client $client, Invoice $invoice)
    {
        $client->invoices()->findOrFail($invoice->id)->delete();
        flash('Invoice Deleted!');

        return redirect('/clients/' . $client->id . '/invoices');
    }
}
