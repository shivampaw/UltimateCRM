<div class="row">
    @forelse($invoices as $invoice)
        <div class="col-lg-4 col-sm-6 mt-3">
            <div class="card client text-center">
                <div class="card-body">
                    @if($invoice instanceof App\Models\Invoice)
                        @include("layouts.invoices.index.invoice")
                    @else
                        @include("layouts.invoices.index.recurring-invoice")
                    @endif
                </div>
            </div>
        </div>
    @empty
        <div class="col-12 mt-3">
            <p>There are currently no invoices.</p>
        </div>
    @endforelse
</div>
