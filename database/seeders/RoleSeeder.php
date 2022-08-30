<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $intern=new Role();
        $intern->name         = 'inter';
        $intern->display_name = 'Interno'; // optional
        $intern->save();
        $client=new Role();
        $client->name         = 'cliente';
        $client->display_name = 'Cliente'; // optional
        $client->save();
    }
}
