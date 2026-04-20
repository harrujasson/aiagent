<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;


class User extends Authenticatable
{
    use  HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'middle_name',
        'last_name',
        'email',
        'password',
        'picture',
        'status',
        'role',
        'role_type',
        'street',
        'address',
        'address2',
        'city',
        'state' ,
        'country',
        'zipcode',
        'phone',
        'company_name',
        'is_login',
        'login_ip',
        'last_login',
        'dateofbirth',
        'gender',
        'phone_code',
        'stripe_customer_id',
        'website'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function isAdmin(){
        if($this->role == 1){
            return true;
        }
        else {
            return false;
        }
    }
    public function isStaff(){
        if($this->role == 2){
            return true;
        }
        else {
            return false;
        }
    }
}
