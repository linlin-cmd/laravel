<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
class WechatController extends Controller
{
	//获取用户列表
	public function openid(){
		$result =file_get_contents('https://api.weixin.qq.com/cgi-bin/user/get?access_token='.$this->access_token().'&next_openid=');
		$res =json_decode($result,true);
		//定义数组
		$info =[];
		//循环数据
		foreach ($res['data']['openid'] as $key => $v) {
			//查看用户基本信息
			$user_info =file_get_contents('https://api.weixin.qq.com/cgi-bin/user/info?access_token='.$this->access_token().'&openid='.$v.'&lang=zh_CN');
			//转为json格式
			$user_info =json_decode($user_info,true);
			$info[$key]['nickname']=$user_info['nickname'];
			$info[$key]['openid']=$v;
		}
		return view('wechat/openid',['info'=>$info]);
		// dd($info);
	}
	//获取access_token
	public function access_token(){
		return $this->wechat();
	}
	//封装调用方法
    public function wechat(){
    	//实例化redis
    	$redis =new \Redis();
    	$redis->connect('127.0.0.1','6379');
    	//加入缓存
    	$access ='wechat';
    	//判断是否有值
    	if ($redis->exists($access)) {
    		return $redis->get($access);
    	}else{
    		//不存在
    		$result =file_get_contents('https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=wxaf15615068649b19&secret=5af8270de69be6b59591223b74ccb8cd');
    		$res =json_decode($result,true);
    		$redis->set($access,$res['access_token'],$res['expires_in']);
    		return $res['access_token'];
    	}
    }
}
