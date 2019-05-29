<?php

namespace App\Services;

use App\Models\Client;
use App\Models\Invoice;
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

        $invoice['project_id'] = $data['project_id'] ?? null;
        $invoice['notes'] = $data['notes'] ?? null;
        $invoice['due_date'] = $data['due_date'];

        $invoice = array_merge(
            $invoice,
            $this->normaliseInvoicePrices($data['item_details'], $data['discount'] ?? 0)
        );

        return $client->addInvoice(Invoice::make($invoice));
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

    public function normaliseInvoicePrices(array $items, $discount)
    {
        $data['total'] = 0;
        $data['discount'] = $discount;
        $data['item_details'] = [];

        foreach ($items as $item) {
            $data['total'] += $item['quantity'] * $item['price'];
            $item['price'] = getMinorUnit($item['price']);
            $data['item_details'][] = $item;
        }

        $data['item_details'] = json_encode($data['item_details']);

        $data['total'] -= $data['discount'];

        $data['discount'] = getMinorUnit($data['discount']);
        $data['total'] = getMinorUnit($data['total']);

        return $data;
    }
}
