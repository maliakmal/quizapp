<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Role;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role_admin = Role::where('name', 'admin')->first();
        $role_teacher  = Role::where('name', 'teacher')->first();
        $role_student = Role::where('name', 'student')->first();
    
        $user = new User();
        $user->first_name = 'Noman';
        $user->last_name = 'Ghani';
        $user->email = 'noman@gtechme.com';
        $user->password = bcrypt('secret');
        $user->status = 1;
        $user->save();
        $user->roles()->attach($role_admin);

        $user = new User();
        $user->first_name = 'Maheen';
        $user->last_name = 'Khan';
        $user->email = 'maheen@gtechme.com';
        $user->password = bcrypt('secret');
        $user->status = 1;
        $user->save();
        $user->roles()->attach($role_teacher);

        $user = new User();
        $user->first_name = 'Irfan';
        $user->last_name = 'Ali';
        $user->email = 'irfan@gtechme.com';
        $user->password = bcrypt('secret');
        $user->status = 1;
        $user->save();
        $user->roles()->attach($role_student);
    }
}
