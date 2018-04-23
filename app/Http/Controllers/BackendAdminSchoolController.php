<?php

namespace App\Http\Controllers;

use DB;
use Storage;
use Illuminate\Http\Request;
use App\User;
use App\School;
use App\Role;
use App\Mail\ConfirmedTeacherRegistration;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;

class BackendAdminSchoolController extends Controller
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
          $items = School::orderBy('id', 'desc')
          ->where('name',  'LIKE', '%'. $search .'%')
          ->paginate(10);
      } else {
        $items = School::orderBy('id', 'desc')
         ->paginate(10);
      }

      //dd($items);
  
      return view('backend.admin.school.index', compact('items'))
                      ->with('i', ($request->input('page', 1) - 1) * 10)
                      ->with('search', $search);
    }

    public function statuses(Request $request)
    {
        $request->user()->authorizeRoles(['admin']);
        $status = $request->input('status');
        $school_id = $request->input('school_id');
        
        DB::table('schools')
            ->where('id', $school_id)
            ->update(['status' => $status]);

        return redirect()->route('admin.schools.index')
                        ->with('success', 'Updated successfully');
        
    }

    public function create(Request $request)
    {
        $request->user()->authorizeRoles(['admin']);
        return view('backend.admin.school.create');
    }
  
  
    public function store(Request $request)
    {
        $request->user()->authorizeRoles(['admin']);
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
        $request->user()->authorizeRoles(['admin']);
        $item = School::find($id);
        return view('backend.admin.school.edit', compact('item'));
    }
  
    public function update(Request $request, $id)
    {
        $request->user()->authorizeRoles(['admin']);
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

    public function mass_upload(Request $request) {
        $request->user()->authorizeRoles(['admin']);
        return view('backend.admin.school.mass_upload');
    }

    public function store_mass_upload(Request $request) {
        $request->user()->authorizeRoles(['admin']);

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
