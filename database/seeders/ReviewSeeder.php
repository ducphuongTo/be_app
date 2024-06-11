<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Review;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Database\Seeders\ProductSeeder;
class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();
        $products = Product::all();
        foreach ($products as $product) {
            Review::factory()->count($faker->numberBetween(1, 30))
                ->create([
                    'product_id' => $product->id
                ]);
        }

    }
}
