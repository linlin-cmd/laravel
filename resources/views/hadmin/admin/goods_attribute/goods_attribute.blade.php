<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>属性</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    {{--    全局js--}}
    <script src="{{asset('hadmin/js/jquery.min.js?v=2.1.4')}}"></script>
    <script src="{{asset('hadmin/js/bootstrap.min.js?v=3.3.6')}}"></script>
</head>
<body class="gray-bg">
<center>
    <form class="form-inline">
        <div class="form-group has-success has-feedback">
            <label class="control-label" for="inputSuccess4">属性名称</label>
            <input type="text" class="form-control" name="attribute_name">
            <select name="goods_type" id="" class="form-control">
                <option value="">请选择..</option>
                @foreach($type as $v)
                    <option value="{{$v->type_id}}">{{$v->type_name}}</option>
                @endforeach
            </select>
            属性是否可选:
            <input type="radio" name="is_attribute" id="optionsRadios2" value="0">参数
            <input type="radio" name="is_attribute" id="optionsRadios2" value="1">规格
        </div>
        <button type="button" class="btn btn-info" id="attribute">添加</button>
        <a class="btn btn-info" href="{{url('hadmin/goods_attribute_list')}}">属性列表</a>
    </form>
</center>
</body>
</html>
<script>
    $('#attribute').on('click',function(){
        var attribute_name =$('[name="attribute_name"]').val();
        var goods_type =$('[name="goods_type"]').val();
        var is_attribute =$('[name="is_attribute"]').val();
        //发送添加的ajax
        $.ajax({
            url:"{{url('hadmin/goods_attribute_do')}}",
            dataType:"json",
            type:"POST",
            data:{attribute_name:attribute_name,goods_type:goods_type,is_attribute:is_attribute},
            success:function(res){
                if(res.ret==1){
                    alert(res.msg);
                    window.location.href="{{url('hadmin/goods_attribute_list')}}";
                }
            }
        })
    })
</script>

