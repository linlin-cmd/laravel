<?php

namespace App\model\hadmin;

use Illuminate\Database\Eloquent\Model;

class Hadmin_goods extends Model
{
    protected $table = 'hadmin_goods';
    public $timestamps = false;
    protected $primaryKey = 'goods_id';
    protected $fillable = ['goods_id','goods_name','cat_id','goods_sn','goods_price','goods_img','goods_visit'];
}
