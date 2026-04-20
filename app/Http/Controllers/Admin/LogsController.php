<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Auth;
use App\Models\Logsaction;
use App\Models\User;
use App\Http\Controllers\CommonController;
use Illuminate\Support\Facades\Hash;
use Validator;
use Carbon\Carbon;
use DB;

class LogsController extends Controller
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
    public function show(){
        $content['name'] = 'Logs';
        $content['module'] = 'Logs';
        $content['title'] = 'All Logs';
        $content['users'] = User::where('status',1)->get();
        return view('admin.Logsaction.list',$content);
    }

    function showList(Request $request){
        $record = Logsaction::query();
        if($request->has('userby')){
            if($request->get('userby')!=""){
                $record->where('action_by',$request->get('userby'));
            }
        }
        if($request->has('invfrom')){
            if($request->get('invfrom')!=""){
                $record->whereDate('created_at','>=',new Carbon($request->get('invfrom')));
            }
        }
        if($request->has('invto')){
            if($request->get('invto')!=""){
                $record->whereDate('created_at','<=',new Carbon($request->get('invto')));
            }
        }
        return Datatables::of($record)
            ->editColumn('uploaded_by',function($record) {
                return userInfo($record->uploaded_by,'name').' '.userInfo($record->uploaded_by,'last_name');
            })
            ->addColumn('select_all',function($record) {
                return '<input type="checkbox" class="select_field" value="'.$record->id.'" name="select_field[]" >';
            })
            ->editColumn('created_at',function($record) {
                return date('m-d-Y h:i a',strtotime($record->created_at));
            })
            ->rawColumns(['actions','select_all','file'])
            ->make(true);
    }

    function deleteAll(Request $request){
        if($request->has('select_field')){
            foreach($request->input('select_field') as $id){
                Logsaction::where("id",$id)->delete();
            }
            return "1";
        }else{
            return "2";
        }
    }
}
