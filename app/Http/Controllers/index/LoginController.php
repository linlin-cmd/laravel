<?php

namespace App\Http\Controllers\index;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\model\index\Index;
use Validator;
use DB;
class LoginController extends Controller
{
	//登录
    public function index(){
    	return view('index/login/login');
    }
    //登录验证
    public function login_do(){
    	//接收值
    	$data =request()->except('_token');
    	//查询值
    	$res=DB::table('web')->where('web_name','=',$data['web_name'])->first();
    	//判断条件是否成立
        if(!$res){
            return redirect('login');
        }else{
        	//不成立的话则跳转至登录页
            if($data['web_pwd']!=$res->web_pwd){
                return redirect('login');
            }else{
            	//记录session
                request()->session()->put('index_login',$res);
                return redirect('/');
            }
        }
    }
    public function wechat(){
        $redirect_url=env('APP_URL').'/code';
        $url="https://open.weixin.qq.com/connect/oauth2/authorize?appid=wxaf15615068649b19&redirect_uri=".urlencode($redirect_url)."&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect";
        header('Location:'.$url);
    }
    public function code(){
        $code =Request()->all();
        //获取access_token
        $res =file_get_contents('https://api.weixin.qq.com/sns/oauth2/access_token?appid=wxaf15615068649b19&secret=5af8270de69be6b59591223b74ccb8cd&code='.$code['code'].'&grant_type=authorization_code');
        $res =json_decode($res,1);
        //拉取用户信息
        $result =file_get_contents('https://api.weixin.qq.com/sns/userinfo?access_token='.$res['access_token'].'&openid='.$res['openid'].'=zh_CN');
        $result =json_decode($result,1);
        //查询数据库是否有数据
        $openid =DB::table('user_wechat')->where(['openid'=>$result['openid']])->first();
        if (!empty($openid)) {
            //存在
            request()->session()->put('wechat',$result);
            return redirect('/');
        }else{
            //不存在
            //开启事务
            DB::beginTransaction();
            $user_id=DB::table('user')->insertGetid([
                'user_name'=>$result['nickname'],
                'password'=>'',
                'add_time'=>time(),
            ]);
            $result =DB::table('user_wechat')->insert([
                'user_id'=>$user_id,
                'openid'=>$result['openid']
            ]);
            DB::rollBack();
            DB::commit();
            request()->session()->put('wechat',$result);
            return redirect('/');
        }
        // dd($result);
    }



    //注册
    public function reg(){
    	return view('index/login/reg');
    }
    //注册添加
    public function reg_do(){
    	$post =request()->except('_token');
        //验证器验证密码
    	$validator = Validator::make($post, [
    		'web_name' =>['required'],
			 'web_pwd' => ['required'],
			 'web_pwd_confirmation'=>['required',"same:web_pwd"],//不为空,两次密码是否相同
             ],[
             	'web_name.rqeuired'=>"手机号或邮箱不能为空",
                'web_pwd.required'=>"密码不能为空",
                'web_pwd_confirmation.required'=>"确认密码不能为空",
                'web_pwd_confirmation.same'=>'密码与确认密码不匹配',
		]);
		 if ($validator->fails()) {
				return redirect('reg')
					 ->withErrors($validator)
					->withInput();
		 }


        //验证码
        if ($post['code']!=session('email')) {
             echo "<script>alert('验证码错误');history.go(-1);</script>";exit;
        }

    	//入库
    	$res =Index::create($post);
    	if ($res) {
    		request()->session()->put('index_login',$res);
    		return redirect('/');
    	}
    }
    public function email(){
        //邮箱
        
        $web_name =request()->web_name;
        $email =$this->send($web_name);
        return ['ret'=>1,'msg'=>'验证码发送成功'];
    }
    //邮箱
    public function send($email){
    	$rand =rand(1000,9999);
        $email =\Mail::send('mail' , ['rand'=>$rand] ,function($message)use($email){
        //设置主题
            $message->subject("验证码");
        //设置接收方
            $message->to($email);
        });
        request()->session()->put('email',$rand);
	}
}
