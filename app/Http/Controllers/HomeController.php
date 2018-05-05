<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    { 
        return view('home');
    }

    public function registration_success()
    {
        return view('registration_success');
    }

    public function verify_login(Request $request)
    {
       $user_id = Auth::user()->id;
    
       $user = User::join('role_user', 'users.id', '=', 'role_user.user_id')
       ->where('users.id', $user_id)
       ->select('users.id','users.first_name','users.last_name','users.email','users.status','users.school_id', 'role_id')
       ->first();

       if ($user->role_id != '1') {
            Auth::logout();
            return redirect('registration-success');
       }
       
       return redirect('admin/teachers');
    }

    /*public function admin(Request $request)
    { 
        $request->user()->authorizeRoles(['admin']);
        
        echo 'Only Admin allowed';
    }

    public function teacher(Request $request)
    { 
        $request->user()->authorizeRoles(['admin', 'teacher']);

        echo 'Only Teacher allowed';
    }

    public function student(Request $request)
    { 
        $request->user()->authorizeRoles(['admin', 'student']);

        echo 'Only Student allowed';
    }*/

    
}
