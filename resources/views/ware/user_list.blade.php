<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>用户展示</title>
</head>
<body>
	<a href="{{url('ware/user_add')}}">添加用户</a>
	<table border="1">
		<tr>
			<td>用户</td>
			<td>身份</td>
			<td>操作</td>
		</tr>
	@foreach($data as $v)
		<tr>
			<td>{{$v->w_name}}</td>
			<td>
				@if($v->user=="1")
					库管主管
				@else
					普通库管
				@endif
			</td>
			<td>
				<a href="{{url('ware/user_upd/'.$v->w_id)}}">修改</a>
			</td>
		</tr>
	@endforeach
	</table>
</body>
</html>