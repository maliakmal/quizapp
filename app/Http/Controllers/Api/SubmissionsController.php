<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;

use DB;
use Storage;
use Illuminate\Http\Request;
use App\User;
use App\Quiz;
use App\Question;
use App\Submission;
use App\Role;
use App\Mail\ConfirmedTeacherRegistration;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;

class SubmissionsController extends Controller
{
  
    public function store(Request $request){
        $input = $request->all();
        $data = [];
        $data['start_at'] = $input['data']['start_at'];
        $data['end_at'] = \DB::raw('NOW()');
        $data['quiz_id'] = $input['data']['quiz'];
        $data['user_id'] = $input['data']['user'];
        $data['body'] = $input['data']['questions'];
        $data['score'] = $input['data']['score'];
        $data['total_score'] = $input['data']['total_score'];
        $submission = Submission::create($data);
        $result = $submission->score == 0?'0':ceil(($submission->score/$submission->total_score)*100);
        return $result;
    }
  
}
