<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>我要竞猜</title>
</head>
<body>
	<form action="{{url('team/want_guess_do')}}" method="post"  align="center">
		@csrf
		<table border="1">
			<b>我要竞猜</b><br>
			<b>{{$data->team_name}}VS{{$data->team_names}}</b>
		</table>
		<input type="hidden" name="team_id" value="{{$data->team_id}}">
		<input type="radio" name="is_show" value="2">胜
		<input type="radio" name="is_show" value="0">平
		<input type="radio" name="is_show" value="1">负<br>
		<input type="submit" value="确定">
	</form>
</body>
</html>