<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table='cities';
    
    public function state(){
        //return $this->belongsTo('App\Models\State');
        return $this->belongsTo(State::class);
    }
    /*public function zip_codes(){
        //return $this->hasMany('App\Models\Zipcode');
        return $this->hasMany(Zipcode::class);
    }*/
}
