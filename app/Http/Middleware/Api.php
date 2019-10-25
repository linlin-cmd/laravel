<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Cache;
class Api
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        header("Access-Control-Allow-Origin:*");
        header('Access-Control-Allow-Methods:POST');
        header('Access-Control-Allow-Headers:x-requested-with, content-type');


        //接口防刷
//        $ip =$_SERVER['REMOTE_ADDR'];
//        $num =Cache::get('api'.$ip);
//        //判断缓存是否存了
//        if (!$num){
//            $num =0;
//        }
//        $num +=1;
//        Cache::put('api'.$ip,$num,60);
//
//        //判断次数提示
//        if ($num >50){
//            echo json_encode(['ret'=>0,'msg'=>'当前访问过于频繁']);die;
//        }
        return $next($request);
    }
}
