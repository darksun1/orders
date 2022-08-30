<?php

namespace App\Imports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\ToModel;

class ProductImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Product([
            'code'=>$row[0],
            'name'=>$row[1],
            'price'=>$row[2],
            'weight'=>$row[3]
        ]);
    }
}
