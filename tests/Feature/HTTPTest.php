<?php

namespace Test\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class HTTPTest extends TestCase
{

	use DatabaseMigrations;

	/** @test */
	public function test_home_redirect()
	{
		$this->get('/')
			->assertStatus(302);
	}

	/** @test */
	public function test_login_page()
	{
		$this->get('/login')
			->assertStatus(200);
	}

	/** @test */
	public function test_register_404()
	{
		$this->get('/register')
			->assertStatus(404);
	}
}