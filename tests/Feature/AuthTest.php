<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */

    public function test_login()
    {
        $response = $this->post('/api/auth/login', [
            'username' => 'tama',
            'password' => 'rahasia123'
        ]);
        $json = $response->decodeResponseJson();
        $this->assertIsArray($json['data']);
        $this->assertEquals(true, is_string($json['access_token']));
        $response->assertStatus(200);
    }
    public function test_register()
    {
        $response = $this->post('/api/auth/register', [
            'username' => 'unittest2',
            'email' => 'unittest2@gmail.com',
            'password' => 'rahasia123',
            'phone' => '085771434475'
        ]);
        $json = $response->decodeResponseJson();
        $this->assertIsArray($json['data']);
        $this->assertEquals("user created", $json['message']);
        $this->assertEquals(200, $json['statusCode']);
        $response->assertStatus(200);
    }
    public function test_logout()
    {
        $this->Test_login();
        $response = $this->post('/api/auth/logout', []);
    
        $response->assertStatus(200);
    }
}
