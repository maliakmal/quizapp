<?php

namespace App\Http\Controllers\Admin;
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
    
      if (isset($params['search'])) {
        $quizzes = $quizzes->where('title',  'LIKE', '%'. $params['search'] .'%');
      }

      $quizzes = $quizzes->orderBy('id', 'desc')->paginate(10);
 
      return view('backend.admin.quizzes.index', compact('quizzes', 'params'));
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

    public function create(Request $request)
    {
        return view('backend.admin.quizzes.create');
    }
  
  
    public function store(Request $request)
    {
        Quiz::create($request->only(Quiz::$fillables));
        return redirect()->route('admin.quizzes.index')
                        ->with('success', 'Created successfully');
    }  
  
    public function edit(Request $request, $id)
    {
        $quiz = Quiz::find($id);
        return view('backend.admin.quizzes.edit', compact('quiz'));
    }

    public function publish(Request $request, $id){
        $quiz = Quiz::find($id);
        $quiz->publish();
        return redirect()->back();;
    }

    public function unpublish(Request $request, $id){
        $quiz = Quiz::find($id);
        $quiz->unpublish();
        return redirect()->back();;
    }
  
    public function update(Request $request, $id)
    {
  
        Quiz::find($id)->update($request->all());
  
        return redirect()->route('admin.quizzes.index')
                        ->with('success', 'Updated successfully');
    } 

    public function show($id)
    {
        $quiz = Quiz::find($id);
        return view('backend.admin.quizzes.show', compact('quiz'));
    }

    public function import(Request $request) {
        return view('backend.admin.school.import');
    }

    public function postImport(Request $request) {

        $file = $request->file('csv');

        $ext = $file->getClientOriginalExtension();
        if ($ext != 'csv') {
            return redirect()->route('admin.schools.mass_upload')
            ->with('error', 'Only CSV is allowed');
        }

        $path = $file->getRealPath();
        $data = array_map('str_getcsv', file($path));
        
        if (count($data) > 0) {
            foreach($data as $d) {
                $school_name = $d[0];
                $city = $d[1];
                $country = $d[2];

                School::create(['name'=>$school_name,'city'=>$city,'country'=>$country,'status'=>1]);
            }
        }

        return redirect()->route('admin.schools.index')
                        ->with('success', 'Data imported successfully');
    }
}
