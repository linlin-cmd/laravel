<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>素材管理</title>
</head>
<body>
	<h1>素材管理</h1>
	<a href="{{url('upload')}}">上传永久素材</a>
	<table border="1">
		<tr>
			<td>media_id</td>
			<td>path</td>
			<td>时间</td>
			<td>类型</td>
			<td>操作</td>
		</tr>
	@foreach($info as $v)
		<tr>
			<td>{{$v->media_id}}</td>
			<td><img src="{{$v->path}}" alt="" height="30" width="30"></td>
			<td>{{date('Y-m-d H:i:s',$v->add_time)}}</td>
			<td>@if($v->type=="1")image @elseif($v->type=="2")voice @elseif($v->type=="3") video @elseif($v->type=="4")thumb @endif</td>
			<td>
				<a href="">删除素材</a>
				<a href="{{url('material/'.$v->id)}}">下载素材</a>
			</td>
		</tr>
	@endforeach
	</table>
	<button class="upper" data="{{$upper}}">上一页</button>
	<button class="next" data="{{$next}}">下一页</button>
</body>
</html>
<script src="/laravel/jq.js"></script>
<script type="text/javascript">
	$('.upper').on('click',function(){
		//获取页码
		var page =$(this).attr('data');
		window.location.href="{{url('source')}}?page="+page+"&type={{$type}}";
	})
	$('.next').on('click',function(){
		//获取页码
		var page =$(this).attr('data');
		window.location.href="{{url('source')}}?page="+page+"&type={{$type}}";
	})
</script>