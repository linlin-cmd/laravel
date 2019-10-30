<?php
namespace App\Tools;
class Tools {
    public $redis;
    public function __construct()
    {
        $this->redis = new \Redis();
        $this->redis->connect('127.0.0.1','6379');

    }
    //获取access_token
	public function access_token(){
		return $this->wechat();
	}
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
    		$result =file_get_contents('https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.env('WECHAT_APPID').'&secret='.env('WECHAT_SECRET'));
    		$res =json_decode($result,true);
    		$redis->set($access,$res['access_token'],$res['expires_in']);
    		return $res['access_token'];
    	}
    }
     /**
     * guzzle
     */
    public function guzzle_upload($url,$path,$client,$is_video=1,$title="",$introduction=""){
        $multipart =
            [
                [
                    'name'     => 'media',
                    'contents' => fopen($path,'r')
                ]
            ];
        if (!$is_video=="0") {
            $multipart[]=
                [
                    'name'     => 'description',
                    'contents' => json_encode(['title'=>$title,'introduction'=>$introduction])
                ];
        }
    	$response = $client->request('POST', $url, [
            'multipart' => $multipart
        ]);
        return $response->getBody();
    }
    /**
     * post
     */
    public function curl_post($url,$data){
        //初始化init方法
        $curl = curl_init($url);
        ///
        //curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        //curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        ///
        //设定请求后返回结果
        curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
        //声明使用post方式来进行发送
        curl_setopt($curl,CURLOPT_POST,true);  //发送post
        //发送什么数据呢
        curl_setopt($curl,CURLOPT_POSTFIELDS,$data);
        //发送请求
        $data = curl_exec($curl);
        $errno = curl_errno($curl);  //错误码
        $err_msg = curl_error($curl); //错误信息
        //关闭curl
        curl_close($curl);
        return $data;
    }

    /**
     * curl
     */

    public function curl_get($url){
        if (function_exists('curl_init')) {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,false);
            $dxycontent = curl_exec($ch);
            return $dxycontent;
        } else {
            return '汗！貌似您的服务器尚未开启curl扩展，无法收到来自云落的通知，请联系您的主机商开启，本地调试请无视';
        }
    }
    /**
     * curl
     */
    public function curl_upload($url,$path){
    	$curl = curl_init($url);
        curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($curl,CURLOPT_POST,true);  //发送post
        $form_data = [
            'meida' => new \CURLFile($path)
        ];
        curl_setopt($curl,CURLOPT_POSTFIELDS,$form_data);
        $data = curl_exec($curl);
        //$errno = curl_errno($curl);  //错误码
        //$err_msg = curl_error($curl); //错误信息
        curl_close($curl);
        return $data;
    }
    /**
     * 清除api次数
     */
    public function clear(){
        $url ="https://api.weixin.qq.com/cgi-bin/clear_quota?access_token=".$this->access_token();
        $appid ="wxaf15615068649b19";
        $data =['appid'=>$appid];
        $dd =$this->curl_post($url,json_encode($data));
    }
    /**
     * jssdk
     */
    public function jssdk(){
        $jssdk ="jssdk";
        //判断是否有值
        if ($this->redis->exists($jssdk)) {
            //redis取值
            return $this->redis->get($jssdk);
        }else{
            //用file_get_contents
            $res =file_get_contents("https://api.weixin.qq.com/cgi-bin/ticket/getticket?access_token=".$this->access_token()."&type=jsapi");
            $res =json_decode($res,1);
            //存在redis
            $this->redis->set($jssdk,$res['ticket'],$res['expires_in']);
            return $res['ticket'];
        }

    }

    /**
    * 网页授权获取用户openid
    * @return [type] [description]
    */
    public function getopenid()
    {
        // echo 1;die;
        //先去session里取openid
        $openid = session('wechat_openid');
        //var_dump($openid);die;
        if(!empty($openid)){
            return $openid;
        }
        //微信授权成功后 跳转咱们配置的地址 （回调地址）带一个code参数
        $code = request()->input('code');
        if(empty($code)){
            //没有授权 跳转到微信服务器进行授权
            $host = $_SERVER['HTTP_HOST'];  //域名
            $uri = $_SERVER['REQUEST_URI']; //路由参数
            $redirect_uri = urlencode("http://".$host.$uri);  // ?code=xx
            $url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=".env('WECHAT_APPID')."&redirect_uri=".$redirect_uri."&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect";
            header("location:".$url);die;
        }else{
            //通过code换取网页授权access_token
            $url =  "https://api.weixin.qq.com/sns/oauth2/access_token?appid=".env('WECHAT_APPID')."&secret=".env('WECHAT_SECRET')."&code=".$code."&grant_type=authorization_code";
            $data = file_get_contents($url);
            $data = json_decode($data,true);
            $openid = $data['openid'];
            //获取到openid之后  存储到session当中
            session(['wechat_openid'=>$openid]);
            return $openid;
            //如果是非静默授权 再通过openid  access_token获取用户信息
        }
    }




}
 ?>
