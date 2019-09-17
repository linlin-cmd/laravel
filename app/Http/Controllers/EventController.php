<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EventController extends Controller
{
    public function event(){
    	//获取xml
    	$xml_string = file_get_contents('php://input');
    	//存放路径
    	$path =storage_path('logs/wechat/'.date("Y-m-d",time()).".log");
    	file_put_contents($path,"\n<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<\n\n",FILE_APPEND);
    	//创建日志
    	$append =file_put_contents($path,$xml_string,FILE_APPEND);
    	//追加内容
    	file_put_contents($path,"<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<\n",FILE_APPEND);
    	
    	$xml_obj = simplexml_load_string($xml_string,'SimpleXMLElement',LIBXML_NOCDATA);
    	$xml_arr = (array)$xml_obj;
    	dd($xml_arr);
        \Log::Info(json_encode($xml_arr,JSON_UNESCAPED_UNICODE));
        /**
         * 业务逻辑
         */
        if($xml_arr['MsgType'] == 'event'){
            if($xml_arr['Event'] == 'subscribe'){
                $share_code = explode('_',$xml_arr['EventKey'])[1];
                $user_openid = $xml_arr['FromUserName']; //粉丝openid
                //判断openid是否已经在日志表
                $wechat_openid = DB::table('wechat_log')->where(['openid'=>$user_openid])->first();
                if(empty($wechat_openid)){
                    DB::table('qrcode')->where(['id'=>$share_code])->increment('share_num',1);
                    DB::table('wechat_log')->insert([
                        'openid'=>$user_openid,
                        'add_time'=>time()
                    ]);
                }
            }
        }


        $message = '欢迎关注！';
        $xml_str = '<xml><ToUserName><![CDATA['.$xml_arr['FromUserName'].']]></ToUserName><FromUserName><![CDATA['.$xml_arr['ToUserName'].']]></FromUserName><CreateTime>'.time().'</CreateTime><MsgType><![CDATA[text]]></MsgType><Content><![CDATA'.$message.']]></Content></xml>';
        echo $xml_str;
    }
}
