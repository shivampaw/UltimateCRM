<?php

use Brick\Money\Money;
use Illuminate\Support\Facades\URL;

/**
 * Set a flash message in the session that
 * is displayed on the front end.
 *
 * @param $message
 * @param string $level
 */
function flash($message, $level = 'success')
{
    session()->flash('status', $message);
    session()->flash('status_level', $level);
}

/**
 * Take a minor unit from a currency and format it
 * to the standard currency format.
 *
 * @param $number
 * @return string
 * @throws \Brick\Money\Exception\UnknownCurrencyException
 */
function formatInvoiceTotal($number)
{
    return Money::ofMinor($number, config('crm.currency'));
}

/**
 * Take a standard currency value and convert it
 * to the minor unit for that currency.
 *
 * @param $number
 * @return int
 */
function getMinorUnit($number)
{
    return Money::of($number, config('crm.currency'))->getMinorAmount()->toInt();
}

/**
 * Get a signed URL that logs in a given user
 * and redirects to the given path.
 *
 * @param $user
 * @param string $path
 * @return string
 */
function signedLoginUrl($user, $path = 'update-password')
{
    return URL::signedRoute('signedLogin', ['user' => $user, 'path' => $path]);
}
