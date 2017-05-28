<?php

use Money\Money;
use Money\Currency;
use Money\Currencies\ISOCurrencies;
use Money\Formatter\IntlMoneyFormatter;

function flash($message, $level = 'success')
{
    session()->flash('status', $message);
    session()->flash('status_level', $level);
}

function formatInvoiceTotal($number)
{
    $money = new Money($number, new Currency(config('crm.currency')));
	$currencies = new ISOCurrencies();

	$numberFormatter = new \NumberFormatter('en_GB', \NumberFormatter::CURRENCY);
	$moneyFormatter = new IntlMoneyFormatter($numberFormatter, $currencies);

	return $moneyFormatter->format($money);
}
