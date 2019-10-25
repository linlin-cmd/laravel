<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\model\api\Goods;
use Illuminate\Support\Facades\Cache;
class GoodsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $city =request()->city;
        if (!empty($city)){
            $cache =Cache::get('K780'.$city);
            if (empty($cache)){
                $url ="http://api.k780.com/?app=weather.realtime&weaid=".$city."&ag=today,futureDay,lifeIndex,futureHour&appkey=".env('K780_APPKEY')."&sign=".env('K780_SIGN')."&format=json";
                $res =file_get_contents($url);
                $res =json_decode($res,1);
                //获取当天二十四点的时间
                $date =date('Y-m-d');
                //今天凌晨+一天的时间
                $time =strtotime($date)+86400;
                $catime =$time-time();
                Cache::put('K780'.$city,$res,$catime);
                return json_encode(['ret'=>1,'msg'=>'查询成功','data'=>$res]);
            }
            return json_encode(['ret'=>1,'msg'=>'查询成功','data'=>$cache]);
        }
        $goods =new Goods;
        $goods =$goods->paginate(2);
        if ($goods){
            return json_encode(['ret'=>1,'msg'=>'查询成功','data'=>$goods]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //接收表单的值
        $post =$request->all();
        //文件夹名称
        $time =date("Y-n-j");
        if ($request->hasFile('file')) {
            $goods_img=Storage::put("api/".$time,$post['file']);
        }
        $post['goods_img']="stroage/".$goods_img;
        //实例化模型
        $goods =new Goods;
        $goods =$goods->create($post);
        if ($goods){
            return json_encode(['ret'=>1,'msg'=>'添加成功']);
        }else{
            return json_encode(['ret'=>0,'msg'=>'添加失败']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
