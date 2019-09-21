<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>用户展示</title>
</head>
<body>
	<table border="1">
		<tr>
			<td>用户名</td>
			<td>openid</td>
			<td>操作</td>
		</tr>
	@foreach($res as $v)
		<tr>
			<td></td>
			<td>{{$v}}</td>
			<td></td>
		</tr>
	@endforeach
	</table>
</body>
</html>