<?php

namespace App\Http\Controllers\hadmin;

use App\model\hadmin\Hadmin_attribute;
use App\model\hadmin\Hadmin_cat;
use App\model\hadmin\Hadmin_goods;
use App\model\hadmin\Hadmin_goods_attribute;
use App\model\hadmin\Hadmin_type;
use App\model\hadmin\Hadmin_stock;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class GoodsController extends Controller
{
    /**
     * 商品
     */
    public function goods()
    {
        //商品分类查询
        $goods_cat =Hadmin_cat::get();
        //商品类型查询
        $goods_type =Hadmin_type::get();
        return view('hadmin.admin.goods.goods',['goods_cat'=>$goods_cat,'goods_type'=>$goods_type]);
    }
    //类型展示
    public function goods_change()
    {
        $type_id =request()->type_id;
        $goods_attribute =Hadmin_attribute::where(['goods_type'=>$type_id])->get()->toArray();
        return json_encode($goods_attribute);
    }
    public function goods_do()
    {
        $post =request()->all();
        //文件夹名称
        $time =date("Y-n-j");
        if (request()->hasFile('goods_img')) {
            $goods_img=Storage::put("goods/".$time,$post['goods_img']);
        }
        $post['goods_img']="storage/".$goods_img;
        //添加商品
        $goods_id =Hadmin_goods::insertGetId([
            'goods_name'=>$post['goods_name'],
            'cat_id'=>$post['cat_id'],
            'goods_sn'=>time().rand(1000,9999),
            'goods_price'=>$post['goods_price'],
            'goods_img'=>$post['goods_img'],
            'goods_desc'=>$post['goods_desc']
        ]);
        if($goods_id){
            //商品-属性
            foreach ($post['attribute_value'] as $k=>$v){
                $attribute_data =Hadmin_goods_attribute::insert([
                    'goods_id'=>$goods_id,
                    'attribute_id'=>$post['attribute_id'],
                    'attribute_value'=>$post['attribute_value'][$k],
                    'attribute_price'=>$post['attribute_price'][$k]
                ]);
            }
            return redirect('hadmin/goods_list/'.$goods_id);
        }
    }
    public function goods_list($goods_id)
    {
        //商品信息
        $goods =Hadmin_goods::where(['goods_id'=>$goods_id])->get()->toArray();
//        //商品-属性
        $hadmin_goods_attribute =Hadmin_goods_attribute::
                join('hadmin_attribute','hadmin_goods_attribute.attribute_id','=','hadmin_attribute.attribute_id')
                ->where(['goods_id'=>$goods_id])->get()->toArray();
        //循环处理
        $arr =[];
        foreach ($hadmin_goods_attribute as $k=>$v){
            $status =$v['attribute_name'];
            $arr[$status][] =$v;
        }
        return view('hadmin.admin.goods.goods_list',['arr'=>$arr,'goods'=>$goods]);
    }
    public function goods_stock()
    {
        $post =request()->all();
        //分组处理数据
        $count =count($post['goods_attribute_id']) / count($post['goods_stock']);
        $goods_attribute_id =array_chunk($post['goods_attribute_id'],$count);
        foreach ($goods_attribute_id as $k=>$v){
            $okk =implode(',',$v);
        }
        foreach ($goods_attribute_id as $k=>$v) {
            Hadmin_stock::insert([
                'goods_id'=>$post['goods_id'],
                'goods_attribute_id'=>implode(",",$v),
                'goods_stock'=>$post['goods_stock'][$k]
            ]);
        }
        return redirect('hadmin/goods_stock_list');
    }
    //商品展示
    public function goods_stock_list()
    {
        $goods_name =request()->goods_name;
        $cat_id =request()->cat_id;
        //定义数组
        $where =[];
        if (!empty($goods_name)){
            $where[]=['goods_name','like',"%$goods_name%"];
        }
        if (!empty($cat_id)){
            $where[]=['hadmin_cat.cat_id','=',"$cat_id"];
        }
        //双表联查
        $goods =Hadmin_goods::where($where)->join('hadmin_cat','hadmin_goods.cat_id','=','hadmin_cat.cat_id')->paginate(1);
        //查询分类表
        $goods_cat =Hadmin_cat::get();
        return view('hadmin.admin.goods_stock.goods_stock',compact('goods','goods_cat','goods_name','cat_id'));
    }
    public function say()
    {
        $goods_name =request()->goods_name;
        $goods_id =request()->goods_id;
        $goods =Hadmin_goods::where(['goods_id'=>$goods_id])->update(['goods_name'=>$goods_name]);
        if ($goods){
            return json_encode(['ret'=>1,'msg'=>'修改成功']);
        }
    }
}
