<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
class TeamController extends Controller
{
    public function add(){

    	return view('team/add');
    }
    public function add_do(){
    	$post =request()->except('_token');
    	$v= strtotime($post['add_time']);
    	$post['add_time'] =$v;
    	$data =DB::table('team')->insert($post);
    	if ($data) {
    		return redirect('team/list');
    	}
    }
    public function list(){
    	$data =DB::table('team')->get();
    	$data =json_decode(json_encode($data),true);
    	//循环判断
    	foreach ($data as $key => $value) {
    		if ($data[$key]['add_time'] >=time()) {
	    		$data[$key]['result'] ="竞猜";
	    	}else{
	    		$data[$key]['result'] ="查看结果";
	    	}
    	}
    	// dd($data);
    	
    	return view('team/list',compact('data'));
    }
    //我要竞猜
    public function want_guess($id){
    	$data =DB::table('team')->where(['team_id'=>$id])->first();
    	return view('team/want_guess',compact('data'));
    }
    public function want_guess_do(){
    	$post =request()->except('_token');
    	$cont =DB::table('guess')->where(['team_id'=>$post['team_id']])->count();
    	if ($cont) {
    		return;
    	}else{
    		$data =DB::table('guess')->insert($post);
    	}
    	if ($data) {
    		return redirect('team/list');
    	}
    }
    //查看结果
    public function guess($id){
    	//查看竞猜结果
    	$data =DB::table('guess')->where(['team_id'=>$id])->first();
    	//查看竞猜时间
    	$team =DB::table('team')->where(['team_id'=>$id])->first();
    	//查看是否有
    	$count =DB::table('guess')->where(['team_id'=>$id])->count();
    	return view('team/guess',compact('data','team','count'));
    }
}
