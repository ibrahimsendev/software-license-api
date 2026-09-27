<?php

namespace Database\Seeders;

use App\Models\License;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $users = User::factory(5)->create();

        $product1 = Product::create([
            'name' => 'PhpStorm IDE',
            'price' => 200.00,
        ]);

        $product2 = Product::create([
            'name' => 'Windows 11 Pro',
            'price' => 150.00,
        ]);

        $product3 = Product::create([
            'name' => 'Antivirus Security',
            'price' => 120.00,
        ]);

        License::factory(10)->create([
            'product_id' => $product1->id,
            'user_id' => null,
        ]);

        License::factory(3)->create([
            'product_id' => $product2->id,
            'user_id' => null,
        ]);

        License::factory(2)->create([
            'product_id' => $product3->id,
            'user_id' => $users->first()->id,
        ]);

        License::factory(4)->create([
            'product_id' => $product3->id,
            'user_id' => null,
        ]);
    }
}
