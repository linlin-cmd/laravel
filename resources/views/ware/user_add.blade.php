<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>用户管理</title>
</head>
<body>
	<form action="{{url('ware/user_add_do')}}" method="post">
		@csrf
		用户名:<input type="text" name="w_name"><br>
		密码:<input type="text" name="w_pwd"><br>
		<select name="user" id="">
			<option value="0">普通库管</option>
			<option value="1">库管主管</option>
		</select><br>
		<input type="submit" value="添加">
	</form>
</body>
</html>