<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\model\News;
use Illuminate\Support\Facades\Redis;
use DB;
class NewsController extends Controller
{
    public function add(){
    	return view('news/add');
    }
    public function add_do(){
    	//接收表单页面的值
    	$post =request()->except('_token');
    	$post['add_time'] =time();
    	//添加
    	$res =News::create($post);
    	if ($res) {
    		return redirect('news/list');
    	}
    }
    public function list(){
    	$data =News::get();
    	foreach ($data as $key => $value) {
    		$v =Redis::get('name'.$value['news_id']);
    		$data[$key]['name'] =empty($v)? 0 :$v;
    	}
    	return view('news/list',compact('data'));
    }
    public function list_do($id){
    	$data =News::find($id);
    	return view('news/list_do',compact('data','id'));
    }
    //点赞
    public function give(){
    	//新闻id
    	$news_id =request()->news_id;
    	//用户id
    	$user_id =session('login')->user_id;
    	//拼接where条件
    	$where =[
    		'user_id'=>$user_id,
    		'news_id'=>$news_id,
    	];
    	//判断点赞用户点赞
		$res =DB::table('linlin')->where($where)->count();
		if (!$res) {
			Redis::incr('name'.$news_id);
			$data =DB::table('linlin')->insert($where);
		}
    	return json_decode(Redis::get('name'.$news_id));
    }
    //取消赞
    public function cancel(){
    	//新闻id
    	$news_id =request()->news_id;
    	//用户id
    	$user_id =session('login')->user_id;
    	//拼接where条件
    	$where =[
    		'user_id'=>$user_id,
    		'news_id'=>$news_id,
    	];
    	//判断点赞用户点赞
		$res =DB::table('linlin')->where($where)->count();
		if ($res) {
			Redis::decr('name'.$news_id);
			$res =DB::table('linlin')->where($where)->delete();
		}
    	return json_decode(Redis::get('name'.$news_id));
    }
}
