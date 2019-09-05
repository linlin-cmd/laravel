<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>新闻</title>
</head>
<body>
	<form action="{{url('news/add_do')}}" method="post">
		@csrf
		<table>
			<tr>
				<td>标题</td>
				<td><input type="text" name="news_head"></td>
			</tr>
			<tr>
				<td>作者</td>
				<td><input type="text" name="news_man"></td>
			</tr>
			<tr>
				<td>内容</td>
				<td>
					<textarea name="news_cont" id="" cols="15" rows="5"></textarea>
				</td>
			</tr>
			<tr>
				<td></td>
				<td><input type="submit" value="submit"></td>
			</tr>
		</table>
	</form>
</body>
</html>