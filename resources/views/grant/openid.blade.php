<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>粉丝列表</title>
</head>
<body>
	<table bodrder="1">
		<tr>
			<td>用户</td>
			<td>openid</td>
			<td>操作</td>
		</tr>
	@foreach($openid as $v)
		<tr>
			<td></td>
			<td>{{$v}}</td>
			<td>
				<a href="{{url('grant/massage/'.$v)}}">留言</a>
			</td>
		</tr>
	@endforeach
	</table>
</body>
</html>