<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CheckoutPackageTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    private function login(){
        $response = $this->post('/api/auth/login',[
            'username'=>'tama',
            'password'=>'rahasia123'
        ]);
        $json = $response->decodeResponseJson();
        return $json['access_token'];
    }

    public function test_create()
    {
        $this->login();
        
        $response = $this->post('/api/checkout/insert-checkout-package',[
                'user_id' => 1,
                'trip_package_id' => 1,
                'total_price' => 30000,
                'firstname' => 'tama',
                'lastname' => 'ahmad',
                'email' => 'tama@gmail.com',
                'phone_number' => '085771434475',
                'ticket_date' => '2022-05-12',
                'qty' => 2
        ]
);
        $json = $response->decodeResponseJson();
        $this->assertIsArray($json['data']);
        $this->assertEquals("success",$json['message']);
        $this->assertEquals(200, $json['statusCode']);
        $this->assertEquals(true, is_string( $json['data']['transaction_number']));
        $this->assertEquals(true, is_string( $json['data']['Date']));
        $this->assertEquals(true, is_string( $json['data']['status']));
        $this->assertEquals(true, is_string( $json['data']['Category']));
        $this->assertEquals(true, is_string( $json['data']['ticket_date']));
        $this->assertEquals(true, is_integer( $json['data']['qty']));
        $this->assertEquals(true, is_integer( $json['data']['price']));
        $this->assertEquals(true, is_string( $json['data']['firstname']));
        $this->assertEquals(true, is_string( $json['data']['lastname']));
        $this->assertEquals(true, is_string( $json['data']['email']));
        $this->assertEquals(true, is_string( $json['data']['phone_number']));
        $this->assertEquals(true, is_string( $json['data']['destination']['name']));
        $this->assertEquals(true, is_string( $json['data']['destination']['tag']));
        $this->assertEquals(true, is_string( $json['data']['destination']['city']));
        $this->assertEquals(true, is_string( $json['data']['destination']['province']));
        $this->assertEquals(true, is_string( $json['data']['destination']['country']));


        $response->assertStatus(200);
    }
    public function test_get()
    {
        $this->login();
        $response = $this->get('/api/checkout/checkout-package');

        $response->assertStatus(200);
    }
}
