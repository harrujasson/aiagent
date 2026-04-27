<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\H5pController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect(route('login'));
});
Route::get('/home', function () {
    return redirect(route('login'));
});

Auth::routes();
Route::post('login-process',['as'=>"loginsave",'uses'=>"App\Http\Controllers\Auth\LoginController@login"]);

Route::group(['prefix' => 'admin', 'as' => 'admin.','middleware'=>['auth','admin_manager']], function () {
    Route::get('dashboard', ['as'=>'dashboard', 'uses'=>'App\Http\Controllers\Admin\HomeController@dashboard']);
    Route::get('my-porfile', ['as'=>'home', 'uses'=>'App\Http\Controllers\Admin\HomeController@profile']);
    Route::get('my-porfile', ['as'=>'profile', 'uses'=>'App\Http\Controllers\Admin\HomeController@profile']);
    Route::get('profile-edit', ['as'=>'profile-edit', 'uses'=>'App\Http\Controllers\Admin\HomeController@profile_edit']);
    Route::post('my-porfile-save', ['as'=>'my_profile_save', 'uses'=>'App\Http\Controllers\Admin\HomeController@profile_update']);

    /*Vendors*/
    Route::group(['prefix'=>'staff','as'=>'staff.','middleware'=>['admin_manager']],function(){
        Route::get('create',['as'=>'new_user','uses'=>'App\Http\Controllers\Admin\StaffController@create']);
        Route::post('create',['as'=>'new_save','uses'=>'App\Http\Controllers\Admin\StaffController@store']);
        Route::get('manage',['as'=>'manage','uses'=>'App\Http\Controllers\Admin\StaffController@show']);
        Route::get('getAjaxList',['as'=>'showAjaxList','uses'=>'App\Http\Controllers\Admin\StaffController@showList']);
        Route::get('edit/{id}',['as'=>'edit','uses'=>'App\Http\Controllers\Admin\StaffController@edit']);
        Route::post('edit/{id}',['as'=>'edit_save','uses'=>'App\Http\Controllers\Admin\StaffController@update']);
        Route::get('view/{id}',['as'=>'view','uses'=>'App\Http\Controllers\Admin\StaffController@view']);
        Route::get('delete/{id}',['as'=>'delete','uses'=>'App\Http\Controllers\Admin\StaffController@delete']);
    });

    Route::group(['prefix'=>'task','as'=>'task.','middleware'=>['admin_manager']],function(){
        Route::get('create',['as'=>'new','uses'=>'App\Http\Controllers\Admin\TaskController@create']);
        Route::post('create',['as'=>'new_save','uses'=>'App\Http\Controllers\Admin\TaskController@store']);
        Route::get('manage',['as'=>'manage','uses'=>'App\Http\Controllers\Admin\TaskController@show']);
        Route::get('getAjaxList',['as'=>'showAjaxList','uses'=>'App\Http\Controllers\Admin\TaskController@showList']);
        Route::get('edit/{id}',['as'=>'edit','uses'=>'App\Http\Controllers\Admin\TaskController@edit']);
        Route::post('edit/{id}',['as'=>'edit_save','uses'=>'App\Http\Controllers\Admin\TaskController@update']);
        Route::get('view/{id}',['as'=>'view','uses'=>'App\Http\Controllers\Admin\TaskController@view']);
        Route::post('comment/{id}/staff/{staffId}',['as'=>'comment_staff_save','uses'=>'App\Http\Controllers\Admin\TaskController@addCommentForStaff']);
        Route::get('delete/{id}',['as'=>'delete','uses'=>'App\Http\Controllers\Admin\TaskController@delete']);
        Route::post('status/{id}',['as'=>'status_update','uses'=>'App\Http\Controllers\Admin\TaskController@updateStatus']);
    });

    /*Users*/
    Route::group(['prefix'=>'customer','as'=>'customer.','middleware'=>['admin_manager']],function(){
        Route::get('manage',['as'=>'manage','uses'=>'App\Http\Controllers\Admin\CustomerController@show']);
        Route::get('getAjaxList',['as'=>'showAjaxList','uses'=>'App\Http\Controllers\Admin\CustomerController@showList']);
        Route::get('edit/{id}',['as'=>'edit','uses'=>'App\Http\Controllers\Admin\CustomerController@edit']);
        Route::post('edit/{id}',['as'=>'edit_save','uses'=>'App\Http\Controllers\Admin\CustomerController@update']);
        Route::get('view/{id}',['as'=>'view','uses'=>'App\Http\Controllers\Admin\CustomerController@view']);
        Route::get('delete/{id}',['as'=>'delete','uses'=>'App\Http\Controllers\Admin\CustomerController@delete']);
    });

    /***Package */
    Route::group(['prefix'=>'subscription','as'=>'package.'],function(){
        Route::get('add-new',['as'=>'new','uses'=>'App\Http\Controllers\Admin\PackageController@create']);
        Route::post('add-new',['as'=>'new_save','uses'=>'App\Http\Controllers\Admin\PackageController@store']);
        Route::get('manage',['as'=>'manage','uses'=>'App\Http\Controllers\Admin\PackageController@show']);
        Route::get('getAjaxList',['as'=>'showAjaxList','uses'=>'App\Http\Controllers\Admin\PackageController@showList']);
        Route::get('edit/{id}',['as'=>'editForm','uses'=>'App\Http\Controllers\Admin\PackageController@edit']);
        Route::post('edit/{id}',['as'=>'edit_update','uses'=>'App\Http\Controllers\Admin\PackageController@update']);
        Route::get('deleteAjax/{id}',['as'=>'deleteAjax','uses'=>'App\Http\Controllers\Admin\PackageController@delete']);

    });

    Route::group(['prefix'=>'package-feature','as'=>'pfeature.'],function(){
        Route::get('add-new',['as'=>'new','uses'=>'App\Http\Controllers\Admin\PackageFeatureController@create']);
        Route::post('add-new',['as'=>'new_save','uses'=>'App\Http\Controllers\Admin\PackageFeatureController@store']);
        Route::get('manage',['as'=>'manage','uses'=>'App\Http\Controllers\Admin\PackageFeatureController@show']);
        Route::get('getAjaxList',['as'=>'showAjaxList','uses'=>'App\Http\Controllers\Admin\PackageFeatureController@showList']);
        Route::get('edit/{id}',['as'=>'editForm','uses'=>'App\Http\Controllers\Admin\PackageFeatureController@edit']);
        Route::post('edit/{id}',['as'=>'edit_update','uses'=>'App\Http\Controllers\Admin\PackageFeatureController@update']);
        Route::get('deleteAjax/{id}',['as'=>'deleteAjax','uses'=>'App\Http\Controllers\Admin\PackageFeatureController@delete']);

    });

    Route::group(['prefix'=>'category','as'=>'category.'],function(){
        Route::get('create',['as'=>'new','uses'=>'App\Http\Controllers\Admin\CategoryController@create']);
        Route::post('create',['as'=>'new_save','uses'=>'App\Http\Controllers\Admin\CategoryController@store']);
        Route::get('manage',['as'=>'manage','uses'=>'App\Http\Controllers\Admin\CategoryController@show']);
        Route::get('getAjaxList',['as'=>'showAjaxList','uses'=>'App\Http\Controllers\Admin\CategoryController@showList']);
        Route::get('edit/{id}',['as'=>'edit','uses'=>'App\Http\Controllers\Admin\CategoryController@edit']);
        Route::post('edit/{id}',['as'=>'edit_save','uses'=>'App\Http\Controllers\Admin\CategoryController@update']);
        Route::get('view/{id}',['as'=>'view','uses'=>'App\Http\Controllers\Admin\CategoryController@view']);
        Route::get('delete/{id}',['as'=>'delete','uses'=>'App\Http\Controllers\Admin\CategoryController@delete']);
    });

    Route::group(['prefix'=>'giveaway','as'=>'giveaway.'],function(){
        Route::get('create',['as'=>'new','uses'=>'App\Http\Controllers\Admin\GiveAwayController@create']);
        Route::post('create',['as'=>'new_save','uses'=>'App\Http\Controllers\Admin\GiveAwayController@store']);
        Route::get('manage',['as'=>'manage','uses'=>'App\Http\Controllers\Admin\GiveAwayController@show']);
        Route::get('getAjaxList',['as'=>'showAjaxList','uses'=>'App\Http\Controllers\Admin\GiveAwayController@showList']);
        Route::get('edit/{id}',['as'=>'edit','uses'=>'App\Http\Controllers\Admin\GiveAwayController@edit']);
        Route::post('edit/{id}',['as'=>'edit_save','uses'=>'App\Http\Controllers\Admin\GiveAwayController@update']);
        Route::get('view/{id}',['as'=>'view','uses'=>'App\Http\Controllers\Admin\GiveAwayController@view']);
        Route::get('delete/{id}',['as'=>'delete','uses'=>'App\Http\Controllers\Admin\GiveAwayController@delete']);
        Route::get('getAjaxListEnrolled/{id}',['as'=>'showAjaxListEnrolled','uses'=>'App\Http\Controllers\Admin\GiveAwayController@showListEnrolled']);
        Route::post('publish-winner/{id}',['as'=>'publishwinner','uses'=>'App\Http\Controllers\Admin\GiveAwayController@publishwinner']);
    });

    /*Settings*/
    Route::group(['prefix'=>'settings','as'=>'setting.'],function(){
        Route::get('common',['as'=>'common','uses'=>'App\Http\Controllers\Admin\SettingController@common']);
        Route::post('common-update',['as'=>'common_update','uses'=>'App\Http\Controllers\Admin\SettingController@common_save']);
    });


    Route::group(['prefix'=>'notifications','as'=>'notifications.'],function(){
        Route::get('manage',['as'=>'manage','uses'=>'App\Http\Controllers\Admin\NotificationsController@show']);
    });
    Route::group(['prefix'=>'logs','as'=>'log.'],function(){
        Route::get('manage',['as'=>'manage','uses'=>'App\Http\Controllers\Admin\LogsController@show']);
        Route::get('getAjaxList',['as'=>'showAjaxList','uses'=>'App\Http\Controllers\Admin\LogsController@showList']);
        Route::post('delete-all',['as'=>'deletall','uses'=>'App\Http\Controllers\Admin\LogsController@deleteAll']);
    });
});

