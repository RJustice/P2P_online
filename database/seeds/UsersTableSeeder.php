<?php

use Illuminate\Database\Seeder;

use App\User;
use Forone\Admin\Role;
use Forone\Admin\Permission;

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
        DB::table('roles')->delete();
        DB::table('permissions')->delete();
        DB::table('role_user')->delete();
        DB::table('permission_role')->delete();
        $user = User::create([
            'username' => 'admin',
            'password' => Hash::make('admin'),
            'email' => 'admin@nfzhongcheng.com',
            'name' => '超级管理员',
            'phone' => '',
            'type' => 'admin'
        ]);
        $role = Role::create(['name'=>'admin', 'display_name'=>'超级管理员']);
        $permission = Permission::create(['name'=>'admin', 'display_name'=>'超级管理员权限']);    
        $role->attachPermission($permission);
        $user->attachRole($role);     
    }
}
