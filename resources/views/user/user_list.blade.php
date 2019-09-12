<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>用户标签展示</title>
</head>
<body>
	<table border="1">
		<tr>
			<td>id</td>
			<td>name</td>
			<td>粉丝数量</td>
			<td>操作</td>
		</tr>
	@foreach($res as $v)
		<tr>
			<td>{{$v['id']}}</td>
			<td>{{$v['name']}}</td>
			<td>{{$v['count']}}</td>
			<td>
				<a href="{{url('delete/'.$v['id'])}}">删除</a>
				<a href="{{url('update/'.$v['id'].'/'.$v['name'])}}">修改</a>
				<a href="{{url('user_openid/'.$v['id'])}}">粉丝打标签</a>
				<a href="{{url('Fans/'.$v['id'].'/'.$v['name'])}}">粉丝列表</a>
				<a href="{{url('push/'.$v['id'])}}">推送消息</a>
			</td>
		</tr>
	@endforeach
	</table>
</body>
</html>