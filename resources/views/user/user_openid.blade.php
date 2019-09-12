<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>用户打标签</title>
</head>
<body>
	<form action="{{url('user_openid_do/'.$id)}}" method="post">
		@csrf
		<input type="submit" value="提交">
	<table border="1">
		<tr>
			<td></td>
			<td>用户名称</td>
			<td>openid</td>
			<td>操作</td>
		</tr>
	@foreach($openid as $v)
		<tr>
			<td><input type="checkbox" name="openid[]" value="{{$v}}"></td>
			<td></td>
			<td>{{$v}}</td>
			<td>
				<a href="{{url('user_label/'.$v)}}">用户下的标签</a>
			</td>
		</tr>
	@endforeach
	</table>
	</form>
</body>
</html>