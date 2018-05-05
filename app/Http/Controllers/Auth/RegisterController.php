<?php

namespace App\Http\Controllers\Auth;

use DB;
use App\User;
use App\Role;
use App\Mail\ConfirmTeacherRegistration;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/verify_login';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 
                array(
                    'required',
                    'string',
                    'email',
                    'max:255',
                    'unique:users',
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
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $user = User::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'status' => 0,
            'school_id' => $data['school_id'],
        ]);

        $user
            ->roles()
            ->attach(Role::where('name', 'teacher')->first());

        Mail::to($data['email'])->send(new ConfirmTeacherRegistration());

        return $user;
    }

   /* public function register(Request $request)
    {
        $this->validator($request->all());
        $this->create($request->all());
        return redirect('registration-success');
    }*/

    public function showRegistrationForm()
    {
        $schools = DB::table('schools')->where('status', 1)->orderBy('name','asc')->get();

        return view('auth/register', ['schools' => $schools]);
    }
}
