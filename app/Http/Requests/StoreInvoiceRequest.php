<?php

namespace App\Http\Requests;

use App\Mail\NewInvoice;
use App\Models\Client;
use App\Services\InvoiceService;
use Illuminate\Database\Query\Builder;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;

class StoreInvoiceRequest extends FormRequest
{
    /**
     * @var Client
     */
    protected $client;

    /**
     * @var InvoiceService
     */
    protected $invoiceService;

    public function __construct(InvoiceService $invoiceService)
    {
        $this->invoiceService = $invoiceService;
        parent::__construct();
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
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
            'due_date' => 'date|required',
            'recurring_date' => 'required_if:recurringChecked,true',
            'recurring_due_date' => 'required_if:recurringChecked,true',
            'discount' => 'nullable|numeric',
            'project_id' => [
                'nullable',
                Rule::exists('projects', 'id')->where(function (Builder $query) {
                    $query->where('client_id', $this->route('client'));
                }),
            ],
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
            'project_id.exists' => 'The Project ID you entered does not exist for this user.',
            'due_date.required' => 'You must enter a Due Date.',
            'recurring_date.required_if' => 'You need to enter a Recurring Date if you want this invoice to recur.',
            'recurring_due_date.required_if' => 'You need to enter a Recurring Due Date if you want this invoice to recur.',
        ];
    }

    /**
     * Main method to be called from controller.
     *
     * @return \App\Models\Invoice
     */
    public function storeInvoice()
    {
        $invoiceData = $this->only(['due_date', 'notes', 'item_details', 'project_id', 'discount']);
        $invoiceData['client_id'] = $this->route('client');

        $invoice = $this->invoiceService->create($invoiceData);

        if ($this->recurringChecked) {
            $this->invoiceService->recurInvoice($invoice, $this->recurring_date, $this->recurring_due_date);
        }

        Mail::send(new NewInvoice($invoice->client, $invoice));

        return $invoice;
    }
}
