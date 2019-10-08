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
            <h3>绑定账号</h3>

            <form class="m-t" role="form" method="post" action="{{url('hadmin/account_do')}}">
                @csrf
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="用户名" required="" name="name">
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" placeholder="密码" required="" name="password">
                </div>
                <button type="submit" class="btn btn-primary block full-width m-b" id="account">绑 定 账 号</button>
                </p>

            </form>
        </div>
    </div>

    <!-- 全局js -->
    <script src="{{asset('hadmin/js/jquery.min.js?v=2.1.4')}}"></script>
    <script src="{{asset('hadmin/js/bootstrap.min.js?v=3.3.6')}}"></script>

    
    

</body>

</html>