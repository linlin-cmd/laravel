<?php

namespace App\model\hadmin;

use Illuminate\Database\Eloquent\Model;

class Hadmin_goods_attribute extends Model
{
    protected $table = 'hadmin_goods_attribute';
    public $timestamps = false;
    protected $primaryKey = 'goods_attribute_id';
    protected $fillable = ['goods_attribute_id','goods_id','attribute_id','attribute_value','attribute_price'];
}
