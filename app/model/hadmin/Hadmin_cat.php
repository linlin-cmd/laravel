<?php

namespace App\model\hadmin;

use Illuminate\Database\Eloquent\Model;

class Hadmin_cat extends Model
{
    protected $table = 'hadmin_cat';
    public $timestamps = false;
    protected $primaryKey = 'cat_id';
    protected $fillable = ['cat_id','cat_name','parent_id'];
}
