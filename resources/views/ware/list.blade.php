<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<body>
	@if(session('ware')->user=="1")
		<table border="1">
			<tr>
				<td>用户id</td>
				<td>货物id</td>
				<td>操作时间</td>
				<td>操作类型</td>
			</tr>
		@foreach($data as $v)
			<tr>
				<td>{{$v->w_id}}</td>
				<td>{{$v->goods_id}}</td>
				<td>{{date('Y-m-d H:i:s',$v->add_time)}}</td>
				<td>
					@if($v->type=="0")
						入库
					@else
						出库
					@endif
				</td>
			</tr>
		@endforeach
		</table>
	@else
		<table border="1">
			<tr>
				<td>用户id</td>
				<td>货物id</td>
				<td>操作时间</td>
				<td>操作类型</td>
			</tr>
		@foreach($info as $v)
			<tr>
				<td>{{$v->w_id}}</td>
				<td>{{$v->goods_id}}</td>
				<td>{{date('Y-m-d H:i:s',$v->add_time)}}</td>
				<td>
					@if($v->type=="0")
						入库
					@else
						出库
					@endif
				</td>
			</tr>
		@endforeach
		</table>
	@endif
</body>
</html>