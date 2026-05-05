<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Logsaction extends Model
{
    protected $table="logsaction";
    protected $fillable = [
        'action_by',
        'module_name',
        'action',
        'message'
    ];


    
}
