<html>
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>
    <input type="file" name="file">
    <input type="submit" value='提交' id="btn">   
</body>
</html>
<script src="https://cdn.jsdelivr.net/npm/jquery@1.12.4/dist/jquery.min.js"></script>
<script type="text/javascript">
    $('#btn').on('click',function(){
        var form =new FormData();
        form.append('name','林林');
        form.append('age','18');
        //获取文件数据
        var file =$('[name="file"]')[0].files[0];
        form.append('file',file);
        console.log(form);
        $.ajax({
            url:"http://w3.shop.com/api/upp",
            type:"POST",
            data:form,
            contentType:false, //post数据类型  unlencode
            processData:false, //处理数据
            dataType:"json",
            success:function(res){

            }
        })
    })
</script>