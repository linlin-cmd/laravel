<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>货物</title>
</head>
<body>
	<button><a href="{{url('ware/goods_add')}}">入库</a></button>
	<table border="1">
		<tr>
			<td>货物名称</td>
			<td>货物图片</td>
			<td>货物数量</td>
			<td>时间</td>
			<td>出库</td>
		</tr>
	@foreach($data as $v)
		<tr>
			<td>{{$v->goods_name}}</td>
			<td><img src="{{env('UPLOAD_URL')}}{{$v->goods_img}}" width="20" height="20" alt=""></td>
			<td>{{$v->goods_number}}</td>
			<td>{{date('Y-m-d H:i:s',$v->add_time)}}</td>
			<td>
				<a href="">删除</a>
				<a href="{{url('ware/goods_upd/'.$v->goods_id)}}">出库</a>
			</td>
		</tr>
	@endforeach
	</table>
</body>
</html>