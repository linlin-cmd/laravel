<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <title> - 扫码登录</title>
    <meta name="keywords" content="">
    <meta name="description" content="">

    <link rel="shortcut icon" href="favicon.ico"> <link href="css/bootstrap.min.css?v=3.3.6" rel="stylesheet">
    <link href="{{asset('hadmin/css/font-awesome.css?v=4.4.0')}}" rel="stylesheet">

    <link href="{{asset('hadmin/css/animate.css')}}" rel="stylesheet">
    <link href="{{asset('hadmin/css/style.css?v=4.1.0')}}" rel="stylesheet">
    <!-- 全局js -->
    <script src="{{asset('hadmin/js/jquery.min.js?v=2.1.4')}}"></script>
    <script src="{{asset('hadmin/js/bootstrap.min.js?v=3.3.6')}}"></script>
    <!--[if lt IE 9]>
    <meta http-equiv="refresh" content="0;ie.html" />
    <![endif]-->
    <script>if(window.top !== window.self){ window.top.location = window.location;}</script>
</head>

<body class="gray-bg">

    <div class="middle-box text-center loginscreen  animated fadeInDown">
        <h1 class="logo-name">h</h1>
        <h3>欢迎使用 hAdmin</h3>
        <!-- 二维码 -->
        <img src="http://qr.liantu.com/api.php?text={{$url}}" onclick="check()"/>
    </div>

    
    

</body>

</html>
<script>
    //每隔几秒
    var t =setInterval("check();",2000);
    //setTimeout
    var id ={{$id}};
    function check(){
        //js轮循
        $.ajax({
            url:"{{url('hadmin/check_wechat_login')}}",
            dataType:"json",
            data:{id:id},
            success:function(res){
                if (res.ret==1) {
                    clearInterval(t);
                    alert(res.msg);
                    location.href="{{url('hadmin/index')}}";
                }
            }
        })
    }
</script>