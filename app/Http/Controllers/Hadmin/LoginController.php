<?php

namespace App\Http\Controllers\Hadmin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\Tools\Tools;
class LoginController extends Controller
{
	public $tools;
	public function __construct(Tools $tools){
		$this->tools =$tools;
	}
    public function login(){
    	// dd(session('hadmin_code'));
    	return view('hadmin.login.login');
    }
    public function login_do(){
    	$post =request()->except('_token');
    	$res =DB::table('hadmin')->where(['name'=>$post['name']])->first();
    	//判断用户名是否正确
    	if (!$res) {
    		return back();
    	}else{
    		//判断密码是否正确
    		if ($post['password'] == $res->password) {
    			//判断验证码是否正确
    			if ($post['code']==session('hadmin_code')) {
    				request()->session()->put('hadmin_login',$res);
    				return redirect('hadmin/index');
    			}
    		}else{
    			return back();
    		}
    	}
    }
    //获取验证码
    public function send(){
    	$name =request()->name;
    	$password =request()->password;
    	//查询数据库的数据
    	$data =DB::table('hadmin')->where(['name'=>$name,'password'=>$password])->first();
    	//模板id
    	$template_id ="ppuDK8rWI1Yk9_MsWk05AT4nEmGKN7IHZ2JE5ECvJ5M";
    	//随机数
    	$rand =rand(1000,9999);
    	//存在session中
    	request()->session()->put('hadmin_code',$rand);
    	$data =[
    		'touser'=>$data->openid,
    		'template_id'=>$template_id,
    		'data'=>[
    			'first'=>['value'=>'验证码'],
    			'keyword1'=>['value'=>$rand],
    			'keyword2'=>['value'=>date('Y-m-d H:i:s',time())]
    		]
    	];
    	//调用模板接口
    	$url ="https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=".$this->tools->access_token();
    	$post =$this->tools->curl_post($url,json_encode($data,JSON_UNESCAPED_UNICODE));
    }
    //绑定账号
    public function account(){
    	$redirect_url=env('APP_URL').'/account';;
   		$url="https://open.weixin.qq.com/connect/oauth2/authorize?appid=wxaf15615068649b19&redirect_uri=".urlencode($redirect_url)."&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect";
   		header('Location:'.$url);
    }
}
