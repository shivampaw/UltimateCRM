<?php
namespace Tests;

use Tests\Traits\CreatesApplication;
use Illuminate\Foundation\Testing\TestResponse;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
	use CreatesApplication;

	protected function followRedirects(TestResponse $response)
	{
		while ($response->isRedirect()) {
			$response = $this->get($response->headers->get('Location'));
		}

		return $response;
	}
}
