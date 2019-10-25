<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>分类</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="gray-bg">
    <table class="table table-bordered">
        <tr>
            <td>分类id</td>
            <td>分类名称</td>
            <td>操作</td>
        </tr>
    @foreach($hadmin_cat as $v)
        <tr>
            <td>{{$v->cat_id}}</td>
            <td>{{$v->cat_name}}</td>
            <td></td>
        </tr>
    @endforeach
    </table>
</body>
</html>
