<?php

namespace App\Http\Controllers\Teacher;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

use App\User;
use App\School;
use App\Role;
use App\Mail\ConfirmedTeacherRegistration;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
  
    public function index(Request $request)
    {
      $params = [];
      $searchables = ['status', 'school_id', 'grade', 'age', 'gender'];
      $params  = $request->all();

      $students = User::select('users.*')->with('school');
  
      if (isset($params['search']) && !empty($params['search'])) {
        $students = $students->withName($params['search']);
      }

      if (isset($params['country']) && !empty($params['country'])) {
        $students->byCountry($params['country']);
      }


      foreach($searchables as $searchable){
        if (isset($params[$searchable]) && !empty($params[$searchable])) {
          $students->where($searchable, '=', $params[$searchable]);
        }
      }



      $students = $students->byRoles('student')->orderBy("users.created_at", "DESC")->paginate(10);
  
      $schools = School::select()->get()->pluck('name', 'id')->all();
      $ages = array_combine(range(8,18),range(8,18));
      $grades = array_combine(range(1,10),range(1,10));
      $types = ['junior'=>'Junior', 'senior'=>'Senior'];
      $genders = ['male'=>'Male', 'female'=>'Female'];
      $countries = ['United Arab Emirates'=>'United Arab Emirates'];
  

      return view('backend.teacher.home', compact('students', 'schools', 'ages', 'grades', 'types', 'countries', 'genders', 'params'));
    }

}
