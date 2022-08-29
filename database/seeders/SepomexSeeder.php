<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class SepomexSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $file=Storage::disk('local')->get('CPdescarga.txt');
        $arr=explode("\n",$file);
        $state='';
        $city='';
        $zip_code='';
        foreach($arr as $line){
            $arr=explode('|',utf8_encode($line));
            if($arr[4]!=$state){
                $state=$arr[4];
                $state_id=DB::table('states')->insertGetId(['name'=>$state]);
            }
            if($arr[3]!=$city){
                $city=$arr[3];
                $city_id=DB::table('cities')->insertGetId(['name'=>$city,'state_id'=>$state_id]);
            }
            if($arr[0]!=$zip_code){
                $zip_code=$arr[0];
                DB::table('zip_codes')->insert(['code'=>$zip_code,'city_id'=>$city_id]);
            }
        }
    }
}
