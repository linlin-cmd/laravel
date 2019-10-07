<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <title> - 登录</title>
    <meta name="keywords" content="">
    <meta name="description" content="">

    <link rel="shortcut icon" href="favicon.ico"> <link href="css/bootstrap.min.css?v=3.3.6" rel="stylesheet">
    <link href="{{asset('hadmin/css/font-awesome.css?v=4.4.0')}}" rel="stylesheet">

    <link href="{{asset('hadmin/css/animate.css')}}" rel="stylesheet">
    <link href="{{asset('hadmin/css/style.css?v=4.1.0')}}" rel="stylesheet">
    <!--[if lt IE 9]>
    <meta http-equiv="refresh" content="0;ie.html" />
    <![endif]-->
    <script>if(window.top !== window.self){ window.top.location = window.location;}</script>
</head>

<body class="gray-bg">

    <div class="middle-box text-center loginscreen  animated fadeInDown">
        <div>
            <div>

                <h1 class="logo-name">h</h1>

            </div>
            <h3>欢迎使用 hAdmin</h3>

            <form class="m-t" role="form" action="{{url('hadmin/login_do')}}" method="post">
                @csrf
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="用户名" required="" name="name">
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" placeholder="密码" required="" name="password">
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="微信验证码" required="" name="code">
                    <input type="button" value="发送验证码" class="code">
                </div>
                <button type="submit" class="btn btn-primary block full-width m-b">登 录</button>
                <div class="form-group">
                    <img src="{{env('UPLOAD_URL')}}/wechat.jpg" width="100"height="100" display="inline">
                </div>

                <p class="text-muted text-center"> <a href="login.html#"><small>忘记密码了？</small></a> | <a href="register.html">注册一个新账号</a>
                </p>

            </form>
        </div>
    </div>

    <!-- 全局js -->
    <script src="{{asset('hadmin/js/jquery.min.js?v=2.1.4')}}"></script>
    <script src="{{asset('hadmin/js/bootstrap.min.js?v=3.3.6')}}"></script>

    
    

</body>

</html>
<script src="laravel/jq.js"></script>
<script type="text/javascript">
    $('.code').on('click',function(){
        //用户名
        var name =$('[name="name"]').val();
        //密码
        var password =$('[name="password"]').val();
        //发送ajax
        $.ajax({
            url:"{{url('hadmin/send')}}",
            data:{name:name,password:password},
            success:function(res){
            }
        })

    })
</script>