<?php

namespace App\Http\Controllers\hadmin;

use App\model\hadmin\Hadmin_attribute;
use App\model\hadmin\Hadmin_type;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class Goods_attributeController extends Controller
{
    //添加商品属性
    public function goods_attribute()
    {
        $type =Hadmin_type::get();
        return view('hadmin.admin.goods_attribute.goods_attribute',['type'=>$type]);
    }
    public function goods_attribute_do()
    {
        $post =request()->all();
        $attribute =Hadmin_attribute::create($post);
        if ($attribute){
            return json_encode(['ret'=>1,'msg'=>'添加成功']);
        }else{
            return json_encode(['ret'=>0,'msg'=>'添加失败']);
        }
    }
    public function goods_attribute_list()
    {
        //查询属性
        $type =Hadmin_type::join('hadmin_attribute', 'hadmin_attribute.goods_type', '=', 'hadmin_type.type_id')->get();
        //查询类型
        $type_name =Hadmin_type::get();
        return view('hadmin.admin.goods_attribute.goods_attribute_list',['type'=>$type,'type_name'=>$type_name]);
    }
    //属性搜索
    public function search()
    {
        //接收值
        $attribute_name =request()->attribute_name;
        $where =[];
        if(!empty($attribute_name)){
            $where[]=['goods_type','like',"%$attribute_name%"];
        }
        $type =Hadmin_type::join('hadmin_attribute', 'hadmin_attribute.goods_type', '=', 'hadmin_type.type_id')->where($where)->get()->toArray();
        if ($type){
            return json_encode($type);
        }
    }
}
