<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{ 

    protected $table="settings";
    protected $fillable = [
        'logo',
        'login_logo',
        'email_logo',
        'logo_invoice',
        'favicon',
        'logo_sm',
        'company_name',
        'company_address',
        'company_phone',
        'company_email'
    ];
}