Route::group(['prefix' => 'staff', 'as' => 'staff.','middleware'=>['auth','staff']], function () {
    Route::get('dashboard', ['as'=>'dashboard', 'uses'=>'App\Http\Controllers\Staff\HomeController@dashboard']);
    Route::get('my-porfile', ['as'=>'home', 'uses'=>'App\Http\Controllers\Staff\HomeController@profile']);
    Route::get('my-porfile', ['as'=>'profile', 'uses'=>'App\Http\Controllers\Staff\HomeController@profile']);
    Route::post('my-porfile-save', ['as'=>'my_profile_save', 'uses'=>'App\Http\Controllers\Staff\HomeController@profile_update']);

    Route::get('profile-edit', ['as'=>'profile-edit', 'uses'=>'App\Http\Controllers\Staff\HomeController@profile_edit']);

    Route::group(['prefix'=>'task','as'=>'task.'],function(){
        Route::get('manage',['as'=>'manage','uses'=>'App\Http\Controllers\Staff\TaskController@show']);
        Route::get('view/{id}',['as'=>'view','uses'=>'App\Http\Controllers\Staff\TaskController@view']);
        Route::post('comment/{id}',['as'=>'comment_save','uses'=>'App\Http\Controllers\Staff\TaskController@addComment']);
    });


});

Route::get('user-register', [App\Http\Controllers\Auth\RegisterController::class, 'user_register'])->name('user_register');
Route::post('user-register-proccess', [App\Http\Controllers\Auth\RegisterController::class, 'customer_register_process'])->name('user_register_process');