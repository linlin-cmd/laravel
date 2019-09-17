<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>网页授权</title>
</head>
<body>
	<form action="{{url('grant/login_do')}}" method="post">
		@csrf
		用户名:<input type="text" name="web_name"><br>
		密码:<input type="text" name="web_pwd"><br>
		<input type="submit">
		<input type="button" class="grant" value="微信登录">
	</form>
</body>
</html>
<script src="/laravel/jq.js"></script>
<script type="text/javascript">
	$('.grant').on('click',function(){
		window.location.href="{{url('grant/grant')}}";
	})
</script>