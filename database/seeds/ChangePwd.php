<?php

use Illuminate\Database\Seeder;

use App\User;
class ChangePwd extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        User::find(1)->update(['password'=>Hash::make('NfZAQ!cft6')]);
    }
}
