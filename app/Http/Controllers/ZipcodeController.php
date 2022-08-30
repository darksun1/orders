<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Zipcode;

class ZipcodeController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        //
    }
    public function getCityState(Request $request){
        $zip=Zipcode::where('code',$request->zipcode)->first();
        if($zip->city!='')
            return json_encode(['city'=>$zip->city->name,'state'=>$zip->city->state->name]);
        else
            return "error";
    }
}
