<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <title> - 登录</title>
    <meta name="keywords" content="">
    <meta name="description" content="">

    <link rel="shortcut icon" href="favicon.ico"> <link href="{{asset('hadmin/css/bootstrap.min.css?v=3.3.6')}}" rel="stylesheet">
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

            <form class="m-t" role="form">
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="用户名" name="name" value="">
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="年龄" name="age"  value="">
                </div>
                <button type="button" class="btn btn-primary block full-width m-b" id="update">修 改</button>
            </form>
        </div>
    </div>

    <!-- 全局js -->
    <script src="{{asset('hadmin/js/jquery.min.js?v=2.1.4')}}"></script>
    <script src="{{asset('hadmin/js/bootstrap.min.js?v=3.3.6')}}"></script>

    
    

</body>

</html>
<script>
    function GetQueryString(name)
{
     var reg = new RegExp("(^|&)"+ name +"=([^&]*)(&|$)");
     var r = window.location.search.substr(1).match(reg);
     if(r!=null)return  unescape(r[2]); return null;
}
    //取值
    var id =GetQueryString('id');
    var url="http://w3.shop.com/api/test"
    $.ajax({
        url:url+"/"+id,
        type:"GET",
        dataType:"json",
        success:function(res){
            $('[name="name"]').val(res.data.name);
            $('[name="age"]').val(res.data.age);
        }
    })
    //修改执行
    $('#update').on('click',function(){
        var name =$('[name="name"]').val();
        var age =$('[name="age"]').val();
        $.ajax({
            url:url+"/"+id,
            dataType:"json",
            type:"POST",
            data:{name:name,age:age,"_method":"PUT"},
            success:function(res){
                if (res.ret==1) {
                    alert(res.msg);
                    window.location.href="http://w3.shop.com/api/show";
                }
            }
        })
    })
</script>