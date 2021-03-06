<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\School;
use App\Role;
use App\Mail\ConfirmedTeacherRegistration;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;

class BackendAdminTeacherController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
  
    public function index(Request $request)
    {
      $request->user()->authorizeRoles(['admin']);   
      $search = $request->input('search');
  
      if ($search) {
          $items = User::orderByRaw("FIELD(users.status, 0, 1, 2), users.created_at DESC")
          ->join('role_user', 'users.id', '=', 'role_user.user_id')
          ->where('role_id', 2)
          ->withName($search)
          ->select('users.id','users.first_name','users.last_name','users.email','users.status','users.school')
          ->paginate(10);
      } else {
            $items = User::orderByRaw("FIELD(users.status, 0, 1, 2), users.created_at DESC")
            ->join('role_user', 'users.id', '=', 'role_user.user_id')
            ->where('role_id', 2)
            ->select('users.id','users.first_name','users.last_name','users.email','users.status','users.school')
            ->paginate(10);
      }

      //dd($items);
  
      return view('backend.admin.teacher.index', compact('items'))
                      ->with('i', ($request->input('page', 1) - 1) * 10)
                      ->with('search', $search);
    }

    public function statuses(Request $request)
    {
        $request->user()->authorizeRoles(['admin']);
        $status = $request->input('status');
        $teacher_id = $request->input('teacher_id');
      
        $user = user::find($teacher_id);
        $user->update(['status' => $status]);

        if ($status == 1) {
            $token = Password::getRepository()->create($user);
            Mail::to($user->email)->send(new ConfirmedTeacherRegistration($user, $token));
        }
  
        return redirect()->route('admin.teachers.index')
                        ->with('success', 'Updated successfully!');
        
    }

    public function create(Request $request)
    {
        $request->user()->authorizeRoles(['admin']);
        $schools = School::where('status', 1)->pluck('name','id');
    
        return view('backend.admin.teacher.create', compact('schools'));
    }
  
  
    public function store(Request $request)
    {
        $request->user()->authorizeRoles(['admin']);
        $this->validate($request, [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 
                array(
                    'required',
                    'string',
                    'unique:users',
                    'email',
                    'max:255',
                    function ($attribute, $value, $fail) {
                        $not_allowed_accounts = ['hotmail', 'gmail', 'live', 'outlook','msn','yahoo'];
                        foreach ($not_allowed_accounts as $account) {
                            if (stristr($value, "@".$account) !== false) {
                                $account = ucfirst($account);
                                $fail("No $account accounts allowed");
                            }
                        }
                    }
                ),
        ]);

        $input = [];
        $input['status'] = 0;
        $input['password'] = bcrypt(time());
  
        $user = User::create(array_merge($request->all(),$input));
        
        $user
        ->roles()
        ->attach(Role::where('name', 'teacher')->first());
  
        return redirect()->route('admin.teachers.index')
                        ->with('success', 'Created successfully');
    }  
  
    public function edit(Request $request, $id)
    {
        $request->user()->authorizeRoles(['admin']);
        $item = User::find($id);
        $schools = School::where('status', 1)->pluck('name','id');
    
        return view('backend.admin.teacher.edit', compact('item', 'schools'));
    }
  
  
    public function update(Request $request, $id)
    {
        $request->user()->authorizeRoles(['admin']);
        $this->validate($request,[
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 
                array(
                    'required',
                    'string',
                    'unique:users,email,'.$request->input('id'),
                    'email',
                    'max:255',
                    function ($attribute, $value, $fail) {
                        $not_allowed_accounts = ['hotmail', 'gmail', 'live', 'outlook','msn','yahoo'];
                        foreach ($not_allowed_accounts as $account) {
                            if (stristr($value, "@".$account) !== false) {
                                $account = ucfirst($account);
                                $fail("No $account accounts allowed");
                            }
                        }
                    }
                ),
        ]);
  
        User::find($id)->update($request->all());
  
        return redirect()->route('admin.teachers.index')
                        ->with('success', 'Updated successfully');
    } 

    public function change_password(Request $request, $teacher_id)
    {
        $request->user()->authorizeRoles(['admin']);
        $item = User::find($teacher_id);

        return view('backend.admin.teacher.change_password', compact('item'));

    }

    public function process_change_password(Request $request)
    {
        $request->user()->authorizeRoles(['admin']);

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
