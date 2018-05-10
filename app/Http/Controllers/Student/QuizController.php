<?php

namespace App\Http\Controllers\Student;
use App\Http\Controllers\Controller;

use DB;
use Storage;
use Illuminate\Http\Request;
use App\User;
use App\Quiz;
use App\Role;
use App\Mail\ConfirmedTeacherRegistration;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;

class QuizController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
  
    public function index(Request $request){
      $params = [];
      $params['search'] = $request->input('search');

      $quizzes = Quiz::select();
      $quizzes = $quizzes->orderBy('id', 'desc')->paginate(10);
 
      return view('backend.app.quizzes.index', compact('quizzes', 'params'));
    }

    public function start(Request $request){
      //$quiz = Quiz::find($quiz_id);
      $quiz = \App\Quiz::select()->forToday()->first();

      if(!$quiz){
        return view('backend.app.home');
      }

      if($quiz->isCompletedByUser(\Auth::user()->id)){
        return redirect()->route('student.home');
      }

      return view('backend.app.quizzes.start', compact('quiz'));

    }

    public function show($id)
    {
      $quiz = Quiz::find($id);
      return view('backend.app.quizzes.show', compact('quiz'));
    }

}
