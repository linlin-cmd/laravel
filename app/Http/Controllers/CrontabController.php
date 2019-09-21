<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tools\Tools;
class CrontabController extends Controller
{
	//依赖注入
    public $tools;
    public function __construct(Tools $tools)
    {
        $this->tools = $tools;
    }
    public function index(){
    	return view('crontab.index');
    }
    public function login(){
    	$redirect_url ="http://".env('APP_URL')."/crontab/code";
    	$url ="https://open.weixin.qq.com/connect/oauth2/authorize?appid=".env('WECHAT_APPID')."&redirect_uri=".urlencode($redirect_url)."&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect";
    	header('Location:'.$url);

    }
    public function code(){
    	$code =Request()->all();
    	$url =file_get_contents("https://api.weixin.qq.com/sns/oauth2/access_token?appid=".env('WECHAT_APPID')."&secret=SECRET&code=".$code['code']."&grant_type=authorization_code");
    	$res =json_decode($res,1);
    }
    public function list(){
    	//获取openid
		$app = app('wechat.official_account');
		$res =$app->user->list($nextOpenId = null);  // $nextOpenId 可选
		return view('crontab.list',['res'=>$res['data']['openid']]);
    }
}
