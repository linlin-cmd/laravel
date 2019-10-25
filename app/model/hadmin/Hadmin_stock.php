<?php

namespace App\model\hadmin;

use Illuminate\Database\Eloquent\Model;

class Hadmin_stock extends Model
{
    protected $table = 'hadmin_stock';
    public $timestamps = false;
    protected $primaryKey = 'stock_id';
    protected $fillable = ['stock_id','goods_id','goods_stock','goods_attribute_id'];
}
