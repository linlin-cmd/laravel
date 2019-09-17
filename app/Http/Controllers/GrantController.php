<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Tools\Tools;
use Illuminate\Support\Facades\Storage;
class GrantController extends Controller
{
	//依赖注入
    public $tools;
    public function __construct(Tools $tools)
    {
        $this->tools = $tools;
    }
    public function login(){
    	return view('grant.login');
    }
    public function login_do(){
    	$post =request()->except('_token');
    }
    public function grant(){
    	$urlen ="http://w3.shop.com/grant/code";
    	$url ="https://open.weixin.qq.com/connect/oauth2/authorize?appid=wxaf15615068649b19&redirect_uri=".urlencode($urlen)."&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect";
    	header('location:'.$url);
    }
    public function code(){
    	$code =Request()->all();
    	$url="https://api.weixin.qq.com/sns/oauth2/access_token?appid=wxaf15615068649b19&secret=5af8270de69be6b59591223b74ccb8cd&code=".$code['code']."&grant_type=authorization_code";
    	$res =file_get_contents($url);
    	$res =json_decode($res,1);
    	//获取列表
    	$url ="https://api.weixin.qq.com/cgi-bin/user/get?access_token=".$this->tools->access_token()."&next_openid=";
    	$openid =file_get_contents($url);
    	$openid =json_decode($openid,1);
    	// dd($openid['data']);
    	return view('grant.openid',['openid'=>$openid['data']['openid']]);
    }
    public function massage($v){
    	$url ="https://api.weixin.qq.com/cgi-bin/message/mass/preview?access_token=".$this->tools->access_token();
    	$data =[
    		'touser'=>$v,
    		'msgtype'=>'text',
    		'text'=>['content'=>"hh,我是林林"]
    	];
    	$data =json_encode($data,JSON_UNESCAPED_UNICODE);
    	$res =$this->tools->curl_post($url,$data);
    	return view('grant/openid');
    }
    public function list(){
    	$res =DB::table('qrcode')->get();
    	return view('grant.list',['res'=>$res]);
    }
    /**
     * 二维码
     */
    public function qrcode($id){
    	$url ="https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token=".$this->tools->access_token();
    	$data =[
    		'action_name'=>'QR_LIMIT_SCENE',
    		'action_info'=>['scene'=>['scene_id'=>$id]]
    	];
    	$data =json_encode($data);
    	$res =$this->tools->curl_post($url,$data);
    	$res =json_decode($res,1);
    	$ticket ="https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=".$res['ticket'];
    	$qrcode =file_get_contents($ticket);
    	$path ='/wechat/qrcode/'.time().rand(1000,9999).'.jpg';
    	$res =Storage::put($path,$qrcode);
    	DB::table('qrcode')->where(['id'=>$id])->update(['url'=>'/storage'.$path]);
    	return redirect('grant/list');
    }
}
