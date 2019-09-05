<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>kkk</title>
</head>
<body>
	<form action="{{url('kkk/update_do/'.$data->id)}}" method="post">
		@csrf
		<table>
			<tr>
				<td>姓名:</td>
				<td><input type="text" name="name" value="{{$data->name}}"></td>
			</tr>
			<tr>
				<td>年龄</td>
				<td>
					<select name="age" id="">
						<option value="1" @if ($data->age=="1")selected="selected" @endif>18</option>
						<option value="2" @if ($data->age=="2")selected="selected" @endif>19</option>
						<option value="3" @if ($data->age=="3")selected="selected" @endif>20</option>
						<option value="4" @if ($data->age=="4")selected="selected" @endif>21</option>
						<option value="5" @if ($data->age=="5")selected="selected" @endif>22</option>
						<option value="6" @if ($data->age=="6")selected="selected" @endif>23</option>
						<option value="7" @if ($data->age=="7")selected="selected" @endif>24</option>
						<option value="8" @if ($data->age=="8")selected="selected" @endif>25</option>
						<option value="9" @if ($data->age=="9")selected="selected" @endif>26</option>
						<option value="10" @if ($data->age=="10")selected="selected" @endif>27</option>
						<option value="11" @if ($data->age=="11")selected="selected" @endif>28</option>
					</select>
				</td>
			</tr>
			<tr>
				<td>地址</td>
				<td>
					<select name="address" id="">
						<option value="1" @if ($data->address=="1")selected="selected" @endif>北京市</option>
						<option value="2" @if ($data->address=="2")selected="selected" @endif>昌平区</option>
						<option value="3" @if ($data->address=="3")selected="selected" @endif>房山区</option>
					</select>
				</td>
			</tr>
			<tr>
				<td>状态</td>
				<td>
					<input type="radio" name="status" value="0" @if ($data->status=="0")checked="checked" @endif>离校
					<input type="radio" name="status" value="1" @if ($data->status=="1")checked="checked" @endif>在校
				</td>
			</tr>
			<tr>
				<td></td>
				<td>
					<input type="submit" value="修改">
				</td>
			</tr>
		</table>
	</form>
</body>
</html>