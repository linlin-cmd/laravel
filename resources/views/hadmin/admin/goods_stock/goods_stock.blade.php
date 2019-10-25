<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>商品展示</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="gray-bg">
<form class="form-inline">
    <div class="form-group">
        <label class="sr-only" for="exampleInputEmail3">分类</label>
        <select name="cat_id" id="" class="form-control">
            <option value="0">请选择..</option>
            @foreach($goods_cat as $v)
                <option value="{{$v->cat_id}}">{{$v->cat_name}}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <label class="sr-only" for="exampleInputPassword3">Password</label>
        <input type="text" class="form-control" id="exampleInputPassword3" placeholder="商品名称" name="goods_name">
    </div>
    <button type="submit" class="btn btn-default">搜索</button>
</form>
<table class="table table-bordered">
    <tr>
        <td>商品id</td>
        <td>商品名称</td>
        <td>分类名称</td>
        <td>货号</td>
        <td>价格</td>
        <td>描述</td>
        <td>访问量</td>
        <td>操作</td>
    </tr>
    @foreach($goods as $v)
        <tr>
            <td>{{$v->goods_id}}</td>
            <td><p class="goods_name">{{$v->goods_name}}</p> <input type="text" name="goods_name" style="display:none;" class="blur" goods_id="{{$v->goods_id}}"></td>
            <td>{{$v->cat_name}}</td>
            <td>{{$v->goods_sn}}</td>
            <td>{{$v->goods_price}}</td>
            <td>{{$v->goods_desc}}</td>
            <td>{{$v->goods_visit}}</td>
            <td><a href=""></a></td>
        </tr>
    @endforeach
</table>
        {{$goods->appends(['goods_name' =>$goods_name,'cat_id'=>$cat_id])->links()}}
</body>
</html>
<!-- 全局js -->
<script src="{{asset('hadmin/js/jquery.min.js?v=2.1.4')}}"></script>
<script src="{{asset('hadmin/js/bootstrap.min.js?v=3.3.6')}}"></script>
<script>
    $('.goods_name').on('click',function(){
        var goods_name =$(this).text();
        $(this).hide();
        $(this).next().show().val(goods_name).focus();
    })
    $(document).on('blur','.blur',function(){
        var goods_name =$(this).val();
        var goods_id =$(this).attr('goods_id');
        //隐藏文本框
        $(this).hide();
        //显示p标签
        $(this).prev().show().text(goods_name);
        $.ajax({
            url:"{{url('hadmin/say')}}",
            dataType:"json",
            data:{goods_name:goods_name,goods_id:goods_id},
            success:function(res){
                if(res.ret==1){
                    alert(res.msg);
                }
            }
        })
    })
</script>
