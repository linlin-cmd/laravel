<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>粉丝列表</title>
</head>
<body>
	<table border="1">
		<tr>
			<td>名称</td>
			<td>openid</td>
			<td>操作</td>
		</tr>
	@foreach($res as $v)
		<tr>
			<td>{{$name}}</td>
			<td>{{$v}}</td>
			<td>
				<a href="">查看</a>
			</td>
		</tr>
	@endforeach
	</table>
</body>
</html>