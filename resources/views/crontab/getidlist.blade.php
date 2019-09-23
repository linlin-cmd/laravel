<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>用户身上的标签列表</title>
</head>
<body>
	<table border="1">
		<tr>
			<td>标签</td>
			<td>操作</td>
		</tr>
	@foreach($res as $v)
		<tr>
			<td>{{$v}}</td>
			<td></td>
		</tr>
	@endforeach
	</table>
</body>
</html>