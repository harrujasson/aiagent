<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\Cookie;
use Hash;
use App\Http\Controllers\CommonController;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;
    protected $common;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->common=new CommonController();
    }

    public function login(Request $request) {
        $this->validate($request, [
           'email' => 'required|string|max:255',
           'password' => 'required|string',
           ]
         );
       $remember = ($request->input('remember')) ? true : false;

       $email=$request->input('email');
       $password=$request->input('password');
        $auth = Auth::attempt(
            [
                'email'  => strtolower($request->input('email')),
                'password'  => $request->input('password'),
                'status' => 1
            ]
        );
       if($auth){
            $this->updateInformation();
           if($remember){

               Cookie::queue("login_username", $email);
               Cookie::queue("login_password", $password);
           }
            if(Auth::user()->role=='1'){
                return redirect(route('admin.dashboard'));
            }else if(Auth::user()->role=='2'){
                return redirect(route('staff.dashboard'));
            }

       }else{
           $request->session()->flash('error', 'Your User Name/password combination was incorrect.!');
           return redirect(route('login'));
       }

    }

    function login_ajax(Request $request){

        if(!$request->has('orgz')){
            return response()->json(['status'=>0,'message'=>'Invalid Organization.'], 200);
        }
        $orgz  = decode($request->get('orgz'));
        if(User::where('company_id',$orgz)->where('role',2)->count() < 1){
            return response()->json(['status'=>0,'message'=>'No Organization Found!.'], 200);
        }


        $email=$request->input('email');
        $password=$request->input('password');
        $auth = Auth::attempt(
             [
                 'email'  => strtolower($request->input('email')),
                 'password'  => $request->input('password'),
                 'status' => 1
             ]
         );
         
        if($auth){
             $this->updateInformation();
             return response()->json(['status'=>1,'message'=>'Login successfully!'], 200);
        }else{
            return response()->json(['status'=>0,'message'=>'Invalid login details'], 200);
        }
    }

    
    function logout(Request $request) {
        $this->updateInformation('1');
        $role =Auth::user()->role;
        Auth::logout();
        session_start();
        session_destroy();
        return redirect(route('login'));
    }

    function updateInformation($type='is_login'){
        $info = User::where('id',Auth::id());
        if($type == 'is_login'){
            $form['is_login'] = 1;
        }else{
            $form['is_login'] = 0;
        }

        $form['login_ip'] = $_SERVER['REMOTE_ADDR'];
        $form['last_login'] = date('Y-m-d h:i');
        $info->update($form);
    }

}
