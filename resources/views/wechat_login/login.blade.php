<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<body>
	<center>
		用户名<input type="text"><br>
		密码<input type="text"><br>
		<input type="button" value="登录" id="login">
	</center>
</body>
</html>
<script src="/laravel/jq.js"></script>
<script type="text/javascript">
	$('#login').on('click',function(){
		window.location.href="{{url('wechat/login_do')}}"
	})
</script>