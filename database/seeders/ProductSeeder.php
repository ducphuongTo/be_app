<?php

namespace Database\Seeders;
use App\Helper\Helper\Helper;
use App\Models\Product;
use App\Models\Review;
use Faker\Factory;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $faker = Factory::create();
        $table = 'products';
        $file = database_path("data/$table".".csv");
        $records = Helper::import_CSV($file);
        foreach ($records as $key => $record) {
            Product::create([
                'product_name' => $record['product_name'],
                'product_thumbnail' => $record['product_thumbnail'],
                'product_price' => $record['product_price'],
                'brand_id' => $record['brand_id'],
                'category_id' => $record['category_id'],
                'discount_id' => $record['discount_id'],
                'product_quantity' => $record['product_quantity'],
                'desc' => $record['desc']

//                'sku' => $record['sku'],


            ]);
        }
    }
}
