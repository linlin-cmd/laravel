<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>竞猜结果</title>
</head>
<body>
@if($count)
	<table>
		<b>比赛结果</b><br>
		<b>{{$team->team_name}}VS{{$team->team_names}}</b><br>
		<input type="radio" name="is_show" value="2" @if($data->is_show=="2") checked="checked" @endif >胜
		<input type="radio" name="is_show" value="0" @if($data->is_show=="0") checked="checked" @endif>平
		<input type="radio" name="is_show" value="1" @if($data->is_show=="1") checked="checked" @endif>负
	</table>
	<br>
	<div align="center">
		<b>竞猜结果</b><br>
		<b>对阵结果:
			{{$team->team_name}}
			@if($data->is_show=="2") 胜 @endif
			@if($data->is_show=="0") 平 @endif
			@if($data->is_show=="1") 负 @endif
			{{$team->team_names}}
		</b><br>
		<b>您的竞猜:
			{{$team->team_name}}
			@if($data->status=="2") 胜 @endif
			@if($data->status=="0") 平 @endif
			@if($data->status=="1") 负 @endif
			{{$team->team_names}}
		</b><br>
		<b>结果:
			@if($data->status==$data->is_show)
			恭喜猜对了
			@else
			很遗憾,没猜对
			@endif
		</b>
	</div>
@else
	<b>没有竞猜</b>
@endif
</body>
</html>