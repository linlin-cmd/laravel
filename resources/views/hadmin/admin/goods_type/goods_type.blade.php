<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>类型</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    {{--    全局js--}}
    <script src="{{asset('hadmin/js/jquery.min.js?v=2.1.4')}}"></script>
    <script src="{{asset('hadmin/js/bootstrap.min.js?v=3.3.6')}}"></script>
</head>
<body class="gray-bg">
<center>
    <form class="form-inline">
        <div class="form-group has-success has-feedback">
            <label class="control-label" for="inputSuccess4">类型名称</label>
            <input type="text" class="form-control" name="type_name">
        </div>
        <button type="button" class="btn btn-info" id="type">添加</button>
        <a class="btn btn-info" href="{{url('hadmin/goods_type_list')}}">类型列表</a>
    </form>
</center>
</body>
</html>
<script>
    $('#type').on('click',function(){
        var type_name =$('[name="type_name"]').val();
        //发送添加的ajax
        $.ajax({
            url:"{{url('hadmin/goods_type_do')}}",
            dataType:"json",
            type:"POST",
            data:{type_name:type_name},
            success:function(res){
                if(res.ret==1){
                    alert(res.msg);
                    window.location.href="{{url('hadmin/goods_type_list')}}";
                }
            }
        })
    })
</script>
