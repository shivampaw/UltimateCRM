<?php

namespace App\Services;

use App\Mail\InvoicePaid;
use App\Mail\NewInvoice;
use App\Models\Client;
use App\Models\Invoice;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Stripe\Charge;
use Stripe\Error\Base;
use Stripe\Stripe;

class InvoiceService
{
    public function create(array $data): Invoice
    {
        /** @var Client $client */
        $client = Client::find($data['client_id']);

        $invoice = $this->getInvoiceData($data);

        $invoice = $this->persistAndEmail($client, $invoice);

        return $invoice;
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

            Mail::send(new InvoicePaid($invoice));

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

    public function getInvoiceData(array $data)
    {
        $invoice['project_id'] = $data['project_id'] ?? null;
        $invoice['notes'] = $data['notes'] ?? null;
        $invoice['due_date'] = $data['due_date'];

        $invoice = array_merge(
            $invoice,
            $this->normaliseInvoicePrices($data['item_details'], $data['discount'] ?? 0)
        );

        return $invoice;
    }

    /**
     * @param Client $client
     * @param array $invoice
     * @return array|false|\Illuminate\Database\Eloquent\Model
     */
    public function persistAndEmail(Client $client, array $invoice): Invoice
    {
        $invoice = $client->addInvoice(Invoice::make($invoice));

        Mail::send(new NewInvoice($client, $invoice));
        return $invoice;
    }
}
