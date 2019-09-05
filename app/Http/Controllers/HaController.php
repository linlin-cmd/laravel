<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Cookie;
use App\model\Student;
use Illuminate\Support\Facades\Redis;
class HaController extends Controller
{
    public function index(){
    	return "我的猫呢";
    }
    public function add(){
        //redis
        // Redis::set('name','哈哈哈哈');
        // echo Redis::get('name');
        // die;


        // //memcache
        // //increment+1  decrement-1
        // $memcache = new \Memcache;
        // $memcache->connect('127.0.0.1','11211');
        // //取值
        // $data =$memcache->get('HaController_add_student');

        // if (empty($res)) {
        //     $data =json_encode(DB::table('student')->get());
        //     $memcache->set('HaController_add_student',$data, 0,10);
        // }
        
        
        // print_r($data);
        // die;
        // //存session
        // $login =['id'=>1,'name'=>"林林"];
        // session(['login' => $login]);
        // //取session
        // $user =session('login');
        // //添加session入库
        // request()->session()->save();
        //清除session
        // session(['user'=>'null']);
        // $user =session('user');
        // dd($user);


        //存cookie
        // Cookie::queue('uu','kk',24*60);
    	return view('add');
    }
    public function add_do(){
        $name ="image";
        //文件上传
        if (!empty(request()->hasFile($name)) && request()->file($name)->isValid()) 
        {
            $store_result = request()->file($name)->store('okk');
        }
        dd($store_result);
    	// $post =request()->except('_token');
    	// $res =Student::create($post);
    	// if ($res) {
    	// 	return redirect('student/list');
    	// }
    }
    public function lists(){
        
        $user =request()->cookie('lin');
        // dd($user);
    	$data =DB::table('student')->get();
    	return view('lists',['data'=>$data]);
    }
    public function delete($id){
        $del =Student::destroy($id);
        if ($del) {
            return redirect('student/list');
        }
    }
    public function update($id){
        $upd =Student::find($id);
        // dd($upd);
        return view('update',['upd'=>$upd]);
    }
    public function update_do($id){
        $post =request()->except('_token');
        $res =Student::where(['s_id'=>$id])->update($post);
        return redirect('student/list');
    }
}
