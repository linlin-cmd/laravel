<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>用户标签</title>
</head>
<body>
	<form action="{{url('user_do')}}" method="post">
		@csrf
		<p><input type="text" name="name"></p>
		<p><input type="submit" value="提交"></p>
	</form>
</body>
</html>