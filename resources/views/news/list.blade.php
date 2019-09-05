<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>新闻展示</title>
</head>
<body>
	<table border="1">
		<tr>
			<td></td>
			<td>列表页</td>
		</tr>
	@foreach($data as $v)
		<tr>
			<td>
				<a href="{{url('news/list_do/'.$v->news_id)}}">{{$v->news_head}}</a>
			</td>
			<td>{{$v->name}}</td>
			<td>
				<button class="give" data-id="{{$v->news_id}}">点赞</button>
				<button class="cancel" data-id="{{$v->news_id}}">取消赞</button>
			</td>
		</tr>
	@endforeach
	</table>
</body>
</html>
<script src="/laravel/jq.js"></script>
<script type="text/javascript">
	//点赞
	$('.give').on('click',function(){
		var news_id =$(this).data('id');
		$.ajax({
			url:"{{url('news/give')}}",
			dataType:"json",
			data:{news_id:news_id},
			success:function(res){

			}
		})
	})
	$('.cancel').on('click',function(){
		var news_id =$(this).data('id');
		$.ajax({
			url:"{{url('news/cancel')}}",
			dataType:"json",
			data:{news_id:news_id},
			success:function(res){
			}
		})
	})
</script>