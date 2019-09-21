<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>菜单管理</title>
</head>
<body>
	<center>
		<h1>菜单管理</h1>
		<form action="{{url('grant/menu_do')}}" method="post">
			@csrf
			一级菜单<input type="text" name="name"><br>
			二级菜单<input type="text" name="name2"><br>
			菜单类型
				<select name="type" id="">
					<option value="1">click</option>			
					<option value="2">view</option>			
				</select><br>
			事件值<input type="text" name="key_url"><br>
			<input type="submit" value="提交">
		</form>
	</center>
</body>
</html>
<center>
	<table border="1">
		<tr>
			<td>一级菜单</td>
			<td>二级菜单</td>
			<td>操作</td>
		</tr>
	@foreach($info as $v)
		<tr>
			<td>{{$v->name}}</td>
			<td>{{$v->name2}}</td>
			<td>
				<a href="{{url('grant/menu_del/'.$v->id)}}">删除</a>
			</td>
		</tr>
	@endforeach
	</table>
</center>