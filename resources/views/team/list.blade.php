<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>竞猜列表</title>
</head>
<body>
	<table border="1" align="center">
		<tr>
			<td colspan="2" align="center"><b>竞猜列表</b></td>
		</tr>
	@foreach ($data as $v)
		<tr>
			<td>
				{{$v['team_name']}} 
				<b>VS</b> 
				{{$v['team_names']}}
			</td>
			<td>
				<a href="javascript:void(0)" data-id="{{$v['team_id']}}" class="team">{{$v['result']}}</a>
			</td>
		</tr>
	@endforeach
	</table>
</body>
</html>
<script src="/laravel/jq.js"></script>
<script type="text/javascript">
	$('.team').on('click',function(){
		//内容
		var team =$(this).html();
		//id
		var team_id =$(this).data('id');
		if (team=="竞猜") {
			location.href="{{url('team/want_guess')}}"+"/"+team_id;
		}else{
			location.href="{{url('team/guess')}}"+"/"+team_id;
		}
	})
</script>