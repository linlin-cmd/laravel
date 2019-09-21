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
    public function menu(){
    	$url ="https://api.weixin.qq.com/cgi-bin/menu/create?access_token=".$this->tools->access_token();
    	$data =[
    		'button'=>[
    			[
    				'type'=>'click',
    				'name'=>'我的猫呢',
    				'key'=>'mao'
    			],[
    					'name'=>"菜单",
    					'sub_button'=>[
    					   [
    					   "type"=>"view",
			               "name"=>"搜索",
			               "url"=>"http://www.soso.com/"
			               ],
			               [
			               	 "type"=>"miniprogram",
				             "name"=>"林林",
				             "url"=>"http://mp.weixin.qq.com",
				             "appid"=>"wxaf15615068649b19",
				             "pagepath"=>"pages/lunar/index"
			               ],
			               [
				               "type"=>"click",
				               "name"=>"赞一下我们",
				               "key"=>"GOOD"
			               ]
			      	]
    			]
    		]
    	];
    	$data =json_encode($data,JSON_UNESCAPED_UNICODE);
    	$res =$this->tools->curl_post($url,$data);
    	dd($res);
    }
    public function menu_add(){
    	$info =DB::table('menu')->get();
    	return view('grant.menu_add',['info'=>$info]);
    }
    public function menu_do(){
    	$post =Request()->except('_token');
    	//判断一级菜单二级菜单
    	if ($post['name2']=="") {
    		$post['button_type']=1;
    	}else{
    		$post['button_type']=2;
    	}
    	//添加入库
    	DB::table('menu')->insert($post);
    	$this->menu_menu();
    	return redirect('grant/menu_add');

    }
    public function menu_menu(){
    	/**
    	 * 
    	 */
    	//查询数据库
    	$res =DB::table('menu')->select(['name'])->groupBy('name')->get();//groupBy分组
    	$data=[];
    	foreach($res as $vv){
            $menu_info = DB::table('menu')->where(['name'=>$vv->name])->get();
            $menu_info =json_decode(json_encode($menu_info),1);
            $arr = [];
            foreach($menu_info as $v){
                if($v['button_type'] == 1){ //普通一级菜单
                    if($v['type'] == 1){ //click
                        $arr = [
                            'type'=>'click',
                            'name'=>$v['name'],
                            'key'=>$v['key_url']
                        ];
                    }elseif($v['type'] == 2){//view
                        $arr = [
                            'type'=>'view',
                            'name'=>$v['name'],
                            'url'=>$v['key_url']
                        ];
                    }
                }elseif($v['button_type'] == 2){ //带有二级菜单的一级菜单
                    $arr['name'] = $v['name'];
                    if($v['type'] == 1){ //click
                        $button_arr = [
                            'type'=>'click',
                            'name'=>$v['name2'],
                            'key'=>$v['key_url']
                        ];
                    }elseif($v['type'] == 2){//view
                        $button_arr = [
                            'type'=>'view',
                            'name'=>$v['name2'],
                            'url'=>$v['key_url']
                        ];
                    }
                    $arr['sub_button'][] = $button_arr;
                }
            }
            $data['button'][] = $arr;
        }
    	// dd(json_encode($data,JSON_UNESCAPED_UNICODE));
    	// dd($data);
    	$url ="https://api.weixin.qq.com/cgi-bin/menu/create?access_token=".$this->tools->access_token();
    	$res =$this->tools->curl_post($url,json_encode($data,JSON_UNESCAPED_UNICODE));
    	return redirect('grant/menu_add');
    	dd($res);
    }
    /**
     * 删除
     */
    public function menu_del($id){
    	$res =DB::table('menu')->where(['id'=>$id])->delete();
    	$this->menu_menu();
    	return redirect('grant/menu_add');
    }

    /**
     * JSSDK
     */
    public function jssdk(){
    	$url ='http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
    	//jssdk
    	$jssdk =$this->tools->jssdk();
    	$timestamp =time();
    	$nonceStr =rand(1000,9999).'linlin';
    	$sign_str = 'jsapi_ticket='.$jssdk.'&noncestr='.$nonceStr.'&timestamp='.$timestamp.'&url='.$url;
    	//
    	$signature=sha1($sign_str);
    	// dd($jssdk);
    	return view('grant.jssdk',compact('nonceStr','signature','timestamp'));
    }
}
