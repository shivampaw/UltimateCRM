<?php

use Brick\Money\Money;
use Illuminate\Support\Facades\URL;

function flash($message, $level = 'success')
{
    session()->flash('status', $message);
    session()->flash('status_level', $level);
}

/**
 * @param $number
 * @throws \Brick\Money\Exception\UnknownCurrencyException
 */
function formatInvoiceTotal($number)
{
    return Money::ofMinor($number, config('crm.currency'));
}

function signedLoginUrl($user, $path = 'update-password')
{
    return URL::signedRoute('signedLogin', ['user' => $user, 'path' => $path]);
}
