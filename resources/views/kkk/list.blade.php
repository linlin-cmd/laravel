<form action="">
	<input type="hidden" name="status">
	<input type="button" value="状态" class="but">
</form>
<table border="1">
	<tr>
		<td>id</td>
		<td>名称</td>
		<td>年龄</td>
		<td>地址</td>
		<td>编辑</td>
	</tr>
@foreach ($data as $v)
	<tr>
		<td>{{$v->id}}</td>
		<td>{{$v->name}}</td>
		<td>
			@if($v->age =="1")
			18
			@else
			19
			@endif
		</td>
		<td>
			@if($v->address =="1")
			北京
			@else
			昌平区
			@endif
		</td>
		<td>
			<a href="{{url('kkk/del/'.$v->id)}}">删除</a>
			<a href="{{url('kkk/update/'.$v->id)}}">修改</a>
		</td>
	</tr>
@endforeach
</table>
<script src="/laravel/jq.js"></script>
<script type="text/javascript">
	$('.but').on('click',function(){
		var status =$('[name="status"]').val();
		if (status =="") {
			$('form').empty().html('<input type="hidden" name="status" value="1"><input type="button" value="状态" class="but">');
		}
		$('form').empty().html('<input type="hidden" name="status" value=""><input type="button" value="状态" class="but">');
		$('form').submit();
	})
</script>