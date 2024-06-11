<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory;

    public function Categories()
    {
        return $this->belongsToMany(Category::class)->using(BrandCategory::class);
    }
}
