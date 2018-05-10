<?php

namespace App\Http\Controllers\Api;
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
        $data = $request->all();
        $question = Question::create($data['data']);

        $quiz = Quiz::find($question->quiz_id);
        $quiz->resetTotalScore();
        $quiz->save();
        return $question;
    }
  
  
    public function update(Request $request, $id){
        $data = $request->all();

        $question = Question::find($id);
        $question->update($data['data']);
        $quiz = Quiz::find($question->quiz_id);
        $quiz->resetTotalScore();
        $quiz->save();
    } 

    public function show($id)
    {
        $quiz = Question::find($id);
        return $quiz;
    }

    public function destroy($id)
    {
        $question = Question::find($id);
        $quiz = Quiz::find($question->quiz_id);
        $question->delete();
        $quiz->resetTotalScore();
        $quiz->save();


    }
}
