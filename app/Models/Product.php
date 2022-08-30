<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table='products';
    protected $fillable=[
        'code','name','price','weight'
    ];

    public function orders(){
        return $this->belongsToMany(Order::class,'order_product');
    }
}
