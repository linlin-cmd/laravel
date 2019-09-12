<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>上传素材</title>
</head>
<body>
	<form action="{{url('do_upload')}}" method="post" enctype="multipart/form-data">
		@csrf
		<p><input type="file" name="image" value=""></p>
		<select name="type" id="">
			<option value="1">image</option>
			<option value="2">voice</option>
			<option value="3">video</option>
			<option value="4">thumb</option>
		</select>
		<p><button>提交</button></p>
	</form>
</body>
</html>