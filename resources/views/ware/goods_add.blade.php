<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>货物添加</title>
</head>
<body>
	<form action="{{url('ware/goods_add_do')}}" method="post" enctype="multipart/form-data">
	@csrf
		货物名称: <input type="text" name="goods_name"><br>
		货物图片: <input type="file" name="goods_img"><br>
		货物数量: <input type="text" name="goods_number"><br>
		<input type="submit" value="添加">
	</form>
</body>
</html>