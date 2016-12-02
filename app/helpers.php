<?php

function flash($message, $level = 'success')
{
    session()->flash('status', $message);
    session()->flash('status_level', $level);
}

function formatInvoiceTotal($number)
{
    return config('crm.currency').number_format($number/100, 2);
}
