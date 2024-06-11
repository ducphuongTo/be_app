<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Brand;
class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Brand::create([
            "brand_name" => "Apple" //id :1
        ]);
        Brand::create([
            "brand_name" => "Samsung" //id :2
        ]);
        Brand::create([
            "brand_name" => "Xiaomi" //id :3
        ]);
        Brand::create([
            "brand_name" => "Oppo" //id :4
        ]);
        Brand::create([
            "brand_name" => "Realme" //id :5
        ]);
        Brand::create([
            "brand_name" => "HP" //id :6
        ]);
        Brand::create([
            "brand_name" => "Dell" //id :7
        ]);
        Brand::create([
            "brand_name" => "Lenovo" //id :8
        ]);
        Brand::create([
            "brand_name" => "Asus" //id :9
        ]);
        Brand::create([
            "brand_name" => "Acer" //id :10
        ]);
    }
}
