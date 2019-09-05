<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>用户管理</title>
</head>
<body>
	<form action="{{url('ware/user_upd_do/'.$data->w_id)}}" method="post">
		@csrf
		用户名:<input type="text" name="w_name" value="{{$data->w_name}}"><br>
		密码:<input type="password" name="w_pwd" value="{{$data->w_pwd}}"><br>
		<select name="user" id="">
			<option value="0" @if($data->user=="0") selected="selected" @endif>普通库管</option>
			<option value="1" @if($data->user=="1") selected="selected" @endif>库管主管</option>
		</select><br>
		<input type="submit" value="修改">
	</form>
</body>
</html>