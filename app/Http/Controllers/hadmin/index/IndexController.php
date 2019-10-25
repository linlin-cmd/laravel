<?php

namespace App\Http\Controllers\hadmin\index;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\model\hadmin\Hadmin_goods;
use App\model\hadmin\Hadmin_goods_attribute;
use App\model\hadmin\Hadmin_attribute;
use App\model\hadmin\Hadmin_cat;
use App\model\hadmin\Hadmin_login;
use App\model\hadmin\Hadmin_cart;
use App\model\hadmin\Hadmin_stock;
class IndexController extends Controller
{
    //前台展示
    public function index()
    {
        
        $sign =request()->sign;
        $rand =request()->rand;
        if (empty($sign)){
            return json_encode(['ret'=>201,'msg'=>'签名没传'],JSON_UNESCAPED_UNICODE);
        }
        $mysign =md5("1902".$rand);
        if ($sign !=$mysign){
            return json_encode(['ret'=>201,'msg'=>'签名不对！！'],JSON_UNESCAPED_UNICODE);
        }
        $goods =Hadmin_goods::orderBy('goods_id','desc')->paginate(4);
        //处理拼接图片路径使用函数获取
        foreach ($goods as $k=>$v)
        {
            $url =$_SERVER['SERVER_NAME'];
            $goods[$k]['goods_img'] ="http://".$url."/".$goods[$k]['goods_img'];
        }
        return json_encode(['ret'=>1,'data'=>$goods]);
    }
    //商品详情
    public function goods_details()
    {
        $goods_id =request()->goods_id;
        $goods =Hadmin_goods::where(['goods_id'=>$goods_id])->first();
        //判断访问
        if (!empty($goods_id)){
            //获取访问次数
            $num =$goods['goods_visit'];
            $num +=1;
            $goods->goods_visit =$num;
            $goods->save();
        }
        //处理图片
        $url =$_SERVER['SERVER_NAME'];
        $goods['goods_img'] ="http://".$url."/".$goods['goods_img'];
        //查询属性和商品属性表
        $goods_attribute =Hadmin_goods_attribute::join('hadmin_attribute','hadmin_goods_attribute.attribute_id','=','hadmin_attribute.attribute_id')
            ->where(['goods_id'=>$goods_id])->get()->toArray();
        //可选规格参数
        $spec =[];
        //普通展示属性
        $args =[];
        //循环处理并分组
        foreach($goods_attribute as $k=>$v)
        {
            if ($v['is_attribute']==1)
            {
                $args[]=$v;
            }else{
                $status =$v['attribute_name'];
                $spec[$status][]=$v;
            }
        }
        //返回数据
        return json_encode(['ret'=>1,'data'=>$goods,'spec'=>$spec,'args'=>$args]);

    }
    //分类展示商品
    public function goods_cat()
    {
        $goods_cat =Hadmin_goods::get();
        return json_encode(['res'=>1,'data'=>$goods_cat]);
    }
    /**
     * 加入购物车
     */
    public function goods_cart()
    {
        //token加入购物车
        $mid_params = request()->get('mid_params');
        //接收值
        $goods_id =implode(',',request()->goods_id);//商品id
        $goods_attribute_id =implode(',',request()->goods_attribute_id);
        $token =request()->token;
        $hadmin_login =Hadmin_login::where(['token'=>$token])->first();
        $login_id =$hadmin_login->login_id;
        $cart_number =1;


        //查询商品库存量
        $hadmin_stock =hadmin_stock::where(['goods_id'=>$goods_id,'goods_attribute_id'=>$goods_attribute_id])->first();
        //判断库存量是否
        if ($cart_number >= $hadmin_stock['goods_stock'])
        {
            $is_number =0;
        }else{
            $is_number =1;
        }
        //判断库存中查不到id
        if (empty($hadmin_stock->stock_id))
        {
            return json_encode(['ret'=>1,'msg'=>'缺货']);
        }
        //查询货品表
        $hadmin_cart =Hadmin_cart::where(['goods_id'=>$goods_id,'login_id'=>$login_id,'goods_attribute_id'=>$goods_attribute_id])->first();
        if (empty($hadmin_cart))
        {
            //为空添加一条
            $cart =Hadmin_cart::create([
                'goods_id'=>$goods_id,
                'login_id'=>$login_id,
                'goods_attribute_id'=>$goods_attribute_id,
                'cart_number'=>$cart_number,
                'stock_id'=>$hadmin_stock->stock_id,
                'is_number'=>$is_number
            ]);
        }else{
            //不为空修改
            $hadmin_cart->cart_number =$hadmin_cart->cart_number+$cart_number;
            $hadmin_cart->save();
        }
        return json_encode(['ret'=>1,'msg'=>'加入购物车成功']);
    }
    /**
     * 购物车展示
     */
    public function goods_cart_list()
    {
        $mid_params = request()->get('mid_params');
        $goods_cart_list =Hadmin_cart::join('hadmin_goods','hadmin_goods.goods_id','=','hadmin_cart.goods_id')->get()->toArray();
        //处理图片
        $url =$_SERVER['SERVER_NAME'];
        $goods_attribbute_id =[];
        //处理图片
        foreach ($goods_cart_list as $k=>$v)
        {
            $goods_cart_list[$k]['goods_img'] ="http://".$url."/".$v['goods_img'];
            $goods_attribute_id =explode(',',$v['goods_attribute_id']);
            $hadmin_goods_attribute=Hadmin_goods_attribute::join('hadmin_attribute','hadmin_attribute.attribute_id','=','hadmin_goods_attribute.attribute_id')->where(['goods_id'=>$v['goods_id']])->whereIn('goods_attribute_id',$goods_attribute_id)->get()->toArray();
            $arr =[];
            //定义价钱
            $goods_price =$v['goods_price'];
            foreach ($hadmin_goods_attribute as $vv){
                $arr[]=$vv['attribute_name'].":".$vv['attribute_value'];
                $goods_price +=$vv['attribute_price'];
            }
            //组装
            $goods_cart_list[$k]['goods_attribute_id']=implode(',',$arr);
            $goods_cart_list[$k]['goods_price'] =$goods_price;
        }
        return json_encode(['ret'=>1,'data'=>$goods_cart_list]);
    }
}
