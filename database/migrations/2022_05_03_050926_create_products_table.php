<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('product_name')->nullable();
            $table->string('product_thumbnail')->nullable();
            $table->json('product_images')->nullable();
            $table->string('status')->nullable();
            $table->text('desc')->nullable();
            $table->json('sku')->nullable();
            $table->integer('product_price')->nullable();
            $table->integer('product_quantity')->nullable();
            $table->foreignId("category_id")->constrained("categories")->onDelete('cascade');
            $table->foreignId("brand_id")->constrained("brands")->onDelete('cascade');
            $table->foreignId("discount_id")->constrained("discounts")->onDelete('cascade');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
            $table->dropForeign(['brand_id']);
            $table->dropForeign(['discount_id']);


        });
        Schema::dropIfExists('products');
    }
}
