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

Route::group(['prefix' => 'admin', 'as' => 'admin.','middleware'=>['auth','admin']], function () {
    Route::get('dashboard', ['as'=>'dashboard', 'uses'=>'App\Http\Controllers\Admin\HomeController@dashboard']);
    Route::get('my-porfile', ['as'=>'home', 'uses'=>'App\Http\Controllers\Admin\HomeController@profile']);
    Route::get('my-porfile', ['as'=>'profile', 'uses'=>'App\Http\Controllers\Admin\HomeController@profile']);
    Route::get('profile-edit', ['as'=>'profile-edit', 'uses'=>'App\Http\Controllers\Admin\HomeController@profile_edit']);
    Route::post('my-porfile-save', ['as'=>'my_profile_save', 'uses'=>'App\Http\Controllers\Admin\HomeController@profile_update']);

    /*Staff*/
    Route::group(['prefix'=>'staff','as'=>'staff.','middleware'=>['admin']],function(){
        Route::get('create',['as'=>'new_user','uses'=>'App\Http\Controllers\Admin\StaffController@create']);
        Route::post('create',['as'=>'new_save','uses'=>'App\Http\Controllers\Admin\StaffController@store']);
        Route::get('manage',['as'=>'manage','uses'=>'App\Http\Controllers\Admin\StaffController@show']);
        Route::get('getAjaxList',['as'=>'showAjaxList','uses'=>'App\Http\Controllers\Admin\StaffController@showList']);
        Route::get('edit/{id}',['as'=>'edit','uses'=>'App\Http\Controllers\Admin\StaffController@edit']);
        Route::post('edit/{id}',['as'=>'edit_save','uses'=>'App\Http\Controllers\Admin\StaffController@update']);
        Route::get('view/{id}',['as'=>'view','uses'=>'App\Http\Controllers\Admin\StaffController@view']);
        Route::get('delete/{id}',['as'=>'delete','uses'=>'App\Http\Controllers\Admin\StaffController@delete']);
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


});

Route::get('user-register', [App\Http\Controllers\Auth\RegisterController::class, 'user_register'])->name('user_register');
Route::post('user-register-proccess', [App\Http\Controllers\Auth\RegisterController::class, 'customer_register_process'])->name('user_register_process');