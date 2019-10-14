<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Tools\Tools;
class EventController extends Controller
{
	//依赖注入
    public $tools;
    public function __construct(Tools $tools)
    {
        $this->tools = $tools;
    }
    public function event(){
    	//获取xml
    	$xml_string = file_get_contents('php://input');
    	//存放路径
    	$path =storage_path('logs/wechat/'.date("Y-m-d",time()).".log");
        dd($path);
    	file_put_contents($path,"\n<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<\n\n",FILE_APPEND);
    	//创建日志
    	$append =file_put_contents($path,$xml_string,FILE_APPEND);
    	//追加内容
    	file_put_contents($path,"\n<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<\n\n",FILE_APPEND);
    	
    	$xml_obj = simplexml_load_string($xml_string,'SimpleXMLElement',LIBXML_NOCDATA);
    	$xml_arr = (array)$xml_obj;
        \Log::Info(json_encode($xml_arr,JSON_UNESCAPED_UNICODE));
        /**
         * 业务逻辑
         */
        if($xml_arr['MsgType'] == 'event'){
            if($xml_arr['Event'] == 'subscribe'){
            	//二维码
                $share_code = explode('_',$xml_arr['EventKey'])[1];
                $user_openid = $xml_arr['FromUserName']; //粉丝openid
                //判断openid是否已经在日志表
                $wechat_openid =DB::table('wechat_log')->where(['openid'=>$user_openid])->first();
                if(empty($wechat_openid)){
                    DB::table('qrcode')->where(['id'=>$share_code])->increment('share_num',1);
                    DB::table('wechat_log')->insert([
                        'openid'=>$user_openid,
                        'add_time'=>time()
                    ]);
                }
			    ///新关注用户发送信息
			    $message = '欢迎关注!,';
            }

        }
        //绑定微信
        if ($xml_arr['MsgType'] == 'event') {
            if ($xml_arr['EventKey'] == 'account') {
                
            }
        }
        //用户回复消息
      //   if($xml_arr['Event'] == 'subscribe' && $xml_arr['MsgType'] == 'event') {
      //   	$user_openid = $xml_arr['FromUserName']; //粉丝openid
      //   	//获取用户信息
		    // $kao_openid =file_get_contents("https://api.weixin.qq.com/cgi-bin/user/info?access_token=".$this->tools->access_token()."&openid=".$user_openid."&lang=zh_CN");
		    // $kao_openid =json_decode($kao_openid,1);
		    // ///新关注用户发送信息
		    // $message = 'hello,'.$kao_openid['nickname'];
      //   }
        //判断用户发送的内容
        //文本内容
        if ($xml_arr['MsgType']=="text") {
        	
        	$user_openid = $xml_arr['FromUserName']; //粉丝openid
        	//获取用户信息
		    $kao_openid =file_get_contents("https://api.weixin.qq.com/cgi-bin/user/info?access_token=".$this->tools->access_token()."&openid=".$user_openid."&lang=zh_CN");
		    $kao_openid =json_decode($kao_openid,1);
		    DB::table('wx_msg')->insert([
        			'form_user_name'=>$kao_openid['nickname'],
        			'openid'=>$xml_arr['FromUserName'],
        			'status'=>$xml_arr['MsgType'],
        			'content'=>$xml_arr['Content'],
        			'time'=>$xml_arr['CreateTime']
        		]);
        	$message = "时间".date('Y-m-d H:i:s',$xml_arr['CreateTime'])."内容:".$xml_arr['Content'];
        }
        //判断click
        if ($xml_arr['MsgType']=="event" && $xml_arr['Event'] =="CLICK") {
        	
        	$user_openid = $xml_arr['FromUserName']; //粉丝openid
        	//获取用户信息
		    $kao_openid =file_get_contents("https://api.weixin.qq.com/cgi-bin/user/info?access_token=".$this->tools->access_token()."&openid=".$user_openid."&lang=zh_CN");
		    $kao_openid =json_decode($kao_openid,1);
		    DB::table('wx_msg')->insert([
        			'form_user_name'=>$kao_openid['nickname'],
        			'openid'=>$xml_arr['FromUserName'],
        			'status'=>$xml_arr['Event'],
        			'content'=>$xml_arr['EventKey'],
        			'time'=>$xml_arr['CreateTime']
        		]);
        	$message = 'hello,'.$kao_openid['nickname'];
        }
        //判断图片
        if ($xml_arr['MsgType']=="event" && $xml_arr['Event'] =="pic_weixin") {
        	$user_openid = $xml_arr['FromUserName']; //粉丝openid
        	//获取用户信息
		    $kao_openid =file_get_contents("https://api.weixin.qq.com/cgi-bin/user/info?access_token=".$this->tools->access_token()."&openid=".$user_openid."&lang=zh_CN");
		    $kao_openid =json_decode($kao_openid,1);
		    DB::table('wx_msg')->insert([
        			'form_user_name'=>$kao_openid['nickname'],
        			'openid'=>$xml_arr['FromUserName'],
        			'status'=>$xml_arr['Event'],
        			'content'=>$xml_arr['EventKey'],
        			'time'=>$xml_arr['CreateTime']
        		]);
		    $message ="1";
        }
        //回复消息
        $xml_str = '<xml><ToUserName><![CDATA['.$xml_arr['FromUserName'].']]></ToUserName><FromUserName><![CDATA['.$xml_arr['ToUserName'].']]></FromUserName><CreateTime>'.time().'</CreateTime><MsgType><![CDATA[text]]></MsgType><Content><![CDATA['.$message.']]></Content></xml>';
		echo $xml_str;
        die;
        //签到
        if ($xml_arr['EventKey']=="签到") {
        	//判断是否有这个用户签到
        	$res =DB::table('sign')->where(['openid'=>$xml_arr['FromUserName']])->count();
        	if (empty($res)) {
        		$data =[
	        		'sign'=>'0',
	        		'integral'=>'5',
	        		'openid'=>$xml_arr['FromUserName'],
	        		'continuity'=>1,
	        		'time'=>time()
	        	];
	        	DB::table('sign')->insert($data);
        	}
        	//查询数据库
        	$sign =DB::table('sign')->where(['openid'=>$xml_arr['FromUserName']])->first();
        	//判断是签到还是未签到
        	if ($sign->sign=="1") {
        		$message ="已签到";
        	}else{
        		$message ="签到成功";
        		DB::table('sign')->where(['openid'=>$xml_arr['FromUserName']])->update(['sign'=>1]);
        		//判断时间
        		$sign_time =date('Y-m-d',$sign->time);
        		$time =date('Y-m-d',time());
        		//判断昨天时间和今日时间
        		if ($sign_time!=$time) {
        			//连续签到
	        		//第1天
	        		if ($sign->continuity=="1") {
	        			$integral =$sign->integral+10;
	        			$continuity =$sign->continuity+1;
	        			DB::table('sign')->where(['openid'=>$xml_arr['FromUserName']])->update([
	        				'integral'=>$integral,'continuity'=>$continuity,'time'=>time()
	        			]);
	        		}
	        		//第2天
	        		if ($sign->continuity=="2") {
	        			$integral =$sign->integral+15;
	        			$continuity =$sign->continuity+1;
	        			DB::table('sign')->where(['openid'=>$xml_arr['FromUserName']])->update([
	        				'integral'=>$integral,'continuity'=>$continuity,'time'=>time()
	        			]);
	        		}
	        		//第3天
	        		if ($sign->continuity=="3") {
	        			$integral =$sign->integral+20;
	        			$continuity =$sign->continuity+1;
	        			DB::table('sign')->where(['openid'=>$xml_arr['FromUserName']])->update([
	        				'integral'=>$integral,'continuity'=>$continuity,'time'=>time()
	        			]);
	        		}
	        		//第4天
	        		if ($sign->continuity=="4") {
	        			$integral =$sign->integral+25;
	        			$continuity =$sign->continuity+1;
	        			DB::table('sign')->where(['openid'=>$xml_arr['FromUserName']])->update([
	        				'integral'=>$integral,'continuity'=>$continuity,'time'=>time()
	        			]);
	        		}
	        		//第5天
	        		if ($sign->continuity=="5") {
	        			$integral =$sign->integral+5;
	        			DB::table('sign')->where(['openid'=>$xml_arr['FromUserName']])->update([
	        				'integral'=>$integral,'continuity'=>1,'time'=>time()
	        			]);
	        		}
        		}else{
        			//未连续签到
        			$integral =$sign->integral+5;
        			DB::table('sign')->where(['openid'=>$xml_arr['FromUserName']])->update([
        				'integral'=>$integral,'continuity'=>1,'time'=>time()
        			]);
        		}
        		
        	}
        	
        }


        //查询积分
        if ($xml_arr['EventKey']=="积分") {
        	$sign =DB::table('sign')->where(['openid'=>$xml_arr['FromUserName']])->first();
        	//三元运算符
        	$integral =empty($sign->integral) ? 0 : $sign->integral;
        	$message="积分为:".$integral;
        }



        //回复消息
        $xml_str = '<xml><ToUserName><![CDATA['.$xml_arr['FromUserName'].']]></ToUserName><FromUserName><![CDATA['.$xml_arr['ToUserName'].']]></FromUserName><CreateTime>'.time().'</CreateTime><MsgType><![CDATA[text]]></MsgType><Content><![CDATA['.$message.']]></Content></xml>';
		echo $xml_str;

    }
}
