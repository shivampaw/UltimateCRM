<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Models\Client;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ClientTest extends TestCase
{
	use DatabaseMigrations;
	protected $client;

	public function setUp()
	{
		parent::setUp();
		$this->client = factory(Client::class)->create();
	}

	/** @test */
	public function test_client_has_user()
	{
		$this->assertInstanceOf(User::class, $this->client->user);
	}

	/** @test */
	public function test_client_is_client()
	{
		$this->assertInstanceOf(Client::class, $this->client);
	}
}