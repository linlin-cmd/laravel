<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>球队</title>
</head>
<body>
	<form action="{{url('team/add_do')}}" align="center" method="post">
		@csrf
		<b>添加竞猜球队</b><br>
		<input type="text" name="team_name"><b>VS</b>
		<input type="text" name="team_names"><br>
		<b>结束竞猜时间:</b><input type="text" name="add_time">
		<input type="submit" value="添加" class="sub">
	</form>
</body>
</html>
<script src="/laravel/jq.js"></script>
<script type="text/javascript">
	$('.sub').on('click',function(){
		var name =$('[name="team_name"]').val();
		var names =$('[name="team_names"]').val();
		if (name == names) {
			alert('两支球队名称不能相同');
			return false;
		};
	})
</script>