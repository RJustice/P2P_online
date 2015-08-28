<?php

use Illuminate\Database\Seeder;

use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('users')->delete();
        User::create([
            'username' => 'admin',
            'password' => Hash::make('admin'),
            'email' => 'admin@nfzhongcheng.com',
            'name' => '超级管理员',
            'phone' => '',
            'type' => 'admin'
        ]);        
    }
}
