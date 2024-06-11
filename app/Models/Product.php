<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Product extends Model
{
    use HasFactory,SoftDeletes;
    /**
     * @var mixed
     */
    public $timestamps = true;
    protected $table = 'products';
    protected $fillable = [
        'product_name',
        'product_thumbnail',
        'product_images',
        'desc',
        'product_price',
        'category_id',
        'brand_id',
        'discount_id',
        'sku',
        'status',
        "product_quantity"
    ];
    protected $casts = [
        'sku' => 'array',
        'product_images' => 'array'
    ];


    public function category(){
        return $this->belongsTo(Category::class);
    }
    public function brand(){
        return $this->belongsTo(Brand::class);
    }
    public function discount(){
        return $this->belongsTo(Discount::class);

    }
    public function reviews(){
        return $this-> hasMany(Review::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function scopeFilter($query, $request)
    {

        if ($request->has("filter.brand_name")) {
            $brandList = explode(",", $request->query("filter")["brand_name"]);
            $query->whereIn("brand_name", $brandList);
        }

        if ($request->has("filter.category_name")) {
            $categoryList = explode(",", $request->query("filter")["category_name"]);
            $query->whereIn("category_name", $categoryList);
        }

        return $query;
    }
    public function scopeSort($query, $request)
    {
        if ($request->has("sort")) {
            foreach ($request->query("sort") as $key => $value) {
                $sortBy = $key;
                $sortValue = $value;
            }

            if ($sortBy == "product_price") {
                $query->orderBy($sortBy, $sortValue);
            }

        }
        return $query;
    }
    public function scopeSearch($query, $request)
    {
        if ($request->has("search")) {
            $searchPattern = $request->query("search");
            $query
                ->where("product_name", "ILIKE", "%{$searchPattern}%");
//                ->orWhere("staff_code", "ILIKE", "%{$searchPattern}%");
        }
        return $query;
    }
    public function setStatusAttribute($product_quantity){

        $this->product_quantity != 0 ? $this->attributes["status"] = "Available" : $this->attributes["status"] = "Not Available";

    }
//    protected $appends = ['final_price'];
//    function getFinalPriceAttribute(){
//        $discount_percent = array(DB::table("products")
//            ->join("discounts", "discounts.id", "=", "products.discount_id")
//            ->select("discount_percent")->get());
////        return $this->product_price * (1 - $discount_percent);
//    }


}
