<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    public function brands()
    {
        return $this->belongsToMany(Brand::class)->using(BrandCategory::class);
    }

    public function products(){
        return $this->hasMany(Product::class);
    }
}
