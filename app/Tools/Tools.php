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
    		$result =file_get_contents('https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=wxaf15615068649b19&secret=5af8270de69be6b59591223b74ccb8cd');
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
}
 ?>