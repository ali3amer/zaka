<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = \App\User::create([
            'name'      =>  'admin',
            'email'     =>  'admin@test.com',
            'password'  =>  Hash::make('123456')
        ]);
        $user->attachRole('super_admin');
    }
}
