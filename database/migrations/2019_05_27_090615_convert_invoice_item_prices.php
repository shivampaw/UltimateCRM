<?php

use Brick\Money\Money;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class ConvertInvoiceItemPrices extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $rows = DB::table('invoices')->get();
        foreach ($rows as $row) {
            $items = json_decode($row->item_details);
            foreach ($items as $item) {
                $money = Money::of($item->price, config('crm.currency'));
                $item->price = $money->getMinorAmount()->toInt();
            }
            $items = json_encode($items);

            DB::table('invoices')
                ->where('id', $row->id)
                ->update([
                    'item_details' => $items
                ]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
