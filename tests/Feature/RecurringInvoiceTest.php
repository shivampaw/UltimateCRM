<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\RecurringInvoice;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RecurringInvoiceTest extends TestCase
{

    use RefreshDatabase;

    protected function setUp()
    {
        parent::setUp();
        $this->admin = create(User::class, ['is_admin' => true]);
        $this->project = create(Project::class);
        $this->client = $this->project->client;
    }

    /** @test */
    public function admin_can_create_recurring_invoice_for_client()
    {
        $data = [
            'discount' => 10.00,
            'notes' => 'Lorem Ipsum Dalor Et.',
            'project_id' => 1,
            'how_often' => 'Every month',
            'due_date' => 14,
            'item_details' => [
                [
                    'description' => 'Test Invoice Item',
                    'quantity' => 4,
                    'price' => 302.20,
                ]
            ],
            'next_run' => Carbon::today()
        ];

        $this->signIn($this->admin);

        $this->post('/clients/1/recurring-invoices', $data)
            ->assertRedirect('/clients/1/recurring-invoices');

        $this->assertCount(1, RecurringInvoice::all());
    }

    /** @test */
    public function admins_can_view_all_client_recurring_invoices()
    {
        $recurringInvoice = create(RecurringInvoice::class, ['client_id' => 1]);

        $this->signIn($this->admin)
            ->get('/clients/1/recurring-invoices')
            ->assertSee($recurringInvoice->next_run->toFormattedDateString())
            ->assertSee(formatInvoiceTotal($recurringInvoice->total));
    }

    /** @test */
    public function admins_can_view_single_client_recurring_invoice()
    {
        $recurringInvoice = create(RecurringInvoice::class, ['client_id' => 1]);

        $this->signIn($this->admin)
            ->get('/clients/1/recurring-invoices/1')
            ->assertSee($recurringInvoice->next_run->toFormattedDateString())
            ->assertSee($recurringInvoice->due_date)
            ->assertSee($recurringInvoice->how_often)
            ->assertSee(formatInvoiceTotal($recurringInvoice->discount))
            ->assertSee(formatInvoiceTotal($recurringInvoice->total));
    }

}
