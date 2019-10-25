<?php

namespace App\model\hadmin;

use Illuminate\Database\Eloquent\Model;

class Hadmin_attribute extends Model
{
    protected $table = 'hadmin_attribute';
    public $timestamps = false;
    protected $primaryKey = 'attribute_id';
    protected $fillable = ['attribute_id','attribute_name','goods_type','is_attribute'];
}
