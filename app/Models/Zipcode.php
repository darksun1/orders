<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Zipcode extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table='zip_codes';

    public function city(){
        //return $this->belongsTo('App\Models\City');
        return $this->belongsTo(City::class);
    }
}
