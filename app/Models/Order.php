<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Prunable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, SoftDeletes, Prunable;

    protected $table = 'orders';
    protected $fillable = [
        'status'
    ];

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function scopeFilter($query, $request)
    {

        if ($request->has("filter.status")) {
            $statusList = explode(",", $request->query("filter")["status"]);
            $query->whereIn("status", $statusList);
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

            if ($sortBy == "order_amount") {
                $query->orderBy($sortBy, $sortValue);
            }elseif ($sortBy == "order_date"){
                $query->orderBy($sortBy, $sortValue);
            }

        }
        return $query;
    }

}
