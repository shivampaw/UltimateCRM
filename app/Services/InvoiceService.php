<?php

namespace App\Services;

use App\Models\Client;
use App\Models\Invoice;
use App\Models\RecurringInvoice;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;
use Stripe\Charge;
use Stripe\Error\Base;
use Stripe\Stripe;

class InvoiceService
{
    public function create(array $data): Invoice
    {
        /** @var Client $client */
        $client = Client::find($data['client_id']);

        $data = $this->normaliseInvoiceData($data);

        return $client->addInvoice(Invoice::make($data));
    }

    public function recurInvoice(Invoice $invoice, int $howOften, int $dueDate)
    {
        return RecurringInvoice::create([
            'invoice_id' => $invoice->id,
            'last_run' => Carbon::today(),
            'next_run' => Carbon::today()->addDays($howOften),
            'due_date' => $dueDate,
            'how_often' => $howOften,
            'client_id' => $invoice->client->id
        ]);
    }

    public function isInvoiceRecurring(Invoice $invoice)
    {

    }

    public function removeInvoiceRecurrence(Invoice $invoice)
    {

    }

    public function attemptInvoiceCharge(Invoice $invoice, string $stripeToken)
    {
        $client = Auth::user()->client;

        Stripe::setApiKey(config('services.stripe.secret'));

        try {
            $charge = Charge::create([
                'amount' => $invoice->total,
                'description' => config('app.name') . ' - Invoice #' . $invoice->id,
                'source' => $stripeToken,
                'currency' => (config('crm.currency')),
                'receipt_email' => $client->email,
            ]);

            return [
                'success' => true,
                'stripe_charge_id' => $charge->id
            ];

        } catch (Base $e) {
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => 'An unknown error occurred. Please try again.'
            ];
        }

    }

    private function normaliseInvoiceData(array $data)
    {
        $data['paid'] = false;
        $data['overdue_notification_sent'] = false;
        $data['total'] = 0;
        $data['discount'] = $data['discount'] ?? 0;

        $tempItemDetails = [];
        foreach ($data['item_details'] as $item) {
            $data['total'] += $item['quantity'] * $item['price'];
            $item['price'] = getMinorUnit($item['price']);
            $tempItemDetails[] = $item;
        }
        $data['item_details'] = json_encode($tempItemDetails);

        $data['total'] -= $data['discount'];
        $data['discount'] = getMinorUnit($data['discount']);

        $data['total'] = getMinorUnit($data['total']);

        return $data;
    }
}
