<?php

namespace App\model\api;

use Illuminate\Database\Eloquent\Model;

class Goods extends Model
{
    protected $table = 'kao_goods';//表名
    public $timestamps = false;//时间
    protected $fillable = ['goods_id','goods_name','goods_money','goods_img'];//字段
}
