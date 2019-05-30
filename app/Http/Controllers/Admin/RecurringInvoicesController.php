<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRecurringInvoiceRequest;
use App\Models\Client;
use App\Models\RecurringInvoice;
use App\Services\RecurringInvoiceService;

class RecurringInvoicesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    public function index(Client $client)
    {
        $recurringInvoices = $client->recurringInvoices;

        return view("adminsOnly.recurring-invoices.index", compact('recurringInvoices', 'client'));
    }

    public function show(Client $client, RecurringInvoice $recurringInvoice)
    {
        abort_if($recurringInvoice->client->isNot($client), 404);

        return ($recurringInvoice);
    }

    public function create(Client $client)
    {
        return view("adminsOnly.recurring-invoices.create", compact('client'));
    }

    public function store($client, StoreRecurringInvoiceRequest $request)
    {
        $data = $request->validated();
        $data['client_id'] = $client;

        app(RecurringInvoiceService::class)->create($data);

        flash('Recurring Invoice Created');

        if ($request->expectsJson()) {
            return [
                'success' => true,
                'redirect_url' => url('/clients/' . $client . '/recurring-invoices')
            ];
        }

        return redirect('/clients/' . $client . '/recurring-invoices');
    }
}
