<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class news extends Model
{
    protected $table = 'news';
    public $timestamps = false;
    protected $primaryKey = 'news_id';
    protected $fillable = ['news_head','news_man','news_cont','add_time'];
}
