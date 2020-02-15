<?php


use App\Models\User;

class UsersTableSeeder extends DatabaseSeeder
{
    public function run()
    {
        $user = new User();
        $user->name = 'admin';
        $user->email = 'admin@permi.com';
        $user->password = 'password';
        $user->mobile = '0125' . mt_rand(1000000, 9999999);
        $user->is_active = 1;
        $user->role_id = 1;
        $user->save();

    }
}
