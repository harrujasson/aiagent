<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Auth;
use App\Models\User;
use App\Http\Controllers\CommonController;
use Illuminate\Support\Facades\Hash;
use Validator;
use Str;

class StaffController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    protected $common;
    public function __construct(){
        $this->middleware('auth');
        $this->common=new CommonController();
    }

    function create(){
        $content['module'] = 'Staff';
        $content['title'] = 'Create New';
        $content['name'] = 'Staff';
        return view('admin.staff.create',$content);
    }
    public function show(){
        $content['name'] = 'Staff';
        $content['module'] = 'Staff';
        $content['title'] = 'All Staff';
        return view('admin.staff.list',$content);
    }
    public function view($id=''){
        $content['name'] = 'User';
        $content['module'] = 'User';
        $content['title'] = 'View';
        $content['r'] = User::where('id',$id)->first();        
        return view('admin.staff.view',$content);
    }
   
    
    function edit($id=''){
        $record = User::where('id',$id)->first();
        $content['name'] = 'Staff';
        $content['module'] = 'Edit';
        $content['title'] = 'Staff Edit';
        $content['r']=  User::find($id);
        return view('admin.staff.edit',$content);
    }
    function showList(Request $request){
        $record = User::where('role',2);
        if($request->has('status') && $request->get('status')!=""){
            $record->where('status',$request->get('status'));
        }
        if($request->has('role_type') && $request->get('role_type')!=""){
            $record->where('role_type',$request->get('role_type'));
        }
        return Datatables::of($record)
           ->editColumn('status',function($record) {
            if($record->status==0){
                    return '<span class="badge badge-soft-danger" key="t-new">Inactive</span>';
            }else{
                return '<span class="badge badge-soft-success" key="t-new">Active</span>';
            }

            })
            ->editColumn('picture',function($record) {
                if($record->picture!=""){
                    return '<div><img class="rounded-circle avatar-xs" src="'.asset('uploads/profile/'.$record->picture).'" alt=""></div>';
                }else{
                    return '<div class="avatar-xs"><span class="avatar-title rounded-circle">'.substr($record->name,0,1).'</span></div>';
                }
                
            })
            ->editColumn('created_at',function($record) {
                return date("Y-m-d", strtotime($record->created_at));
            })
            ->addColumn('actions',function($record) {
                $actions = '<a href="'. route('admin.staff.edit',$record->id).'" class="on-default"><i class="ti ti-pencil-minus"></i></a>';
                $actions.= '<a href="'. route('admin.staff.view',$record->id).'" class="on-default"><i class="ti ti-eye"></i></a>';
                $actions.= '<a href="javascript:void(0);" data-url="'. route('admin.staff.delete',$record->id).'" class="on-default sa-warning"><i class="ti ti-trash"></i></a>';


                return $actions;
            })
            ->rawColumns(['actions','status','picture'])
            ->make(true);
    }


    function store(Request $request){

        $request->validate([
            'name' => 'required',
            'email' =>'required|unique:users',
            'password' => ['required'],
            'confirm_password' => ['required', 'same:password'],
        ],$this->message_errors());
        $formdata= $request->all();

        $formdata['password'] = Hash::make($request->input('password'));
        if($request->file('picture')){
            $formdata['picture']=  $this->common->fileUpload($request->file('picture'),  './uploads/profile');
        }
        $formdata['role'] = 2;
        $user = new User($formdata);

        if($user->save()){

            $email['name'] = $request->get('name');
            $email['email'] = $formdata['email'];
            $email['password'] = $request->get('password');
            $email['weblink'] = route('login');
            $email['mobilelink'] = 'javascript:void(0);';
            $email['content'] = '';
            $view = view('email_template.welcome',$email);
            $content =$view->render();
            //$this->common->sendSMTPSystem($user->email,"Account Login Details",$content);

            /**Logs Generate */
            logsCreate(
                array(
                    'action_by'=>Auth::id(),
                    'module_name'=>'Staff',
                    'action'=>'Create',
                    'message'=>'New member added'
                    )
            );

            $request->session()->flash('success', 'Staff has been created');
            return redirect()->back();
        }else{
            $request->session()->flash('error', 'Error!');
            return redirect()->back();
        }
    }
    public function update(Request $request,$id){

        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$id
        ],$this->message_errors());

        $data = User::where('id',$id)->first();
        $formdata = $request->all();        
        if($request->input('new_password')!=""){
            $formdata['password'] = bcrypt($request->input('new_password'));
        }

        if($request->file('picture')){
            $formdata['picture']=  $this->common->fileUpload($request->file('picture'),  './uploads/profile');
        }        
        if($data->update($formdata)){
            /**Logs Generate */
            logsCreate(
                array(
                    'action_by'=>Auth::id(),
                    'module_name'=>'Staff',
                    'action'=>'Edit',
                    'message'=>'Edit member'
                    )
            );
            $request->session()->flash('success', 'Staff has updated successfully!');
            return redirect()->back();
        }else{
            $request->session()->flash('error', 'Error!');
            return redirect()->back();
        }
    }
    function delete($id = ''){
        echo User::where("id",$id)->delete();
        die();
    }

    function message_errors(){
        return [
            'name.required'=>'Name required',
            'email.required'=>'Email required',
            'email.unique'=>'Email already exist',
            'password.required' => 'Password required'

        ];
    }
}
