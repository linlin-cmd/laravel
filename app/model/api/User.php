<?php

namespace App\model\api;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'api_user';
    public $timestamps = false;//时间
    protected $primaryKey = 'id';//主键
    protected $fillable = ['id','name','age'];//字段
    /**
     * 添加
     * @param  [type] $get [description]
     * @return [type]      [description]
     */
    public function createa($get){
        return $this->create($get);
    }
    /**
     * 查询
     * @return [type] [description]
     */
    public function getAll(){
        return $this->get()->toArray();
    }
}
