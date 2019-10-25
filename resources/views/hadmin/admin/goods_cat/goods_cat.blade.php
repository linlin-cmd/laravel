<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>分类</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
{{--    全局js--}}
    <script src="{{asset('hadmin/js/jquery.min.js?v=2.1.4')}}"></script>
    <script src="{{asset('hadmin/js/bootstrap.min.js?v=3.3.6')}}"></script>
</head>
<body class="gray-bg">
<center>
    <form class="form-inline">
        <div class="form-group has-success has-feedback">
            <label class="control-label" for="inputSuccess4">分类名称</label>
            <input type="text" class="form-control" name="cat_name" id="cat_name">
            <select name="parent_id" id="" class="form-control">
                <option value="0">顶级分类</option>
                @foreach ($hadmin_cat as  $v)
                    <option value="{{$v->cat_id}}">{{str_repeat("---",$v->level)}}{{$v->cat_name}}</option>
                @endforeach
            </select>
        </div>
        <button type="button" class="btn btn-info" id="cat">添加</button>
        <a class="btn btn-info" href="{{url('hadmin/goods_cat_list')}}">分类列表</a>
    </form>
</center>
</body>
</html>
<script>
    $('#cat').on('click',function(){
        var cat_name =$('[name="cat_name"]').val();
        var parent_id =$('[name="parent_id"]').val();
        flag =false;
        //唯一性验证
        $.ajax({
            url:"{{url('hadmin/only')}}",
            dataType:"json",
            async: false,
            data:{cat_name:cat_name},
            success:function(res){
                if(res.ret==1){
                    flag =true;
                    alert(res.msg);
                }
            }
        })
        if(flag){
            return false;
        }
        //发送添加的ajax
        $.ajax({
            url:"{{url('hadmin/goods_cat_do')}}",
            dataType:"json",
            type:"POST",
            data:{cat_name:cat_name,parent_id:parent_id},
            success:function(res){
                if(res.ret==1){
                    alert(res.msg);
                    window.location.href="{{url('hadmin/goods_cat_list')}}";
                }
            }
        })
    })
</script>
