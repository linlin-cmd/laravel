<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <title> - 添加</title>
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
            @csrf
            <div class="form-group">
                <input type="text" class="form-control" placeholder="商品名称" required="" name="goods_name">
            </div>
            <div class="form-group">
                <input type="text" class="form-control" placeholder="商品价钱" required="" name="goods_money">
            </div>
            <div class="form-group">
                <input type="file" required="" name="file">
            </div>
            <button type="button" class="btn btn-primary block full-width m-b" id="add">添 加 商 品</button>
        </form>
    </div>
</div>

<!-- 全局js -->
<script src="{{asset('hadmin/js/jquery.min.js?v=2.1.4')}}"></script>
<script src="{{asset('hadmin/js/bootstrap.min.js?v=3.3.6')}}"></script>




</body>

</html>
<script>
    $('#add').on('click',function(){
        var form =new FormData();
        var goods_name =$("[name='goods_name']").val();
        var goods_money =$("[name='goods_money']").val();
        form.append('goods_name',goods_name);
        form.append('goods_money',goods_money);
        //获取文件数据
        var file =$('[name="file"]')[0].files[0];
        form.append('file',file);
        var url="http://w3.shop.com/api/kao_goods";
        console.log(form);
        $.ajax({
            url:url,
            dataType:"json",
            type:"POST",
            contentType:false, //post数据类型  unlencode
            processData:false, //处理数据
            data:form,
            success:function(res){
                if (res.ret==1) {
                    alert(res.msg);
                    window.location.href="http://w3.shop.com/api/kao_index";
                }else{
                    alert(res.msg);
                }
            }
        })
    })
</script>