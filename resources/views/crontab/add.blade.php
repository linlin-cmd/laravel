<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>用户标签</title>
</head>
<body>
	<form action="{{url('crontab/add_do')}}" method="post">
	@csrf
		<input type="text" name="name">
		<input type="submit">
	</form>
</body>
</html>