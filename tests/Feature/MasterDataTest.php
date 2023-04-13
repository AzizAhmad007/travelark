<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class MasterDataTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */

    private function login()
    {
        $response = $this->post('/api/auth/login', [
            'username' => 'tama',
            'password' => 'rahasia123'
        ]);
        $json = $response->decodeResponseJson();
        return $json['access_token'];
    }
    public function test_city()
    {
        $this->login();
        $response = $this->get('/api/city');
        $json = $response->decodeResponseJson();
        $this->assertIsArray($json['data']);
        $this->assertEquals("success", $json['message']);
        $this->assertEquals(200, $json['statusCode']);
        $response->assertStatus(200);
    }
    public function test_country()
    {
        $this->login();
        $response = $this->get('/api/country');
        $json = $response->decodeResponseJson();
        $this->assertIsArray($json['data']);
        $this->assertEquals("success", $json['message']);
        $this->assertEquals(200, $json['statusCode']);
        $response->assertStatus(200);
    }
    public function test_tag()
    {
        $this->login();
        $response = $this->get('/api/tags');
        $json = $response->decodeResponseJson();
        $this->assertIsArray($json['data']);
        $this->assertEquals("success", $json['message']);
        $this->assertEquals(200, $json['statusCode']);
        $response->assertStatus(200);
    }
    public function test_province()
    {
        $this->login();
        $response = $this->get('/api/province');
        $json = $response->decodeResponseJson();
        $this->assertIsArray($json['data']);
        $this->assertEquals("success", $json['message']);
        $this->assertEquals(200, $json['statusCode']);
        $response->assertStatus(200);
    }
}
