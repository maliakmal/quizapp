<?php

namespace App\Http\Controllers\Student;

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
  
    public function home(Request $request)
    {
      $params = [];
  

      return view('backend.app.home');
    }

}
