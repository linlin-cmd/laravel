<?php

namespace App\Http\Controllers;

use App\Tools\Aes;
use App\Tools\rsa;
use App\Tools\Tools;
use Illuminate\Http\Request;
use App\Http\Requests\StoreGoods_userPost;
use App\model\Kao;
use DB;
use App\model\kao_new;
class KaoController extends Controller
{
    public function index(){
        //非对称加密
        $Rsa = new Rsa();

        $privkey = file_get_contents("cert_private.pem");//$keys['privkey'];
        $pubkey  = file_get_contents("cert_public.pem");//$keys['pubkey'];
        $Rsa->init($privkey, $pubkey,TRUE);
        //私钥加密
        $data ="php是啊";
        $encode = $Rsa->priv_encode($data);

        dump($encode);
        $ret = $Rsa->pub_decode($encode);
        dump($ret);
//        dump($Rsa);
//        $keys = $Rsa->new_rsa_key(); //生成完key之后应该记录下key值，这里省略
        dd();


        /**
         * aes对称加密
         */
        $obj =new Aes('1321564561315465');
        $data ="林林喜欢猫";
        dump($eStr =$obj->encrypt($data));
        dump($obj->decrypt($eStr));
        dd();

        /**
         * 数据处理测试
         */
        $linlin =DB::table('linlin')->get();
        foreach ($linlin as $k=>$v){
            $class =DB::table('kkk')->where(['class_id'=>$v->class_id])->get();
            $class_aa[$k]['count'] =count($class);
            $class_aa[$k]['class_id'] =$v->class_id;
            $class_aa[$k]['class_name'] =$v->class_name;
            $class_aa[$k]['class']=$class;
        }
        return view('index',['class_aa'=>$class_aa]);
        dd($class_aa);


        dd();
        $linlin =DB::table('linlin')->join('kkk','linlin.class_id','=','kkk.class_id')->get();
        $linlin =json_encode($linlin);
        $linlin =json_decode($linlin,1);
        $class =[];
        foreach ($linlin as $k=>$v)
        {

            $class[$v['class_name']][] =$v;
        }
        foreach ($class as $k=>$v)
        {
            $dd[$k][] =count($v);
        }
        dd($dd);
        dd();

    }
    public function add_do(StoreGoods_userPost $request){
    	$post =request()->except('_token');
    	if (request()->hasFile('kao_img')) {
		 	$post['kao_img'] =upload('kao_img');
		}
		$res =Kaoo::create($post);
		if ($res) {
			return redirect('kao/list');
		}
    }
    public function kao_list(){
    	$pagesize =config('app.pagesize');
    	//搜索
    	$query =request()->post();
    	//接收值
    	$name =$query['kao_name']??"";
    	//定义数组
    	$where =[];
    	//判断是否存在
    	if ($name) {
    		$where[] =['kao_name','like','%'.$name.'%'];
    	}
    	$data =Kaoo::where($where)->paginate($pagesize);
    	return view('kao_list',compact('data','name'));
    }
    public function kao_del(){
    	$kao_id =request()->id;
    	$del =Kaoo::destroy($kao_id);
    	if ($del) {
    		return ['ret'=>1,'msg'=>'删除成功'];
    	}
    }
    public function update($id){
    	$data =Kaoo::find($id);
    	return view('update',['data'=>$data]);
    }
    public function update_do( StoreGoods_userPost $id){
    	$post =request()->except('_token');
    	if (request()->hasFile('kao_img')) {
		 	if ($post['oidimg']) {
		 		$post['kao_img'] =upload('kao_img');
		 		$filename =storage_path('app/public').'/'.$post['oidimg'];
	            //判断是否存在
	            if (file_exists($filename)) {
	                unlink($filename);
	            }
		 	}else{
		 		$post['kao_img'] =upload('kao_img');
		 	}

		}
		unset($post['oidimg']);
		$res =Kaoo::where(['kao_id'=>$id])->update($post);
		return redirect('kao/list');
    }
    public function wei(){
    	$kao_name =request()->kao_name;
        //id
        $kao_id =request()->kao_id??"";
        if ($kao_name) {
            $where[] =['kao_name','=',$kao_name];
        }
        if ($kao_id) {
            $where[] =['kao_id','!=',$kao_id];
        }
    	// echo $kao_name;die;
    	$res =Kaoo::where($where)->count();
    	if ($res) {
    		return ['ret'=>1,'msg'=>'用户名已存在'];
    	}
    }
    public function new()
    {
        $curl =new Tools;
        $url ="http://api.avatardata.cn/ActNews/LookUp?key=f2403840b8e0445e9c671fbd066b980e";
        $look =$curl->curl_get($url);
        $look =json_decode($look,1);
        for ($i=0; $i<=9; $i++)
        {
            $name[] =$look['result'][$i];
        }
//        $name =[
//            0=>'特雷莎',
//            1=>'约翰逊',
//            2=>'奥巴马',
//            3=>'克拉克',
//            4=>'特朗普',
//            5=>'克林顿',
//            6=>'马德兴',
//            7=>'马克龙',
//            8=>'乔布斯',
//            9=>'福布斯'
//        ];
        foreach ($name as $k=>$v)
        {
            $url ="http://api.avatardata.cn/ActNews/Query?key=f2403840b8e0445e9c671fbd066b980e&keyword={$v}";
            $res=$curl->curl_get($url);
            $new[]=json_decode($res,1);
        }
        foreach ($new as $kk=>$vv)
        {
            //判断是否为空
            if (!empty($vv['result']))
            {
                foreach ($vv['result'] as $k=>$v)
                {
                    $kao_new =kao_new::where(['title'=>$v['title']])->first();
                    if (!$kao_new)
                    {
                        kao_new::create([
                            'title'=>$v['title'],
                            'content'=>$v['content'],
                            'img_width'=>$v['img_width'],
                            'full_title'=>$v['full_title'],
                            'pdate'=>$v['pdate'],
                            'src'=>$v['src'],
                            'img_length'=>$v['img_length'],
                            'img'=>$v['img'],
                            'url'=>$v['url'],
                            'pdate_src'=>strtotime($v['pdate_src'])
                        ]);
                    }
                }
            }else{
                echo 1;
            }
        }
    }
    public function wechat(){
        return view('kao_wechat');
    }
    public function wechat_list(){
        $app_id =request()->app_id;
        $appsecret =request()->appsecret;
        $kao_wechat =DB::table('kao_wechat')->where(['app_id'=>123123,'appsecret'=>456456])->first();
        return view('kao_wechat_list',['kao_wechat'=>$kao_wechat]);
    }
    public function wechat_do(){

    }
    public function wechat_list_do(){
        $app_url =request()->app_url;
        $app_id =request()->app_id;
        $appsecret =request()->appsecret;
        $kao_wechat =DB::table('kao_wechat')->where(['app_id'=>$app_id,'appsecret'=>$appsecret])->update(['app_url'=>$app_url]);
        if ($kao_wechat){
            return redirect('kao/wechat_list');
        }
    }
    public function wechat_token(){
        $app_id =request()->app_id;
        $appsecret =request()->appsecret;
        $app_url ="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
        if (empty($app_id)){
            return json_encode(['ret'=>201,'msg'=>'请传递app_id'],JSON_UNESCAPED_UNICODE);
        }
        if (empty($appsecret)){
            return json_encode(['ret'=>201,'msg'=>'请传递appsecret'],JSON_UNESCAPED_UNICODE);
        }
        $kao_wechat =DB::table('kao_wechat')->where(['app_id'=>$app_id,'appsecret'=>$appsecret])->first();

        $token =md5("1902".rand(1000,9999));
        $time =time()+7200;
        if ($kao_wechat)
        {
//            if ($app_url != $kao_wechat->app_url)
//            {
//                return json_encode(['ret'=>201,'msg'=>'访问地址与您绑定地址不符!'],JSON_UNESCAPED_UNICODE);
//            }else{
//
//            }

            $kao_wechat =DB::table('kao_wechat')->where(['app_id'=>$app_id,'appsecret'=>$appsecret])->update(['token'=>$token,'time'=>$time]);
            return json_encode(['ret'=>1,'msg'=>$kao_wechat['token'],'time'=>7200]);
        }

    }
    public function ce_wechat(){
        $app_id =123123;
        $appsecret =456456;
        $url ="http://www.wenroulin.cn/kao/wechat_token?app_id=".$app_id."&appsecret=".$appsecret;
        $res =file_get_contents($url);
        dd($res);
    }
}
