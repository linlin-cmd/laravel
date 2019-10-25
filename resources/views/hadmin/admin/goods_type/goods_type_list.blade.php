<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>类型展示</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="gray-bg">
<a class="btn btn-info" href="{{url('hadmin/goods_type')}}">添加类型</a>
<table class="table table-bordered">
    <tr>
        <td>类型id</td>
        <td>类型名称</td>
        <td>属性数</td>
        <td>操作</td>
    </tr>
    @foreach($type as $v)
        <tr>
            <td>{{$v['type_id']}}</td>
            <td>{{$v['type_name']}}</td>
            <td>{{$v['count']}}</td>
            <td></td>
        </tr>
    @endforeach
</table>
</body>
</html>
