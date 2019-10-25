<?php

namespace App\Http\Controllers\Hadmin;

use App\model\hadmin\Hadmin_goods_attribute;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use App\model\hadmin\Hadmin_cat;
use App\model\hadmin\Hadmin_type;
use App\model\hadmin\Hadmin_attribute;
use App\model\hadmin\Hadmin_goods;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function index()
    {
    	return view('hadmin.admin.index');
    }
    public function index_v1()
    {
    	return view('hadmin.admin.index_v1');
    }
    public function weather()
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
                return json_encode($res);
            }
            return json_encode($cache);
        }
    }
}
