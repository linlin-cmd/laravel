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
    <div class="form-group">
        <label class="sr-only" for="exampleInputAmount">商品类型搜索</label>
        <div class="input-group">
            <select name="attribute_name" id="search" class="form-control">
                <option value="">请选择...</option>
                @foreach ($type_name as $v)
                    <option value="{{$v->type_id}}">{{$v->type_name}}</option>
                @endforeach
            </select>
        </div>
    </div>
</form>
</center>
    <table class="table table-bordered">
        <tr>
            <td><input type="checkbox" class="check">属性id</td>
            <td>属性名称</td>
            <td>属性类型</td>
            <td>操作</td>
        </tr>
    <tbody class="list">
        @foreach($type as $v)
            <tr>
                <td><input type="checkbox" name="check">{{$v->attribute_id}}</td>
                <td>{{$v->attribute_name}}</td>
                <td>{{$v->type_name}}</td>
                <td></td>
            </tr>
        @endforeach
    </tbody>
    </table>
</body>
</html>
<script>
    $('#search').on('change',function(){
        var attribute_name =$('[name="attribute_name"]').val();
        $.ajax({
            url:"{{url('hadmin/search')}}",
            dataType:"json",
            data:{attribute_name:attribute_name},
            success:function(res){
                $('.list').empty();
                $.each(res,function(i,v){
                    var tr =$("<tr></tr>");
                    tr.append('<td><input type="checkbox" name="check">'+v.attribute_id+'</td>');
                    tr.append('<td>'+v.attribute_name+'</td>');
                    tr.append('<td>'+v.type_name+'</td>');
                    $('.list').append(tr);
                })
            }
        })
    })
    //全选
    $('.check').on('click',function(){
        $('[name="check"]').prop('checked',$(this).prop('checked'));
    })
    //批量删除
</script>
