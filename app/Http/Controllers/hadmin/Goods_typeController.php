<?php

namespace App\Http\Controllers\hadmin;

use App\model\hadmin\Hadmin_attribute;
use App\model\hadmin\Hadmin_type;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class Goods_typeController extends Controller
{
    /**
     * 类型
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function goods_type()
    {
        return view('hadmin.admin.goods_type.goods_type');
    }
    public function goods_type_do()
    {
        $type_name =request()->all();
        $type =Hadmin_type::create($type_name);
        if ($type){
            return json_encode(['ret'=>1,'msg'=>'添加成功']);
        }else{
            return json_encode(['ret'=>0,'msg'=>'添加失败']);
        }
    }

    public function goods_type_list()
    {
        $type =Hadmin_type::get()->toArray();
        //循环展示数据
        foreach ($type as $k=>$v){
            $type[$k]['count'] =hadmin_attribute::where(['goods_type'=>$v['type_id']])->count();
        }
        return view('hadmin.admin.goods_type.goods_type_list',['type'=>$type]);
    }
}
