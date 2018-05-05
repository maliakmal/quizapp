<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use DB;
use Storage;
use Illuminate\Http\Request;
use App\User;
use App\School;
use App\Role;
use App\Mail\ConfirmedTeacherRegistration;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;

class SchoolController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
  
    public function index(Request $request){
      $params = [];
      $params['search'] = $request->input('search');

      $schools = School::select();
    
      if (isset($params['search'])) {
        $schools = $schools->where('name',  'LIKE', '%'. $params['search'] .'%');
      }

      $schools = $schools->orderBy('id', 'desc')->paginate(10);
 
      return view('backend.admin.school.index', compact('schools', 'params'));
    }

    public function updateStatus(Request $request)
    {
        $status = $request->input('status');
        $school_id = $request->input('school_id');
        $school = School::find($school_id);
        $school->status = $status;;
        $school->save();

        return redirect()->route('admin.schools.index')
                        ->with('success', 'Status Updated to '.$status.' successfully');
        
    }

    public function create(Request $request)
    {
        return view('backend.admin.school.create');
    }
  
  
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'city' => 'required',
            'country' => 'required'
        ]);

        School::create($request->all());

        return redirect()->route('admin.schools.index')
                        ->with('success', 'Created successfully');
    }  
  
    public function edit(Request $request, $id)
    {
        $school = School::find($id);
        return view('backend.admin.school.edit', compact('school'));
    }
  
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'city' => 'required',
            'country' => 'required'
        ]);
  
        School::find($id)->update($request->all());
  
        return redirect()->route('admin.schools.index')
                        ->with('success', 'Updated successfully');
    } 

    public function show()
    {
        echo 'ddd';
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
