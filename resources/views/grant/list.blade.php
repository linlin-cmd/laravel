<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<body>
	<table border="1">
		<tr>
			<td>id</td>
			<td>名称</td>
			<td>二维码</td>
			<td>操作</td>
		</tr>
	@foreach ($res as $v)
		<tr>
			<td>{{$v->id}}</td>
			<td>{{$v->name}}</td>
			<td><img src="{{$v->url}}" width="100" height="100"></td>
			<td>
				<a href="{{url('grant/qrcode/'.$v->id)}}">生成二维码</a>
			</td>
		</tr>
	@endforeach
	</table>
</body>
</html>