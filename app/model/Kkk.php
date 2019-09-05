<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class Kkk extends Model
{
    protected $table = 'kkk';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = ['id','name','age','address','status'];
}
