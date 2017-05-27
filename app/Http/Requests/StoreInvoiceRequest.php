<?php

namespace App\Http\Requests;

use Carbon\Carbon;
use App\Models\Invoice;
use App\Mail\NewInvoice;
use Illuminate\Validation\Rule;
use App\Models\RecurringInvoice;
use Illuminate\Support\Facades\Mail;
use Illuminate\Foundation\Http\FormRequest;

class StoreInvoiceRequest extends FormRequest
{
    protected $client;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $this->client = $this->route('client');
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'due_date'           => 'date|required',
            'recurring_date'     => 'required_if:recurringChecked,true',
            'recurring_due_date' => 'required_if:recurringChecked,true',
            'project_id'         => [
                'nullable',
                Rule::exists('projects', 'id')->where(function ($query) {
                    $query->where('client_id', $this->client->id);
                }),
            ]
        ];
    }

    /**
     * Get the validation rule messages that apply to
     * the request.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'project_id.exists'                 => 'The Project ID you entered does not exist for this user.',
            'due_date.required'                 => 'You must enter a Due Date.',
            'recurring_date.required_if'        => 'You need to enter a Recurring Date if you want this invoice to recur.',
            'recurring_due_date.required_if'    => 'You need to enter a Recurring Due Date if you want this invoice to recur.',
        ];
    }

    /**
     * Main method to be called from controller.
     *
     * @return App\Models\Invoice
     */
    public function storeInvoice()
    {
        $invoice = new Invoice();
        $invoice->item_details = json_encode($this->invoiceItems);
        $invoice->due_date = $this->due_date;
        $invoice->paid = false;
        $invoice->notes = $this->notes;
        $invoice->project_id = ($this->project_id) ?: null;
        $invoice->total = 0;
        foreach ($this->invoiceItems as $item) {
            $invoice->total += $item['quantity'] * $item['price'];
        }
        $invoice->total = $invoice->total * 100;

        $this->client->addInvoice($invoice);

        if ($this->recurringChecked) {
            $this->recurInvoice($invoice->id, $this->recurring_date, $this->recurring_due_date);
        }

        Mail::send(new NewInvoice($this->client, $invoice));

        return $invoice;
    }

    /**
     * This is run to create a recurring value for the invoice
     * specified.
     *
     * @return mixed
     */
    protected function recurInvoice($id, $date, $due_date)
    {
        $recurringInvoice = new RecurringInvoice();
        $recurringInvoice->invoice_id = $id;
        $recurringInvoice->last_run = Carbon::today();
        $recurringInvoice->next_run = Carbon::today()->addDays($date);
        $recurringInvoice->due_date = $due_date;
        $recurringInvoice->how_often = $date;
        $recurringInvoice->client_id = $this->client->id;
        $recurringInvoice->save();

        return $recurringInvoice;
    }
}
