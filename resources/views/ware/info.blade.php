<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>管理</title>
</head>
<body>
	@if(session('ware')->user=="1")
	<button><a href="{{url('ware/user_list')}}">用户管理</a></button>
	<button><a href="{{url('ware/goods_list')}}">货物管理</a></button>
	<button><a href="{{url('ware/list')}}">出入口记录管理</a></button>
	@else
	<button><a href="{{url('ware/goods_list')}}">货物管理</a></button>
	<button><a href="{{url('ware/list')}}">出入口记录管理</a></button>
	@endif
</body>
</html>