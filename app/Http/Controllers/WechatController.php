<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use DB;
use App\Tools\Tools;
use Illuminate\Support\Facades\Storage;
class WechatController extends Controller
{
    //依赖注入
    public $tools;
    public function __construct(Tools $tools)
    {
        $this->tools = $tools;
    }
    /**
     * 文件上传
     */
    public function upload()
    {
    	return view('wechat/upload');
    }
    public function do_upload(Client $client)
    {
        $type =request()->type;
        //定义一个变量
        $source_type = '';
        switch ($type){
            case 1: $source_type = 'image'; break;
            case 2: $source_type = 'voice'; break;
            case 3: $source_type = 'video'; break;
            case 4: $source_type = 'thumb'; break;
            default;
        }
    	$image ="image";
    	if (!empty(request()->hasFile($image))&&request()->file($image)->isValid())
    	{
            //文件类型
    		$ext = request()->file($image)->getClientOriginalExtension();
            //文件大小
            $size = request()->file($image)->getClientSize() / 1024 / 1024;
            //判断图片类型是图片
            if ($source_type=="video") {
                //检查是否有那个类型
                // if (!in_array($ext,['jpg','jpeg','png','gif'])) {
                //     dd('图片类型不支持');
                // }
                // if ($size >2) {
                //     dd('文件过大');
                // }

                //文件名称
                $file_name = time().rand(1000,9999).'.'.$ext;
                $path = request()->file($image)->storeAs('wechat/image',$file_name);
                $storage_path ='/storage/'.$path;
                //本地文件路径
                $path = realpath('./storage/'.$path);
                //获取media_id
                $url ="https://api.weixin.qq.com/cgi-bin/material/add_material?access_token=".$this->tools->access_token()."&type=VODEO";
                //curl
                // $result = $this->curl_upload($url,$path);
                //guzzle
                $title ="标题";
                $introduction ="描述";
                $result =$this->tools->guzzle_upload($url,$path,$client,$title,$introduction);
                //转为json数据
                $result =json_decode($result,true);
                //添加数据库
                DB::table('wechat')->insert([
                    'media_id'=>$result['media_id'],
                    'type'=>$type,
                    'path'=>$storage_path,
                    'add_time'=>time()
                ]);
                return redirect('source');
            }
    	}
    }
    /**
     * 素材管理
     */
    public function wechat_source(){
        $req = request()->all();
        //判断页面传过来的图片类型
        empty($req['type'])?$type="image":$type=$req['type'];
        //图片类型
        if(!in_array($type,['image','voice','video','thumb'])){
            dd('类型错误');
        }
        //判断页码
        empty($req['page'])?$page=1:$page=$req['page'];
        if($page <= 0 ){
            dd('页码错误');
        }
        //上一页
        $upper =$page-1;
        $upper <= 0 && $upper = 1;
        //下一页
        $next =$page+1;
        // dd($req);
        //获取素材列表
        $url ="https://api.weixin.qq.com/cgi-bin/material/batchget_material?access_token=".$this->tools->access_token();
        $data =[
            'type'=>$type,
            'offset'=>$page,
            'count'=>20
        ];
        //调用方法
        // $result =$this->curl_post($url,json_encode($data));
        // $result =json_decode($result);
        // dd($result);
        //存在redis中
        //存
        // $redis =$this->tools->redis->set('source',$result);
        //取值
        $redis =$this->tools->redis->get('source');
        $redis =json_decode($redis,1);
        //media_id
        $media_id =[];
        // dd($type);
        $types=[
            'image'=>1,
            'voice'=>2,
            'video'=>3,
            'thumb'=>4
        ];
        //循环对应数据
        foreach ($types as $key => $value) {
            if ($type==$key) {
                $type=$value;
            };
        };
        foreach ($redis['item'] as $key => $value) {
            //同步数据库
             $lin =DB::table('wechat')->where('media_id','=',$value['media_id'])->first();
             // //media_id为空的时候
             if (empty($lin)) {
                 DB::table('wechat')->insert([
                    'media_id'=>$value['media_id'],
                    'file_name'=>$value['name'],
                    'type'=>$type,
                    'add_time'=>$value['update_time']
                 ]);
                 //echo "ok";
                 //die;
             }
             // dd($lin);
             $media_id[] =$value['media_id'];
         } 
        //通过media_id查询数据库
        $info =DB::table('wechat')->whereIn('media_id',$media_id)->get();
        // dd($media_id);
        return view('wechat.source',compact('info','upper','next','type'));
    }
    /**
     * 下载素材
     */
    public function material($id){
        //
        // $media_id ="xcH_Aqr51xPx2INR8ZnpPVWOPXXrpqXmJ-wq-Ld0vIU";
        $info =DB::table('wechat')->where(['id'=>$id])->first();
        //定义数组
        $source_arr = [1=>'image',2=>'voice',3=>'video',4=>'thumb'];
        //数据类型
        $source_type = $source_arr[$info->type]; //image,voice,video,thumb
        //media_id
        $media_id =$info->media_id;
        // dd($media_id);
        $url ="https://api.weixin.qq.com/cgi-bin/material/get_material?access_token=".$this->tools->access_token();
        //获取返回值
        $res =$this->tools->curl_post($url,json_encode(['media_id'=>$media_id]));
        if($source_type != 'video'){
            Storage::put('wechat/'.$source_type.'/'.$info->file_name, $res);
            DB::table('wechat')->where(['id'=>$id])->update([
                'path'=>'/storage/wechat/'.$source_type.'/'.$info->file_name,
            ]);
            dd('ok');
        }
        // $res =json_decode($res,1);
        // dd($res);
        // $connt =file_get_contents($res['down_url']);
        //视频
        $result = json_decode($res,1);
        //设置超时参数
        $opts=array(
            "http"=>array(
                "method"=>"GET",
                "timeout"=>3  //单位秒
            ),
        );
        //创建数据流上下文
        $context = stream_context_create($opts);
        //$url请求的地址，例如：
        $read = file_get_contents($result['down_url'],false, $context);
        Storage::put('wechat/video/'.$info['file_name'], $read);
        DB::table('wechat')->where(['id'=>$req['id']])->update([
            'path'=>'/storage/wechat/'.$source_type.'/'.$info->file_name,
        ]);
        dd('ok');
    }
}
