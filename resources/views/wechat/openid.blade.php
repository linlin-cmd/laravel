<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<body>
	<table border="1">
		<tr>
			<td>用户名称</td>
			<td>用户id</td>
			<td>操作</td>
		</tr>
	@foreach($info as $v)
		<tr>
			<td>{{$v['nickname']}}</td>
			<td>{{$v['openid']}}</td>
			<td></td>
		</tr>
	@endforeach
	</table>
</body>
</html>