<?php

namespace App\Services;

use App\Models\Client;
use App\Models\RecurringInvoice;
use Carbon\Carbon;

class RecurringInvoiceService
{
    public function create(array $data): RecurringInvoice
    {
        /** @var Client $client */
        $client = Client::find($data['client_id']);

        $invoice = $this->getRecurringInvoiceData($data);

        return $client->addRecurringInvoice(RecurringInvoice::make($invoice));
    }

    public function getRecurringInvoiceData($data)
    {
        $invoice['project_id'] = $data['project_id'] ?? null;
        $invoice['notes'] = $data['notes'] ?? null;
        $invoice['how_often'] = $data['how_often'];
        $invoice['due_date'] = $data['due_date'];
        $invoice['next_run'] = $data['next_run'] ?? $this->calculateNextRun($invoice['how_often']);

        $invoice = array_merge(
            $invoice,
            app(InvoiceService::class)->normaliseInvoicePrices($data['item_details'], $data['discount'] ?? 0)
        );

        return $invoice;
    }

    /**
     * @param $how_often
     * @throws \Exception
     */
    public function calculateNextRun($how_often)
    {
        switch ($how_often) {
            case 'Every day':
                $carbonString = "+1 day";
                break;
            case 'Every week':
                $carbonString = "+1 week";
                break;
            case 'Every two weeks':
                $carbonString = "+2 weeks";
                break;
            case 'Every month':
                $carbonString = "+1 month";
                break;
            case 'Every six months':
                $carbonString = "+6 months";
                break;
            case 'Every year':
                $carbonString = "+1 year";
                break;
            default:
                throw new \InvalidArgumentException("Invalid How Often Value");
        }

        return Carbon::parse($carbonString)->setTime(0, 0);
    }

    public function createInvoiceFromRecurringInvoice(RecurringInvoice $recurringInvoice)
    {
        app(InvoiceService::class)->persistAndEmail($recurringInvoice->client, $this->setDueDate($recurringInvoice));

        $recurringInvoice->fresh()->update([
            'next_run' => $this->calculateNextRun($recurringInvoice->how_often)
        ]);

        return true;
    }

    private function setDueDate(RecurringInvoice $recurringInvoice)
    {
        $recurringInvoice->due_date = Carbon::today()->addDays($recurringInvoice->due_date);

        return $recurringInvoice->toArray();
    }
}
