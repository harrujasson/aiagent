<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\CommonController;
use App\Models\User;
use Auth;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->common=new CommonController();
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function dashboard(){
        $content['name'] = 'User';
        $content['module'] = 'User';
        $content['title'] = 'User';

        return view('admin.dashboard',$content); 
    }

    function profile(){

        $content['name'] = 'My profile';
        $content['module'] = 'My Profile';
        $content['title'] = 'My Profile';
        $content['r'] = User::where('id',Auth::id())->first();
        return view('admin.profile',$content);
    }
    function profile_edit(){

        $content['name'] = 'My profile';
        $content['module'] = 'My Profile';
        $content['title'] = 'My Profile - Edit' ;
        $content['r'] = User::where('id',Auth::id())->first();
        return view('admin.profile-edit',$content);
    }
    function profile_update(Request $request){
        $request->validate([
            'name' => 'bail|required',
            'email' => 'required|string|email|unique:users,email,'.Auth::id(),
        ]);

        $form_data = $request->all();
        if($request->file('picture')){
            $form_data['picture']=  $this->common->fileUpload($request->file('picture'),  './uploads/profile',1 );
        }
        if($request->input('new_password')!=""){
            $form_data['password'] = bcrypt($request->input('new_password'));
        }
        $data =  User::find(Auth::id());
        if($data->update($form_data)){
            /**Logs Generate */
            logsCreate(
                array(
                    'action_by'=>Auth::id(),
                    'module_name'=>'My Profile',
                    'action'=>'Edit',
                    'message'=>'Edit Profile'
                    )
            );
            $request->session()->flash('success', 'Profile has been updated successfully!');
            return redirect(route('admin.profile'));
        }else{
            $request->session()->flash('error', 'Error!');
            return redirect(route('admin.profile'));
        }
    }


}
