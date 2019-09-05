<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>kkk</title>
</head>
<body>
	<form action="{{url('kkk/add_do')}}" method="post">
		@csrf
		<table>
			<tr>
				<td>姓名:</td>
				<td><input type="text" name="name"></td>
			</tr>
			<tr>
				<td>年龄</td>
				<td>
					<select name="age" id="">
						<option value="1">18</option>
						<option value="2">19</option>
						<option value="3">20</option>
						<option value="4">21</option>
						<option value="5">22</option>
						<option value="6">23</option>
						<option value="7">24</option>
						<option value="8">25</option>
						<option value="9">26</option>
						<option value="10">27</option>
						<option value="11">28</option>
					</select>
				</td>
			</tr>
			<tr>
				<td>地址</td>
				<td>
					<select name="address" id="">
						<option value="1">北京市</option>
						<option value="2">昌平区</option>
						<option value="3">房山区</option>
					</select>
				</td>
			</tr>
			<tr>
				<td>状态</td>
				<td>
					<input type="radio" name="status" value="0">离校
					<input type="radio" name="status" value="1">在校
				</td>
			</tr>
			<tr>
				<td></td>
				<td>
					<input type="submit" value="添加">
				</td>
			</tr>
		</table>
	</form>
</body>
</html>