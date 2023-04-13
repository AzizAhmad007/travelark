<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GuestTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_destination()
    {
        $response = $this->get('/api/guest/destination');
        $json = $response->decodeResponseJson();
        $this->assertIsArray($json['data']);
        $this->assertEquals("success",$json['message']);
        $this->assertEquals(200, $json['statusCode']);
        $this->assertEquals(true, is_integer( $json['data'][0]['id']));
        $this->assertEquals(true, is_string( $json['data'][0]['tag']));
        $this->assertEquals(true, is_string( $json['data'][0]['country']));
        $this->assertEquals(true, is_string( $json['data'][0]['city']));
        $this->assertEquals(true, is_string( $json['data'][0]['province']));
        $this->assertEquals(true, is_string( $json['data'][0]['palace_name']));
        $this->assertEquals(true, is_string( $json['data'][0]['image']));

        $response->assertStatus(200);
    }
    public function test_destination_detail()
    {
        $response = $this->get('/api/guest/destination-detail/1');
        $json = $response->decodeResponseJson();
        $this->assertIsArray($json['data']);
        $this->assertEquals("success",$json['message']);
        $this->assertEquals(200, $json['statusCode']);
        $this->assertEquals(true, is_integer( $json['data']['id']));
        $this->assertEquals(true, is_string( $json['data']['tag']));
        $this->assertEquals(true, is_string( $json['data']['country']));
        $this->assertEquals(true, is_string( $json['data']['city']));
        $this->assertEquals(true, is_string( $json['data']['province']));
        $this->assertEquals(true, is_string( $json['data']['palace_name']));
        $this->assertEquals(true, is_string( $json['data']['image']));
        $this->assertEquals(true, is_integer( $json['data']['price']));
        $this->assertEquals(true, is_string( $json['data']['description']));
         $this->assertEquals(true, is_integer( $json['data']['review']));
         $this->assertEquals(true, is_integer( $json['data']['rating']));
         $this->assertEquals(true, is_string( $json['data']['all_image'][0]['image']));

        $response->assertStatus(200);
    }

    public function test_open_package()
    {
        $response = $this->get('/api/guest/open-package-destination');
        $json = $response->decodeResponseJson();
        $this->assertIsArray($json['data']);
        $this->assertEquals("success",$json['message']);
        $this->assertEquals(200, $json['statusCode']);
        $this->assertEquals(true, is_integer( $json['data'][0]['id']));
        $this->assertEquals(true, is_string( $json['data'][0]['type']));
        $this->assertEquals(true, is_integer( $json['data'][0]['pax_available']));
        $this->assertEquals(true, is_string( $json['data'][0]['destination']['tag']));
        $this->assertEquals(true, is_string( $json['data'][0]['destination']['country']));
        $this->assertEquals(true, is_string( $json['data'][0]['destination']['city']));
        $this->assertEquals(true, is_string( $json['data'][0]['destination']['province']));
        $this->assertEquals(true, is_string( $json['data'][0]['destination']['image']));
        $this->assertEquals(true, is_string( $json['data'][0]['destination']['destination_name']));


        $response->assertStatus(200);
    }
    public function test_private_package()
    {
        $response = $this->get('/api/guest/private-package-destination');
        $json = $response->decodeResponseJson();
        $this->assertIsArray($json['data']);
        $this->assertEquals("success",$json['message']);
        $this->assertEquals(200, $json['statusCode']);
        $this->assertEquals(true, is_integer( $json['data'][0]['id']));
        $this->assertEquals(true, is_string( $json['data'][0]['type']));
        $this->assertEquals(true, is_string( $json['data'][0]['destination']['tag']));
        $this->assertEquals(true, is_string( $json['data'][0]['destination']['country']));
        $this->assertEquals(true, is_string( $json['data'][0]['destination']['city']));
        $this->assertEquals(true, is_string( $json['data'][0]['destination']['province']));
        $this->assertEquals(true, is_string( $json['data'][0]['destination']['image']));
        $this->assertEquals(true, is_string( $json['data'][0]['destination']['destination_name']));


        $response->assertStatus(200);
    }

     public function test_open_package_detail()
    {
        $response = $this->get('/api/guest/open-destination-detail/1');
        $json = $response->decodeResponseJson();
        $this->assertIsArray($json['data']);
        $this->assertEquals("success",$json['message']);
        $this->assertEquals(200, $json['statusCode']);
        $this->assertEquals(true, is_integer( $json['data']['id']));
        $this->assertEquals(true, is_string( $json['data']['type']));
        $this->assertEquals(true, is_integer( $json['data']['duration']));
        $this->assertEquals(true, is_integer( $json['data']['price']));
        $this->assertEquals(true, is_integer( $json['data']['quota']));
        $this->assertEquals(true, is_integer( $json['data']['pax_available']));
        $this->assertEquals(true, is_integer( $json['data']['review']));
        $this->assertEquals(true, is_integer( $json['data']['rating']));
        $this->assertEquals(true, is_integer( $json['data']['total_price']));
        $this->assertEquals(true, is_string( $json['data']['destination']['tag']));
        $this->assertEquals(true, is_string( $json['data']['destination']['country']));
        $this->assertEquals(true, is_string( $json['data']['destination']['city']));
        $this->assertEquals(true, is_string( $json['data']['destination']['province']));
        $this->assertEquals(true, is_string( $json['data']['destination']['image']));
        $this->assertEquals(true, is_string( $json['data']['destination']['destination_name']));
        $this->assertEquals(true, is_string( $json['data']['destination']['description']));
        $this->assertEquals(true, is_string( $json['data']['destination']['all_image'][0]['image']));
         $this->assertEquals(true, is_array( $json['data']['featured_trip']));
         $this->assertEquals(true, is_array( $json['data']['acomodation']));
         $this->assertEquals(true, is_array( $json['data']['destination_trip']));

        $response->assertStatus(200);
    }

    public function test_private_package_detail()
    {
        $response = $this->get('/api/guest/open-destination-detail/1');
        $json = $response->decodeResponseJson();
        $this->assertIsArray($json['data']);
        $this->assertEquals("success",$json['message']);
        $this->assertEquals(200, $json['statusCode']);
        $this->assertEquals(true, is_integer( $json['data']['id']));
        $this->assertEquals(true, is_string( $json['data']['type']));
        $this->assertEquals(true, is_integer( $json['data']['duration']));
        $this->assertEquals(true, is_integer( $json['data']['price']));
        $this->assertEquals(true, is_integer( $json['data']['quota']));
        $this->assertEquals(true, is_integer( $json['data']['review']));
        $this->assertEquals(true, is_integer( $json['data']['rating']));
        $this->assertEquals(true, is_string( $json['data']['destination']['tag']));
        $this->assertEquals(true, is_string( $json['data']['destination']['country']));
        $this->assertEquals(true, is_string( $json['data']['destination']['city']));
        $this->assertEquals(true, is_string( $json['data']['destination']['province']));
        $this->assertEquals(true, is_string( $json['data']['destination']['image']));
        $this->assertEquals(true, is_string( $json['data']['destination']['destination_name']));
        $this->assertEquals(true, is_string( $json['data']['destination']['description']));
        $this->assertEquals(true, is_string( $json['data']['destination']['all_image'][0]['image']));
         $this->assertEquals(true, is_array( $json['data']['featured_trip']));
         $this->assertEquals(true, is_array( $json['data']['acomodation']));
         $this->assertEquals(true, is_array( $json['data']['destination_trip']));

        $response->assertStatus(200);
    }

    public function test_popular_destination()
    {
        $response = $this->get('/api/guest/popular-destination');
        $json = $response->decodeResponseJson();
        $this->assertIsArray($json['data']);
        $this->assertEquals("success",$json['message']);
        $this->assertEquals(200, $json['statusCode']);
        $this->assertEquals(true, is_integer( $json['data'][0]['id']));
        $this->assertEquals(true, is_string( $json['data'][0]['palace_name']));
        $this->assertEquals(true, is_string( $json['data'][0]['image']));
        $this->assertEquals(true, is_string( $json['data'][0]['tag']));
        $this->assertEquals(true, is_string( $json['data'][0]['country']));
        $this->assertEquals(true, is_string( $json['data'][0]['province']));
        $this->assertEquals(true, is_string( $json['data'][0]['city']));

        $response->assertStatus(200);
    }
    public function test_popular_package()
    {
        $response = $this->get('/api/guest/popular-package');
        $json = $response->decodeResponseJson();
        $this->assertIsArray($json['data']);
        $this->assertEquals("success",$json['message']);
        $this->assertEquals(200, $json['statusCode']);
        $this->assertEquals(true, is_integer( $json['data'][0]['id']));
        $this->assertEquals(true, is_string( $json['data'][0]['destination_name']));
        $this->assertEquals(true, is_string( $json['data'][0]['image']));
        $this->assertEquals(true, is_string( $json['data'][0]['tag']));
        $this->assertEquals(true, is_string( $json['data'][0]['country']));
        $this->assertEquals(true, is_string( $json['data'][0]['province']));
        $this->assertEquals(true, is_string( $json['data'][0]['city']));

        $response->assertStatus(200);
    }
}
