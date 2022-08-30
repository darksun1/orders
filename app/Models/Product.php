<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    public $timestamps = false;
    
    /*public function orders(){
        return $this->belongsToMany('App\Models\Order','order_product','order_id','product_id');
    }*/
    public function orders(){
        return $this->belongsToMany(Order::class,'order_product');
    }
}
