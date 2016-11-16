<?php

function flash($message, $level = 'success')
{
	session()->flash('status', $message);
	session()->flash('status_level', $level);
}