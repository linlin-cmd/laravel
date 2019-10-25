<?php

namespace App\model\hadmin;

use Illuminate\Database\Eloquent\Model;

class Hadmin_type extends Model
{
    protected $table = 'hadmin_type';
    public $timestamps = false;
    protected $primaryKey = 'type_id';
    protected $fillable = ['type_id','type_name'];
}
