<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use DB;
use Storage;
use Illuminate\Http\Request;
use App\User;
use App\Quiz;
use App\Question;
use App\Role;
use App\Mail\ConfirmedTeacherRegistration;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;

class QuestionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
  
    public function index(Request $request){
        $params = [];
        $params['search'] = $request->input('search');
        $params['quiz_id'] = $request->input('quiz_id');

        $questions = Question::select();

        if (isset($params['search']) && !empty(isset($params['search']))) {
            $questions = $questions->where('title',  'LIKE', '%'. $params['search'] .'%');
        }

        if (isset($params['quiz_id']) && !empty(isset($params['quiz_id']))) {
            $questions = $questions->where('quiz_id',  '=', $params['quiz_id']);
        }

        $questions = $questions->get();

        return $questions;
    }

    public function updateStatus(Request $request)
    {
        $status = $request->input('status');
        $quiz_id = $request->input('quiz_id');
        $quiz = Quiz::find($quiz_id);
        $quiz->state = $status;;
        $quiz->save();

        return redirect()->route('admin.quizzes.index')
                        ->with('success', 'Status Updated to '.$status.' successfully');
        
    }

    public function store(Request $request){
        $question = Question::create($request->all());
        return $question;
    }
  
  
    public function update(Request $request, $id){
        $question = Question::find($id)->update($request->all());
    } 

    public function show($id)
    {
        $quiz = Question::find($id);
        return $quiz;
    }
}
