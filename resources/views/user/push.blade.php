<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>消息列表</title>
</head>
<body>
	<form action="{{url('push_do/'.$id)}}" method="post">
	@csrf
		<textarea name="content" id="" cols="30" rows="10"></textarea>
		<input type="submit" value="提交">
	</form>
</body>
</html>