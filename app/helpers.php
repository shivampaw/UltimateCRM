<?php

use Illuminate\Support\Facades\URL;
use Money\Currencies\ISOCurrencies;
use Money\Currency;
use Money\Formatter\DecimalMoneyFormatter;
use Money\Money;

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

    return $moneyFormatter->format($money);
}

function signedLoginUrl($user, $path = 'update-password')
{
    return URL::signedRoute('signedLogin', ['user' => $user, 'path' => $path]);
}
