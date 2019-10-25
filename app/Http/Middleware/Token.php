<?php

namespace App\Http\Middleware;

use App\model\hadmin\Hadmin_login;
use Closure;

class Token
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
        $token =$request->input('token');
        $logion =$this->checkLogoin($token);
        $mid_params = ['mid_params'=>$logion];
        $request->attributes->add($mid_params);//添加参数
        return $next($request);
    }
    public function checkLogoin($token){
        //判断token是否存在
        if (empty($token))
        {
            echo  json_encode(['ret'=>0,'msg'=>'请先登录']);die;
        }
        //检验token是否正确
        $login =Hadmin_login::where(['token'=>$token])->first();
        if (empty($login))
        {
            echo  json_encode(['ret'=>0,'msg'=>'请先登录']);die;
        }

        //检验token有效期
        if ($login->overdue_time < time())
        {
            echo  json_encode(['ret'=>0,'msg'=>'请先登录']);die;
        }
        return $login;
    }
}
