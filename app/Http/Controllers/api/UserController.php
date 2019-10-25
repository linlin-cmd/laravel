<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\model\api\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
class UserController extends Controller
{
    public function add(){
        $get =request()->all();
        $user = new User;
        //$user =$user->create($get);直接添加
        //调用方法
        $user =$user->createa($get);
        if ($user) {
            return json_encode(['ret'=>1,'msg'=>"添加成功"]);
        }else{
            return json_encode(['ret'=>0,'msg'=>"添加失败"]);
        }
    }
    /**
     * 列表展示
     * @return [type] [description]
     */
    public function list(){
        $user = new User;
        $user =$user->getAll();
        return json_encode(['ret'=>1,'msg'=>'查询成功','data'=>$user]);
    }
    public function delete(){
        $id =request()->id;
        $user =new User;
        $user =$user->destroy($id);
        if ($user) {
            return json_encode(['ret'=>1,'msg'=>'删除成功']);
        }else{
            return json_encode(['ret'=>0,'msg'=>'删除失败']);
        }

    }
    public function update(){
        $id =request()->id;
        $user =new User;
        $user =$user->find($id);
        return json_encode(['ret'=>1,'msg'=>'查询成功','data'=>$user]);
    }
    public function update_do(){

        $id =request()->id;
        $name =request()->name;
        $age =request()->age;
        $user =new User;
        $user =$user->where(['id'=>$id])->update(['name'=>$name,'age'=>$age]);
        if ($user) {
            return json_encode(['ret'=>1,'msg'=>'修改成功']);
        }else{
            return json_encode(['ret'=>0,'msg'=>'修改失败']);
        }
    }
    public function upp(){
        $tmp_name =request()->file('file');
        //文件夹名称
        $time =date('Y-n-j');
        //路径
        $path_sto =storage_path('app/public/api/'.$time);
        //创建文件夹
        if (!file_exists($path_sto)) {
            mkdir($path_sto);
        }
        Storage::put("api/".$time,$tmp_name);
    }
    public function weather(){
        $city =request()->city;
        if (!empty($city)){
            $cache =Cache::get('K780'.$city);
            if (empty($cache)){
                $url ="http://api.k780.com/?app=weather.realtime&weaid=".$city."&ag=today,futureDay,lifeIndex,futureHour&appkey=".env('K780_APPKEY')."&sign=".env('K780_SIGN')."&format=json";
                $res =file_get_contents($url);
                $res =json_decode($res,1);
                //获取当天二十四点的时间
                $date =date('Y-m-d');
                //今天凌晨+一天的时间
                $time =strtotime($date)+86400;
                $catime =$time-time();
                Cache::put('K780'.$city,$res,$catime);
                return json_encode($res);
            }
            return json_encode($cache);
        }
    }
}
