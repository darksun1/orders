<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\ProductImport;
use Maatwebsite\Excel\Facades\Excel;

class ProductController extends Controller
{
    public function import(){
        Excel::import(new ProductImport,request()->file('file'));
        return back();
    }
}
