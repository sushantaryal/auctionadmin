<?php

namespace Database\Seeders;

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
        \App\Models\User::factory()->create([
            'name' => 'Sushant Aryal',
            'email' => 'sushant.aryal90@gmail.com',
            'password' => bcrypt('sushant'),
            'role' => 'admin',
            'bid_credit' => 1000
        ]);
        \App\Models\User::factory(9)->create();
        \App\Models\Category::factory(10)->create();
        \App\Models\Product::factory(100)->hasPhotos(4)->create();
        
        $this->call([
            PageSeeder::class
        ]);
    }
}
