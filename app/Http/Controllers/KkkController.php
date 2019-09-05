<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\model\Kkk;
class KkkController extends Controller
{
    public function add(){
    	return view('kkk/add');
    }
    public function add_do(){
    	$post =request()->except('_token');
    	$res =Kkk::create($post);
    	if ($res) {
    		return redirect('kkk/list');
    	}
    }
    public function list(){
    	$status =request()->status;
    	dump($status);
    	if ($status=="") {
    		//查询
    		$data =Kkk::where('status',1)->get();
    	}else{
    		$data =Kkk::where('status',0)->get();
    	}
    	return view('kkk/list',compact('data'));
    }
    public function del($id){
    	$res =Kkk::where('id',$id)->update(['status'=>0]);
    	if ($res) {
    		return redirect('kkk/list');
    	}
    }
    public function update($id){
    	//查询
    	$data =Kkk::find($id);
    	return view('kkk/update',compact('data'));
    }
    public function update_do($id){
    	//接收值
    	$post =request()->except('_token');
    	//修改
    	$upd =Kkk::where('id',$id)->update($post);
    	if ($upd) {
    		return redirect('kkk/list');
    	}
    }
}
