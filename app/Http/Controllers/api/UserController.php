<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\model\api\User;
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
}
