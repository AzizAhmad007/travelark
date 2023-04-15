<?php

namespace Tests\Unit;

use Faker\Factory;
use Tests\TestCase;

class DetailPackageUnitTest extends TestCase
{
    private function login(){
        $response = $this->post('/api/auth/login',[
            'username'=>'tama',
            'password'=>'rahasia123'
        ]);
        $json = $response->decodeResponseJson();
        return $json['access_token'];
        
    }
    public function dummy()
    {
        $faker = Factory::create();
        return [
            'user_id' => 1,
            'trip_packages_id' => $faker->numberBetween(1,4),
            'checkout_package_id' => $faker->numberBetween(1,8),
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")
        ];
    }
    public function dummyIseng()
    {
        $faker = Factory::create();
        return [
            'user_id' => 1,
            'trip_packages_id' => $faker->numberBetween(1,4),
            'checkout_package_id' => 'a',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")
        ];
    }
    public function testExecuteCreate()
    {
        $this->login();
        $response = $this->post('/api/detail-package/insert-detail-package', $this->dummy());
        $data = $response->decodeResponseJson()['data'];
        $this->assertIsArray($data);
        $this->assertIsInt($data['user_id']);
        $this->assertIsInt($data['trip_packages_id']);
        $this->assertIsInt($data['checkout_package_id']);
        $response->assertStatus(200);
    }
    public function testExecuteCreateIseng()
    {
        $this->login();
        $response = $this->post('/api/detail-package/insert-detail-package', $this->dummyIseng());
        $data = $response->decodeResponseJson()['data'];
        $this->assertNull($data);
        $response->assertStatus(200);
    }
    public function testExecuteUpdate()
    {
        $this->login();
        $id = Factory::create()->numberBetween(1,8);
        $response = $this->put('/api/detail-package/update-detail-package/'.$id, $this->dummy());
        $data = $response->decodeResponseJson()['data'];
        $this->assertIsArray($data);
        $this->assertIsInt($data['user_id']);
        $this->assertIsInt($data['trip_packages_id']);
        $this->assertIsInt($data['checkout_package_id']);
        $response->assertStatus(200);
    }
    public function testExecuteUpdateNegative()
    {
        $this->login();
        $id = Factory::create()->numberBetween(1,8);
        $response = $this->put('/api/detail-package/update-detail-package/'.'a', $this->dummyIseng());
        $data = $response->decodeResponseJson()['data'];
        $this->assertNull($data);
        $response->assertStatus(200);
    }
    public function testExecuteGetOne()
    {
        $this->login();
        $id = Factory::create()->numberBetween(1,8);
        $response = $this->get('/api/detail-package/detail-detail-package/'.$id);
        $data = $response->decodeResponseJson()['data'];
        $this->assertIsArray($data);
        $this->assertNotNull($data);
        $response->assertStatus(200);
    }
    public function testExecuteDelete()
    {
        $this->login();
        $id = Factory::create()->numberBetween(1,8);
        $response = $this->delete('/api/detail-package/delete-detail-package/'.$id);
        $response->assertStatus(200);
    }
    public function testExecuteGetAll()
    {
        $this->login();
        $response = $this->get('/api/detail-package/detail-package');
        $data = $response->decodeResponseJson()['data'];
        $this->assertNull($data);
        $response->assertStatus(200);
    }
}
