<?php

use Illuminate\Database\Seeder;
use App\School;

class SchoolsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $school = new School();
        $school->name = 'Great Zayed School';
        $school->city = 'Dubai';
        $school->country = 'United Arab Emirates';
        $school->status = 1;
        $school->save();

        $school = new School();
        $school->name = 'Goodfolks High School';
        $school->city = 'Sharjah';
        $school->country = 'United Arab Emirates';
        $school->status = 1;
        $school->save();

        $school = new School();
        $school->name = 'American School in Ajman';
        $school->city = 'Ajman';
        $school->country = 'United Arab Emirates';
        $school->status = 1;
        $school->save();
    }
}
