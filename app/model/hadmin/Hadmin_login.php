<?php

namespace App\model\hadmin;

use Illuminate\Database\Eloquent\Model;

class Hadmin_login extends Model
{
    protected $table = 'hadmin_login';
    public $timestamps = false;
    protected $primaryKey = 'login_id';
    protected $fillable = ['login_id','login_name','login_password','token','overdue_time'];
}
