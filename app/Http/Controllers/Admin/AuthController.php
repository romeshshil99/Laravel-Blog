<?php

namespace App\Http\Controllers\Admin;

use App\Admin;
use Validator;
use Auth;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/admin/home';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware($this->guestMiddleware(), ['except' => 'logout']);
    }

    
    public function login() {

        return view('auth.login');
    }


    public function doLogin( Request $requests) 
        {
            $loginUser=[
                'uname' => $requests->Input('uname'), 
                'password' => $requests->Input('password')
                ];
            $auth=Auth()->guard('admins');  
            if($auth->attempt($loginUser))
            { 
                $auth->login($auth->user());
                return redirect('/admin/home');
            } else {

                return 'problem';
            }

           
             }




    	public function getRegister() {
        	return view('admin.register');
        }

        public function postRegister(Request $request)
	    {
	        $validator = $this->validator($request->all());

	        if ($validator->fails()) {
	            $this->throwValidationException(
	                $request, $validator
	            );
	        }

	        Auth::guard('admin')->login($this->create($request->all()));

	        return redirect($this->redirectPath());
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
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return Admin::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }
}