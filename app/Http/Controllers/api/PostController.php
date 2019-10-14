<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\model\api\User;
use Illuminate\Support\Facades\Storage;
class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $where =[];
        $name =request()->name;
        $page =request()->page;
        $user = new User;
        if (isset($name)) {
            $where[]=['name','like',"%$name%"];
        }
        $user =$user->where($where)->paginate(3);
        return json_encode(['ret'=>1,'msg'=>'查询成功','data'=>$user]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        echo "create";die;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $get =Request()->all();
        //文件夹名称
        $time =date('Y-n-j');
        dd($get);
        //文件上传
        if ($request->hasFile('file')) {
            Storage::put("api/".$time,$get);
        }
        $user = new User;
        // $user =$user->create($get);直接添加
        //调用方法
        $user =$user->create($get);
        if ($user) {
            return json_encode(['ret'=>1,'msg'=>"添加成功"]);
        }else{
            return json_encode(['ret'=>0,'msg'=>"添加失败"]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user =new User;
        $user =$user->find($id);
        return json_encode(['ret'=>1,'msg'=>'查询成功','data'=>$user]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        echo "edit";die;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user =new User;
        $user =$user->destroy($id);
        if ($user) {
            return json_encode(['ret'=>1,'msg'=>'删除成功']);
        }else{
            return json_encode(['ret'=>0,'msg'=>'删除失败']);
        }
    }
}
