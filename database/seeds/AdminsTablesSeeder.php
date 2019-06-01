<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Admin;

class AdminsTablesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Admin::create([
            'admin_id'    => 'a'.rand(100000000,999999999), //以時間當亂數種子
            'name'    => 'Ronghong',
            'email'    => 'hello080810@gmail.com',
            'account'   => 'ronghong',
            'password'   =>  Hash::make('123123'),
            'remember_token' =>  str_random(10),
        ]);
    }
}
