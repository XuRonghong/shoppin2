<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\User;

class UsersTablesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        User::create([
            'user_id'    => rand(1000000000,2147483647), //以時間當亂數種子
            'name'    => 'John Smith',
            'email'    => 'john_smith@gmail.com',
            'account'   =>  'johnsmith',
            'password'   =>  Hash::make('password'),
            'remember_token' =>  str_random(10),
        ]);
    }
}
