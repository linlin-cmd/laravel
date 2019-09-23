<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>用户标签展示</title>
</head>
<body>
	<table border="1">
		<tr>
			<td>tag_id</td>
			<td>标签名称</td>
			<td>操作</td>
		</tr>
	@foreach($res as $v)
		<tr>
			<td>{{$v['id']}}</td>
			<td>{{$v['name']}}</td>
			<td></td>
		</tr>
	@endforeach
	</table>
</body>
</html>