<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>修改</title>
</head>
<body>
	<form action="{{url('update_do/'.$id)}}" method="post">
	@csrf
		<input type="text" name="name" value="{{$name}}">
		<input type="submit" value="提交">
	</form>
</body>
</html>