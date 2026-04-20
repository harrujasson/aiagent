<?php

namespace App\Http\Controllers\Vendors;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;
use App\Http\Controllers\CommonController;
use App\Models\Services;
use Auth;


class NotificationsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    protected $common;
    public function __construct()
    {
        $this->common=new CommonController();
    }

    public function create(){
        $content['module'] = 'Services ';
        $content['title'] = 'Add/Edit Notifications';
        $content['name'] = 'Services';
        return view('vendors.notifications.create',$content);
    }
    public function show(){
        $content['module'] = 'Manage';
        $content['title'] = 'All Notifications';
        $content['name'] = 'Manage';
        return view('vendors.notifications.manage',$content);
    }
    public function edit(){
        $content['module'] = 'Services';
        $content['title'] = 'Add/Edit Notifications';
        $content['name'] = 'Services';
        return view('vendors.notifications.edit',$content);  
    }

    
}
