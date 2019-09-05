<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>登录</title>
</head>
<body>
	<form action="{{url('ware/login_do')}}" method="post">
	@csrf
		用户名:<input type="text" name="w_name"><br>
		密码:<input type="text" name="w_pwd"><br>
		<input type="submit" value="登录">
	</form>
</body>
</html>