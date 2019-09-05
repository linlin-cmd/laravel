<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Wechat_loginController extends Controller
{
	public function login(){
		return view('wechat_login/login');
	}
   	/**
   	 * 登录
   	 */
   	public function login_do(){
   		$redirect_url="http://w3.shop.com/wechat/code";
   		$url="https://open.weixin.qq.com/connect/oauth2/authorize?appid=wxaf15615068649b19&redirect_uri=".urlencode($redirect_url)."&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect";
   		header('Location:'.$url);
   		// return view('wechat_login/login');
   	}
   	/**
   	 * code
   	 */
   	public function code(){
   		$code =Request()->all();
   		//获取access_token
   		$res =file_get_contents('https://api.weixin.qq.com/sns/oauth2/access_token?appid=wxaf15615068649b19&secret=5af8270de69be6b59591223b74ccb8cd&code='.$code['code'].'&grant_type=authorization_code');
   		$res =json_decode($res,1);
   		//拉取用户信息
   		$result =file_get_contents('https://api.weixin.qq.com/sns/userinfo?access_token='.$res['access_token'].'&openid='.$res['openid'].'=zh_CN');
   		$result =json_decode($result,1);
   		dd($result);
   	}
}