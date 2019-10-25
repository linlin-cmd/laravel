<?php

namespace App\Http\Controllers\hadmin;

use App\model\hadmin\Hadmin_cat;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class Goods_catController extends Controller
{
    /**
     * 商店分类
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function goods_cat()
    {
        $hadmin_cat =new Hadmin_cat;
        $hadmin_cat =$hadmin_cat->get();
        $hadmin_cat =createcat($hadmin_cat);
        return view('hadmin.admin.goods_cat.goods_cat',['hadmin_cat'=>$hadmin_cat]);
    }
    //添加商品分类
    public function goods_cat_do()
    {
        $post =request()->all();
        $hadmin_cat =new Hadmin_cat;
        $hadmin_cat =$hadmin_cat->create($post);
        if ($hadmin_cat){
            return json_encode(['ret'=>1,'msg'=>'添加成功']);
        }else{
            return json_encode(['ret'=>0,'msg'=>'添加失败']);
        }
    }
    //商品分类展示
    public function goods_cat_list()
    {
        $hadmin_cat =new Hadmin_cat;
        $hadmin_cat =$hadmin_cat->get();
        $hadmin_cat =createcat($hadmin_cat);
        return view('hadmin.admin.goods_cat.goods_cat_list',['hadmin_cat'=>$hadmin_cat]);
    }
    //唯一性校验
    public function only()
    {
        $cat_name =request()->cat_name;
        $hadmin_cat =new Hadmin_cat;
        $hadmin_cat =$hadmin_cat->where(['cat_name'=>$cat_name])->count();
        if ($hadmin_cat){
            return json_encode(['ret'=>1,'msg'=>'分类名已存在']);
        }
    }
}
