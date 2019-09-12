<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tools\Tools;
class Wechat_userController extends Controller
{
	//依赖注入
    public $tools;
    public function __construct(Tools $tools)
    {
        $this->tools = $tools;
    }
    public function user(){
		return view('user.user');    	
    }
    public function user_do(){
    	$data =request()->except('_token');
    	$url ="https://api.weixin.qq.com/cgi-bin/tags/create?access_token=".$this->tools->access_token();
    	$res =$this->tools->curl_post($url,json_encode(['tag'=>$data],JSON_UNESCAPED_UNICODE));
    	return redirect('user_list');
    	return $res;
    }
    public function user_list(){
    	$url ="https://api.weixin.qq.com/cgi-bin/tags/get?access_token=".$this->tools->access_token();
    	$res =file_get_contents($url);
    	$res =json_decode($res,1);
    	return view('user.user_list',['res'=>$res['tags']]);
    }
    public function update($id,$name){
    	return view('user.update',['id'=>$id,'name'=>$name]);
    }
    public function update_do($id){
    	$name =request()->name;
    	$url ="https://api.weixin.qq.com/cgi-bin/tags/update?access_token=".$this->tools->access_token();
    	$res =$this->tools->curl_post($url,json_encode(['tag'=>['id'=>$id,'name'=>$name]],JSON_UNESCAPED_UNICODE));
    	return redirect('user_list');
    }
    public function delete($id){
    	$url ="https://api.weixin.qq.com/cgi-bin/tags/delete?access_token=".$this->tools->access_token();
    	$res =$this->tools->curl_post($url,json_encode(['tag'=>['id'=>$id]],JSON_UNESCAPED_UNICODE));
    	return redirect('user_list');
    }
    //粉丝列表
    public function Fans($id,$name){
    	$url ="https://api.weixin.qq.com/cgi-bin/user/tag/get?access_token=".$this->tools->access_token();
    	$data =[
    		'tagid'=>$id,
    		'next_openid'=>""
    	];
    	$res =$this->tools->curl_post($url,json_encode($data));
    	$res =json_decode($res,1);
    	// dd($res);
    	return view('user.fans',['res'=>$res['data']['openid'],'name'=>$name]);
    }
    /**
     * 打标签
     */
    public function user_openid($id){
    	$url ="https://api.weixin.qq.com/cgi-bin/user/get?access_token=".$this->tools->access_token()."&next_openid=";
    	$openid =file_get_contents($url);
    	$openid =json_decode($openid);
    	// dd($openid->data->openid);
    	return view('user.user_openid',['openid'=>$openid->data->openid,'id'=>$id]);
    }
    public function user_openid_do($id){
    	$openid=Request()->except('_token');
    	$url ="https://api.weixin.qq.com/cgi-bin/tags/members/batchtagging?access_token=".$this->tools->access_token();
    	$data =json_encode(['openid_list'=>$openid['openid'],'tagid'=>$id]);
    	$res =$this->tools->curl_post($url,$data);
    	$res =json_decode($res,1);
    	if ($res['errmsg']=="ok") {
    		return redirect('user_list');
    	}
    }
    /**
     * 发送文本信息
     */
    public function push($id){
    	return view('user.push',compact('id'));
    }
    public function push_do($id){
    	$content =request()->content;
    	$url="https://api.weixin.qq.com/cgi-bin/message/mass/sendall?access_token=".$this->tools->access_token();
    	$data =[
    		'filter'=>[
    			'is_to_all'=>false,'tag_id'=>$id],
    		'text'=>['content'=>$content],
    		'msgtype'=>"text"
    	];
    	$res =$this->tools->curl_post($url,json_encode($data,JSON_UNESCAPED_UNICODE));
    	return redirect('user_list');
    	//
    	dd($res);
    }
    /**
     * 用户下的标签
     */
    public function user_label($v){
    	$url ="https://api.weixin.qq.com/cgi-bin/tags/getidlist?access_token=".$this->tools->access_token();
    	$data =[
    		'openid'=>$v
    	];
    	$res =$this->tools->curl_post($url,json_encode($data));
    	
    	dd($res);
    	echo $v;
    }
    //发送模板消息
    public function template(){
    	//openid
    	$openid ="onctaxOEq53kXAv2iDxxYgWJnd94";
    	//模板id
    	$template_id ="9M5I12EAh71_7CaRunngBn0u3umbV3EykRYpY-j7mJg";
    	$url ="https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=".$this->tools->access_token();
    	$data =[
    		'touser'=>$openid,
    		'template_id'=>$template_id,
    		'url'=>"http://w3.shop.com",
    		[
    			'data'=>[
					'first'=>['value'=>'恭喜你收到!'],
					['']
    			]
    		]
    	];
    }
}
