<?php

namespace App\Http\Controllers\hadmin\index;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\model\hadmin\Hadmin_login;
class LoginController extends Controller
{
    public function login()
    {
        $login_name =request()->login_name;
        $login_password =request()->login_password;
        //where查询数据
        $login =Hadmin_login::where(['login_name'=>$login_name])->first();
        //判断用户名
        if ($login)
        {
            //判断密码
            if ($login_password==$login->login_password)
            {
                //生成token
                $token =md5($login->login_id.time());
                //过期时间
                $overdue_time =time()+7200;
                //判断token为空
                if (empty($login->token))
                {
                    $update_login =Hadmin_login::where(['login_id'=>$login->login_id])->update(['token'=>$token,'overdue_time'=>$overdue_time]);
                }
                //判断时间
                if ($login->time <time() ){
                    $update_login =Hadmin_login::where(['login_id'=>$login->login_id])->update(['token'=>$token,'overdue_time'=>$overdue_time]);
                }
                return json_encode(['ret'=>1,'msg'=>'登录成功','token'=>$token]);
            }else{
                return json_encode(['ret'=>0,'msg'=>'密码错误']);
            }
        }else{
            return json_encode(['ret'=>0,'msg'=>'用户名错误']);
        }
    }
    public function token()
    {
        $token =request()->token;
        //判断token是否存在
        if (empty($token))
        {
            return json_encode(['ret'=>0,'msg'=>'请先登录']);
        }
        //检验token是否正确
        $login =Hadmin_login::where(['token'=>$token])->first();
        if (empty($login))
        {
            return json_encode(['ret'=>0,'msg'=>'请先登录']);
        }

        //检验token有效期
        if ($login->overdue_time < time())
        {
            return json_encode(['ret'=>0,'msg'=>'请先登录']);
        }
        //延长token时间
        //$login->overdue_time =time()+7200;
        //$login->save();
    }
}
