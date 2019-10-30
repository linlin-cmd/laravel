<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <form action="{{url('kao/wechat_list_do')}}" method="post">
        <span>appid:{{$kao_wechat->app_id}}</span><br>
        <span>appsecret:{{$kao_wechat->appsecret}}</span><br>
        安全域名:<input type="text" name="app_url" value="{{$kao_wechat->app_url}}"><br>
        <input type="hidden" name="app_id" value="{{$kao_wechat->app_id}}">
        <input type="hidden" name="appsecret" value="{{$kao_wechat->appsecret}}">
        <input type="submit" value="绑定">
    </form>
</body>
</html>
