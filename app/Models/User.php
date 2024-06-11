<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable,SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'date_of_birth',
        'gender',
        'email',
        'joined_date',
        "is_admin",
        'password',
        "full_name"
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function orders(){
        return $this-> hasMany(Order::class);
    }

    public function setPasswordAttribute($password)
    {
        $this->attributes["password"] = bcrypt($password);
    }

    public function scopeSearch($query, $request)
    {
        if ($request->has("search")) {
            $searchPattern = $request->query("search");
            $query
                ->where("first_name", "ILIKE", "%{$searchPattern}%")
                ->orwhere("last_name","ILIKE","%{$searchPattern}")
                ->orwhere("full_name","ILIKE","%{$searchPattern}");

        }
        return $query;
    }
    public function scopeFilter($query, $request)
    {

        if ($request->has("filter.is_admin")) {
            $brandList = explode(",", $request->query("filter")["is_admin"]);
            $query->whereIn("is_admin", $brandList);
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
            if ($sortBy == "first_name") {
                $query->orderBy($sortBy, $sortValue);
            }

        }
        return $query;
    }
    public function setFullNameAttribute(){
        $this->attributes[
        "full_name"
        ] = "$this->last_name $this->first_name";
    }






}
