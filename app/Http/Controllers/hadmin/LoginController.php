<?php

namespace App\Http\Controllers\Hadmin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\Tools\Tools;
use Illuminate\Support\Facades\Cache;
class LoginController extends Controller
{
	public $tools;
	public function __construct(Tools $tools){
		$this->tools =$tools;
	}
    public function login(){
    	return view('hadmin.login.login');
    }
    public function login_do(){
    	$post =request()->except('_token');
    	$res =DB::table('hadmin')->where(['name'=>$post['name']])->first();
    	//判断用户名是否正确
    	if (!$res) {
    		return back();
    	}else{
    		//判断密码是否正确
    		if ($post['password'] == $res->password) {
    			//判断验证码是否正确
    			if ($post['code']==session('hadmin_code')) {
    				request()->session()->put('hadmin_login',$res);
    				return redirect('hadmin/index');
    			}
    		}else{
    			return back();
    		}
    	}
    }
    //获取验证码
    public function send(){
    	$name =request()->name;
    	$password =request()->password;
    	//查询数据库的数据
    	$data =DB::table('hadmin')->where(['name'=>$name,'password'=>$password])->first();
    	//模板id
    	$template_id ="ppuDK8rWI1Yk9_MsWk05AT4nEmGKN7IHZ2JE5ECvJ5M";
    	//随机数
    	$rand =rand(1000,9999);
    	//存在session中
    	request()->session()->put('hadmin_code',$rand);
    	$data =[
    		'touser'=>$data->openid,
    		'template_id'=>$template_id,
    		'data'=>[
    			'first'=>['value'=>'验证码'],
    			'keyword1'=>['value'=>$rand],
    			'keyword2'=>['value'=>date('Y-m-d H:i:s',time())]
    		]
    	];
    	//调用模板接口
    	$url ="https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=".$this->tools->access_token();
    	$post =$this->tools->curl_post($url,json_encode($data,JSON_UNESCAPED_UNICODE));
    }
    //绑定账号
    public function account(){
        //反调回路径
        $code =request()->code;
        $host = $_SERVER['HTTP_HOST'];  //域名
        $uri = $_SERVER['REQUEST_URI']; //路由参数
        //如果为空去回调
        if (empty($code)) {
            $redirect_url =urlencode("http://".$host.$uri);  // ?code=xx
            $code="https://open.weixin.qq.com/connect/oauth2/authorize?appid=".env('WECHAT_APPID')."&redirect_uri=".$redirect_url."&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect";
            header('Location:'.$code);
        }else{
            //获取access_token
            $res =file_get_contents('https://api.weixin.qq.com/sns/oauth2/access_token?appid=wxaf15615068649b19&secret=5af8270de69be6b59591223b74ccb8cd&code='.$code.'&grant_type=authorization_code');
            $res =json_decode($res,1);
            //获取openid
            $openid =file_get_contents("https://api.weixin.qq.com/sns/userinfo?access_token=".$res['access_token']."&openid=".$res['openid']."&lang=zh_CN");
            $openid =json_decode($openid,1);
            return view('hadmin.login.account',['openid'=>$openid['openid']]);
        }
    }
    //执行绑定账号
    public function account_do(){
        $post =request()->except('_token');
        $res =DB::table('hadmin')->where(['name'=>$post['name']])->first();
        if ($res) {
            if ($post['password']==$res->password) {
                DB::table('hadmin')->where(['id'=>$res->id])->update(['openid'=>$post['openid']]);
                return redirect('hadmin/index');
            }
        }
    }
    //扫码登录
    public function code(){
        $id =rand(1000,9999);
        $url ="http://www.wenroulin.cn/hadmin/code_do?id=".$id;
        return view('hadmin.login.code',['url'=>$url,'id'=>$id]);
    }
    public function code_do(){
        //唯一凭证
        $id =request()->id;
        //获取openid
        $openid =$this->tools->getopenid();
        Cache::put('wechatlogin_'.$id,$openid,10);
        return '扫码登录成功,请稍后';
    }
    public function check_wecaht_login(){
        $id =request()->id;
        //从缓存中拿出来
        $openid =Cache::get('wechatlogin_'.$id);
        if (!$openid) {
            return json_encode(['ret'=>0,'msg'=>'用户未扫码']);
        }
        return json_encode(['ret'=>1,'msg'=>'用户已扫码']);
    }
}
