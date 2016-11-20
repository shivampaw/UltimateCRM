<?php

namespace App\Http\Controllers;

use App\Client;
use App\Invoice;
use App\Project;
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
        $invoices = $client->invoices;
        return view("adminsOnly.invoices.index", compact('client', 'invoices'));
    }

    public function create(Client $client)
    {
        return view("adminsOnly.invoices.create", compact('client'));
    }

    public function store(Request $request, Client $client)
    {
        $rules = [
            'due_date'    => 'date|required',
        ];
        $this->validate($request, $rules);

        if ($request->project_id) {
            if (Project::where('id', $request->project_id)->where('client_id', $client->id)->count() !== 1) {
                flash("That Project ID does not exist for this user.", "danger");
                return back()->withInput();
            }
        }

        $invoice = new Invoice();
        $invoice->item_details = json_encode($request->item_details);
        $invoice->due_date = $request->due_date;
        $invoice->paid = false;
        $invoice->notes = $request->notes;
        $invoice->project_id = $request->project_id;
        $invoice->total = 0;
        foreach ($request->item_details as $item) {
            $invoice->total += $item['quantity'] * $item['price'];
        }
        $invoice->total = $invoice->total * 100;

        $client->addInvoice($invoice);

        Mail::send('emails.invoices.new', ['client' => $client, 'invoice' => $invoice], function ($mail) use ($client) {
            $mail->to($client->email, $client->full_name);
            $mail->subject('['.$client->full_name.'] New Invoice Generated');
        });

        flash("Invoice Created!");
        return redirect('/clients/'.$client->id)->withInput();
    }

    public function show(Client $client, Invoice $invoice)
    {
        return view("adminsOnly.invoices.show", compact('invoice'));
    }

    public function destroy(Client $client, Invoice $invoice)
    {
        $client->invoices()->findOrFail($invoice->id)->delete();
        flash("Invoice Deleted!");
        return redirect("/clients/".$client->id."/invoices");
    }
}
