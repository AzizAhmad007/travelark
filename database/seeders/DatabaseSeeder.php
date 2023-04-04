<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        $this->call(ProvinceSeeder::class);
        // \App\Models\User::factory(10)->create();
        $this->call(CitiSeeder::class);
        $this->call(CountriesSeeder::class);
        $this->call(TagsSeeder::class);
    }
}
