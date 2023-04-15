<?php

namespace Tests\Unit;

use App\Models\Checkout_package_travel_sumary;
use Faker\Factory;
use Tests\TestCase;
use Str;

class CheckoutPackageSummaryUnitTest extends TestCase
{
    private function login(){
        $response = $this->post('/api/auth/login',[
            'username'=>'tama',
            'password'=>'rahasia123'
        ]);
        $json = $response->decodeResponseJson();
        return $json['access_token'];
        
    }
    private function loginTraveler(){
        $response = $this->post('/api/auth/login',[
            'username'=>'fajar',
            'password'=>'password'
        ]);
        $json = $response->decodeResponseJson();
        return $json['access_token'];
        
    }
    public function dummy()
    {
        $faker = Factory::create();
        return [
            'user_id' => 1,
            'trip_package_id ' => $faker->numberBetween(1,4),
            'total_price' => $faker->numberBetween(500000, 2147483647),
            'transaction_number' => Str::random(10) . uniqid(),
            'firstname' => $faker->firstName(),
            'lastname' => $faker->lastName(),
            'email' => $faker->email(),
            'phone_number' => '081234567890',
            'qty' => $faker->numberBetween(1,5),
            'ticket_date' => date("Y-m-d H:i:s"),
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")
        ];
    }
    public function testNameIsString()
    {
        $data = $this->dummy();
        $testFirstName = $data['firstname'];
        $testFirstName = 'a';
        $this->assertIsString($testFirstName);
    }
    public function testExecuteCreate()
    {
        $this->loginTraveler();
        $response = $this->post('/api/checkout/insert-checkout-package', $this->dummy());
        $data = $response->decodeResponseJson()['data'];
        $this->assertIsArray($data);
        $this->assertIsInt($data['user_id']);
        $this->assertIsInt($data['trip_packages_id']);
        $this->assertIsFloat($data['total_price']);
        $this->assertIsString($data['transaction_number']);
        $this->assertIsString($data['firstname']);
        $this->assertIsString($data['lastname']);
        $this->assertIsString($data['email']);
        $this->assertIsString($data['phone_number']);
        $this->assertIsInt($data['qty']);
        $response->assertStatus(200);
    }
    public function testExecuteUpdate()
    {
        $this->login();
        $id = Factory::create()->numberBetween(1,8);
        $response = $this->put('/api/checkout/update-checkout-package/'.$id, $this->dummy());
        $data = $response->decodeResponseJson()['data'];
        $this->assertIsArray($data);
        $this->assertIsInt($data['user_id']);
        $this->assertIsInt($data['trip_packages_id']);
        $this->assertIsFloat($data['total_price']);
        $this->assertIsString($data['transaction_number']);
        $this->assertIsString($data['firstname']);
        $this->assertIsString($data['lastname']);
        $this->assertIsString($data['email']);
        $this->assertIsString($data['phone_number']);
        $this->assertIsInt($data['qty']);
        $response->assertStatus(200);
    }
    public function testExecuteGetOne()
    {
        $this->login();
        $id = Factory::create()->numberBetween(1,8);
        $response = $this->get('/api/checkout/detail-checkout-package/'.$id);
        $data = $response->decodeResponseJson()['data'];
        $this->assertIsArray($data);
        $this->assertNotNull($data);
        $response->assertStatus(200);
    }
    public function testExecuteDelete()
    {
        $this->login();
        $id = 8;
        $response = $this->delete('/api/checkout/delete-checkout-package/'.$id);
        $response->assertStatus(200);
    }
    public function testExecuteGetAll()
    {
        $this->login();
        $response = $this->get('/api/checkout/checkout-package');
        $data = $response->decodeResponseJson()['data'];
        $this->assertNotNull($data);
        $response->assertStatus(200);
    }
}
