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
    	$redirect_url =env('APP_URL')."/crontab/code";
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
    public function getidlist($v){
    	$url ="https://api.weixin.qq.com/cgi-bin/tags/getidlist?access_token=".$this->tools->access_token();
    	$data =[
    		'openid'=>$v
    	];
    	$res =$this->tools->curl_post($url,json_encode($data,JSON_UNESCAPED_UNICODE));
    	$res =json_decode($res,1);
    	return view('crontab.getidlist',['res'=>$res['tagid_list']]);
    }
    public function news($v){
    	$url ="https://api.weixin.qq.com/cgi-bin/message/mass/preview?access_token=".$this->tools->access_token();
    	$data =[
    		'touser'=>$v,
    		'text'=>['content'=>'哈哈测试'],
    		"msgtype"=>"text"
    	];
    	$res =$this->tools->curl_post($url,json_encode($data,JSON_UNESCAPED_UNICODE));
    	dd($res);
    }
    public function add(){
    	return view('crontab.add');
    }
    public function add_do(){
    	$post =Request()->except('_token');
    	$data =[
    		'tag'=>['name'=>$post['name']]
    	];
    	$url ="https://api.weixin.qq.com/cgi-bin/tags/create?access_token=".$this->tools->access_token();
    	$res =$this->tools->curl_post($url,json_encode($data,JSON_UNESCAPED_UNICODE));
    	return redirect('crontab/tag_list');
    }
    public function tag_list(){
    	$data =[];
        $url ="";
        \Log::info('任务调动');
        $this->tools->curl_post($url,$data);
            die;
    	$url ="https://api.weixin.qq.com/cgi-bin/tags/get?access_token=".$this->tools->access_token();
    	$res =file_get_contents($url);
    	$res =json_decode($res,1);
    	return view('crontab.tag_list',['res'=>$res['tags']]);
    }
}
