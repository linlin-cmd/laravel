<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>货物添加</title>
</head>
<body>
	<form action="{{url('ware/goods_upd_do/'.$data->goods_id)}}" method="post">
	@csrf
		货物名称: <input type="text" name="goods_name" value="{{$data->goods_name}}"><br>
		货物数量: <input type="text" name="goods_number" value="{{$data->goods_number}}"><br>
		<input type="submit" value="出库">
	</form>
</body>
</html>