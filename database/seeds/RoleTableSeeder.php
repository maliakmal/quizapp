<?php

use Illuminate\Database\Seeder;
use App\Role;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = new Role();
        $role->name = 'admin';
        $role->description = 'Administrator';
        $role->save();

        $role = new Role();
        $role->name = 'teacher';
        $role->description = 'Teacher';
        $role->save();

        $role = new Role();
        $role->name = 'student';
        $role->description = 'Student';
        $role->save();
    }
}
