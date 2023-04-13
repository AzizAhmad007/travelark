<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Http\UploadedFile;

class PalaceTest extends TestCase
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
    public function test_Get_Palace()
    {
        $this->login();
        $response = $this->get('/api/palace/palace');
        $json = $response->decodeResponseJson();
        $this->assertIsArray($json['data']);
        $this->assertEquals("success", $json['message']);
        $this->assertEquals(200, $json['statusCode']);
        $this->assertEquals(true, is_integer($json['data'][0]['id']));
        $this->assertEquals(true, is_string($json['data'][0]['user']));
        $this->assertEquals(true, is_string($json['data'][0]['tag']));
        $this->assertEquals(true, is_string($json['data'][0]['country']));
        $this->assertEquals(true, is_string($json['data'][0]['city']));
        $this->assertEquals(true, is_string($json['data'][0]['province']));
        $this->assertEquals(true, is_string($json['data'][0]['palace_name']));
        $this->assertEquals(true, is_string($json['data'][0]['image']));
        $this->assertEquals(true, is_integer($json['data'][0]['price']));
        $this->assertEquals(true, is_string($json['data'][0]['description']));

        $response->assertStatus(200);
    }

    public function test_GetOne_Palace()
    {
        $this->login();
        $response = $this->get('/api/palace/detail-palace/1');
        $json = $response->decodeResponseJson();
        $this->assertIsArray($json['data']);
        $this->assertEquals("success", $json['message']);
        $this->assertEquals(200, $json['statusCode']);
        $this->assertEquals(true, is_integer($json['data']['id']));
        $this->assertEquals(true, is_string($json['data']['user']));
        $this->assertEquals(true, is_string($json['data']['tag']));
        $this->assertEquals(true, is_string($json['data']['country']));
        $this->assertEquals(true, is_string($json['data']['city']));
        $this->assertEquals(true, is_string($json['data']['province']));
        $this->assertEquals(true, is_string($json['data']['palace_name']));
        $this->assertEquals(true, is_string($json['data']['image']));
        $this->assertEquals(true, is_integer($json['data']['price']));
        $this->assertEquals(true, is_string($json['data']['description']));

        $response->assertStatus(200);
    }


    public function test_Create_Palace()
    {
        $this->login();
         $image = UploadedFile::fake()->image('test-image.jpg');
        $response = $this->post(
            '/api/palace/insert-palace',
            [
               "user_id" => 1,
                "tag_id" => 1,
                "country_id" => 1,
                "city_id" => 1,
                "province_id" => 1,
                "palace_name" => "hanya unit test",
                "image" => $image,
                "price" => 10000,
                "description" => 'unit test',
            ]
        );
        $json = $response->decodeResponseJson();
        $this->assertIsArray($json['data']);
        $this->assertEquals("success", $json['message']);
        $this->assertEquals(200, $json['statusCode']);
        $response->assertStatus(200);
    }

    public function test_update_Palace()
    {
        $this->login();
         $image = UploadedFile::fake()->image('test-image2.jpg');
        $response = $this->post(
            '/api/palace/update-palace/1',
            [
               "user_id" => 1,
                "tag_id" => 1,
                "country_id" => 1,
                "city_id" => 1,
                "province_id" => 1,
                "palace_name" => "hanya unit test",
                "image" => $image,
                "price" => 10000,
                "description" => 'unit test',
            ]
        );
        $json = $response->decodeResponseJson();
        $this->assertIsArray($json['data']);
        $this->assertEquals("success", $json['message']);
        $this->assertEquals(200, $json['statusCode']);
        $response->assertStatus(200);
    }

    public function test_delete_Palace()
    {
        $this->login();
      
        $response = $this->delete(
            '/api/palace/delete-palace/5');
        $json = $response->decodeResponseJson();
        $this->assertIsArray($json['data']);
        $this->assertEquals("success", $json['message']);
        $this->assertEquals(200, $json['statusCode']);
        $response->assertStatus(200);
    }
}
