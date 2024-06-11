<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $table = 'reviews';
    protected $fillable = ['product_id','reviewer_name','review_details','rating_star','review_date'];

    function product(){
        return $this-> belongsTo(Product::class);
    }

    public function scopeFindReviews ($query, $productId){
        $query->where("product_id", $productId);
        return $query;
    }
}
