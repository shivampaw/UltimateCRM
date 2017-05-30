<?php

namespace Test\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class UserLoginTest extends TestCase
{
	use DatabaseMigrations;

	public function setUp()
	{
		parent::setUp();
		$this->admin = factory(User::class)->create([
				'is_admin'	=> true,
				'password'	=> bcrypt('secret'),
			]);
	}

	/** @test */
	public function test_login_user_form()
	{
		$this->get('/login')
			->assertStatus(200);
	}

	/** @test */
	public function test_login_user_form_submission()
	{
		$response = $this->post('/login', [
				'email'		=> $this->admin->email,
				'password'	=> 'secret',
			]);

		$this->followRedirects($response)
			->assertSee($this->admin->name);
	}
}