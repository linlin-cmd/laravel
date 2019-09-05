<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
class WareController extends Controller
{
	public function login(){
		return view('ware/login');
	}
	public function login_do(){
		$post =request()->except('_token');
		//查询数据
		$res =DB::table('ware')->where(['w_name'=>$post['w_name']])->first();
		if ($res) {
			if ($post['w_pwd'] != $res->w_pwd) {
				return redirect('ware/login');
			}else{
				request()->session()->put('ware',$res);
				return redirect('ware/info');
			}
		}else{
			return redirect('ware/login');
		}
	}
	public function info(){
		return view('ware/info');
	}
	//用户管理
    public function user_add(){
    	return view('ware/user_add');
    }
    public function user_add_do(){
    	$post =request()->except('_token');
    	$res =DB::table('ware')->insert($post);
    	if ($res) {
    		return redirect('ware/user_list');
    	}
    }
    public function user_list(){
    	$data =DB::table('ware')->get();
    	return view('ware/user_list',compact('data'));
    }
    public function user_upd($id){
    	$data =DB::table('ware')->where('w_id',$id)->first();
    	return view('ware/user_upd',compact('data'));
    }
    public function user_upd_do($id){
    	$post =request()->except('_token');
    	$upd =DB::table('ware')->where('w_id',$id)->update($post);
    	if ($upd) {
    		return redirect('ware/user_list');
    	}
    }
    //货物管理
    public function goods_add(){
    	return view('ware/goods_add');
    }
    public function goods_add_do(){
    	$post =request()->except('_token');
    	// dd($post);
    	if (request()->hasFile('goods_img')) {
			$post['goods_img'] =upload('goods_img');
		}
		$post ['add_time']=time();
		$res =DB::table('ware_goods')->insertGetId($post);
		if ($res) {
			//入库后记录日志
			$arr=[
				'w_id'=>session('ware')->w_id,
				'goods_id'=>$res,
				'add_time'=>time(),
				'type'=>0
			];
			$login =DB::table('ware_login')->insert($arr);
			return redirect('ware/goods_list');
		}
    }
    public function goods_list(){
    	$data =DB::table('ware_goods')->get();
    	return view('ware/goods_list',compact('data'));
    }
    public function goods_upd($id){
    	$data =DB::table('ware_goods')->where('goods_id',$id)->first();
    	return view('ware/goods_upd',compact('data'));
    }
    public function goods_upd_do($id){
    	$post =request()->except('_token');
    	//查询
    	$data =DB::table('ware_goods')->where('goods_id',$id)->first();
    	if ($data->goods_number <= $post['goods_number']) {
    		echo "<script>alert('出库数量不能大于库存');history.go(-1);</script>";exit;
    	}
    	$number =$data->goods_number -$post['goods_number'];
    	$post ['goods_number'] =$number;
    	$upd =DB::table('ware_goods')->where('goods_id',$id)->update($post);
    	if ($upd) {
    		//入库后记录日志
			$arr=[
				'w_id'=>session('ware')->w_id,
				'goods_id'=>$id,
				'add_time'=>time(),
				'type'=>1
			];
			$login =DB::table('ware_login')->insert($arr);
    		return redirect('ware/goods_list');
    	}
    }
    public function list(){
    	$data =DB::table('ware_login')->get();
    	//查询数据
    	$where =[
    		'w_id'=>session('ware')->w_id
    	];
    	$info =DB::table('ware_login')->where($where)->get();
    	return view('ware/list',compact('data','info'));
    }
}
