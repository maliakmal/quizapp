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

class StudentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
  
    public function index(Request $request)
    {
      $params = [];
      $searchables = ['type', 'school_id', 'grade', 'age', 'gender'];
      $params = $request->all();

      $students = User::select('users.*')->with('school');
  
      if (isset($params['search']) && !empty($params['search'])) {
        $students = $students->withName($params['search']);
      }
      foreach($searchables as $searchable){
        if (isset($params[$searchable]) && !empty($params[$searchable])) {
          $students = $students->where($searchable, '=', $params[$searchable]);

        }
      }



      $students = $students->byRoles('student')->bySchool(\Auth::user()->school_id)->orderBy("users.created_at", "DESC")->paginate(10);
        $ages = array_combine(range(8,18),range(8,18));
      $grades = array_combine(range(1,10),range(1,10));
      $types = ['junior'=>'Junior', 'senior'=>'Senior'];
      $genders = ['male'=>'Male', 'female'=>'Female'];

      return view('backend.teacher.students.index', compact('students', 'ages', 'genders', 'grades','types', 'params'));
    }

    public function create(Request $request)
    {
      $ages = array_combine(range(8,18),range(8,18));
      $grades = array_combine(range(1,10),range(1,10));
      $types = ['junior'=>'Junior', 'senior'=>'Senior'];
      $genders = ['male'=>'Male', 'female'=>'Female'];
      return view('backend.teacher.students.create', compact('ages', 'genders', 'grades','types'));
    }
  
  
    public function store(Request $request)
    {
        $this->validate($request, [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 
                array(
                    'required',
                    'string',
                    'unique:users',
                    'email',
                    'max:255'
                ),
        ]);

        $input = [];
        $input['status'] = 0;
        $input['password'] = bcrypt(time());
        $input['school_id'] = \Auth::user()->school_id;
  
        $user = User::create(array_merge($request->all(),$input));
        $user->roles()->attach(Role::where('name', 'student')->first());
  
        return redirect()->route('teacher.students.index')
                        ->with('success', 'Created successfully');
    }  
  
    public function edit(Request $request, $id)
    {
      $student = User::find($id);
      if(\Auth::user()->school_id != $student->school_id){
        return redirect()->back()->with('error', 'Access not allowed');
      }

      $ages = array_combine(range(8,18),range(8,18));
      $grades = array_combine(range(1,10),range(1,10));
      $types = ['junior'=>'Junior', 'senior'=>'Senior'];
      $genders = ['male'=>'Male', 'female'=>'Female'];

      return view('backend.teacher.students.edit', compact('student', 'genders', 'ages','grades','types'));
    }
  
  
    public function update(Request $request, $id){
      $this->validate($request,[
        'first_name' => 'required|string|max:255',
        'last_name' => 'required|string|max:255',
        'email' => 
          array(
            'required',
            'string',
            'unique:users,email,'.$request->input('id'),
            'email',
            'max:255'
          ),
      ]);
  
      User::find($id)->update($request->all());
  
      return redirect()->route('teacher.students.index')
                        ->with('success', 'Updated successfully');
    } 

    public function change_password(Request $request, $teacher_id)
    {
        $item = User::find($teacher_id);

        return view('backend.admin.teacher.change_password', compact('item'));

    }

  public function destroy($id)
  {
    $user = User::find($id);
    $user->delete();

    return redirect()->back();
  }

    public function process_change_password(Request $request)
    {
        $this->validate($request, [
            'password' => 'required|string|min:6|confirmed',
        ]);

        $teacher_id = $request->input('id');

        $password = bcrypt($request->input('password'));

        User::find($teacher_id)->update(['password'=>$password]);

        return redirect()->route('admin.teachers.index')
        ->with('success', 'Password Updated successfully');
    }
}
