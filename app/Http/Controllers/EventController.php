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
        \Log::Info(json_encode($xml_arr,JSON_UNESCAPED_UNICODE));
    }
}
