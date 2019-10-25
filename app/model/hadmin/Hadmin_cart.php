<?php

namespace App\model\hadmin;

use Illuminate\Database\Eloquent\Model;

class Hadmin_cart extends Model
{
    protected $table = 'hadmin_cart';
    public $timestamps = false;
    protected $primaryKey = 'cart_id';
    protected $fillable = ['cart_id','goods_id','login_id','goods_attribute_id','cart_number','stock_id','is_number'];
}
