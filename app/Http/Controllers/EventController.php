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
                $share_code = explode('_',$xml_arr['EventKey'])[1]??[];
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

			    //获取用户昵称
			    $kao_openid =file_get_contents("https://api.weixin.qq.com/cgi-bin/user/info?access_token=".$this->tools->access_token()."&openid=".$user_openid."&lang=zh_CN");
			    $kao_openid =json_decode($kao_openid,1);
			    ///新关注用户发送信息
			    $message = '欢迎关注!,'.$kao_openid['nickname'];
			    // dd($message);
            }

        }
        //签到
        if ($xml_arr['EventKey']=="1") {
        	//判断是否有这个用户签到
        	$res =DB::table('sign')->where(['openid'=>$xml_arr['FromUserName']])->count();
        	if (empty($res)) {
        		$data =[
	        		'sign'=>'1',
	        		'integral'=>'5',
	        		'openid'=>$xml_arr['FromUserName'],
	        		'continuity'=>1
	        	];
	        	DB::table('sign')->insert($data);
        	}else{

        	}
        	//判断是签到还是未签到
        	$sign =DB::table('sign')->where(['openid'=>$xml_arr['FromUserName']])->first();
        	if ($sign->sign=="1") {
        		$message ="已签到";
        	}else{
        		$message ="签到成功";
        	}
        	
        }


        //查询积分
        if ($xml_arr['EventKey']=="积分") {
        	$sign =DB::table('sign')->where(['openid'=>$xml_arr['FromUserName']])->first();
        	$integral =$sign->integral??0;
        	$message="积分为:".$integral;
        }



        //回复消息
        $xml_str = '<xml><ToUserName><![CDATA['.$xml_arr['FromUserName'].']]></ToUserName><FromUserName><![CDATA['.$xml_arr['ToUserName'].']]></FromUserName><CreateTime>'.time().'</CreateTime><MsgType><![CDATA[text]]></MsgType><Content><![CDATA['.$message.']]></Content></xml>';
		echo $xml_str;

    }
}
