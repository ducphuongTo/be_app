<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::create([
            "category_name" => "Điện Thoại", //id :1
        ]);
        Category::create([
            "category_name" => "Laptop", //id :2
        ]);
        Category::create([
            "category_name" => "Tablet", //id :3
        ]);
        Category::create([
            "category_name" => "Phụ kiện", //id :4
        ]);
    }
}
