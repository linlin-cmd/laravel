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
			<td>
				<a href="{{url('crontab/getidlist/'.$v)}}">获取用户身上标签</a>
				<a href="{{url('crontab/news/'.$v)}}">单发消息</a>
			</td>
		</tr>
	@endforeach
	</table>
</body>
</html>