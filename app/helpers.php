<?php

use Money\Money;
use Money\Currency;
use Money\Currencies\ISOCurrencies;
use Money\Formatter\DecimalMoneyFormatter;

function flash($message, $level = 'success')
{
    session()->flash('status', $message);
    session()->flash('status_level', $level);
}

function formatInvoiceTotal($number)
{
    $money = new Money($number, new Currency(config('crm.currency')));
	$currencies = new ISOCurrencies();
	$moneyFormatter = new DecimalMoneyFormatter($currencies);

	return config('crm.currency').' '.$moneyFormatter->format($money);
}
