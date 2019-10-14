<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <title> - 展示</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="gray-bg">
    <center>
        <form class="form-inline">
              <div class="form-group">
                <label class="sr-only" for="exampleInputEmail3">Email address</label>
                <input type="text" class="form-control" id="exampleInputEmail3" placeholder="名称" name="name">
              </div>
              <button type="button" class="btn btn-default" id="sign">搜索</button>
        </form>
        <table class="table">
            <tbody id="list">
                    <tr>
                        <td>id</td>
                        <td>名称</td>
                        <td>年龄</td>
                        <td>操作</td>
                    </tr>  
            </tbody>
        </table>
    </center>
    <nav aria-label="Page navigation">
      <ul class="pagination">
        <!-- <li>
          <a href="#" aria-label="Previous">
            <span aria-hidden="true">&laquo;</span>
          </a>
        </li>
        <li>
          <a href="#" aria-label="Next">
            <span aria-hidden="true">&raquo;</span>
          </a>
        </li> -->
      </ul>
    </nav>
    <!-- 全局js -->
    <script src="{{asset('hadmin/js/jquery.min.js?v=2.1.4')}}"></script>
    <script src="{{asset('hadmin/js/bootstrap.min.js?v=3.3.6')}}"></script>

    
    

</body>

</html>
<script>
    // 列表展示
    var url ="http://w3.shop.com/api/test";
    $.ajax({
        url:url,
        dataType:"json",
        type:"GET",
        success:function(res){
            search_page(res);
        }
        
    })
    //ajax分页
    $(document).on('click','.page',function(){
        //获取当前页码
        var page =$(this).text();
        var name =$('[name="name"]').val();
        $.ajax({
            url:url,
            dataType:"json",
            data:{name:name,page:page},
            success:function(res){
                search_page(res);
            }
        })
    })
    // ajax删除
    $(document).on('click','.del',function(){
        var id =$(this).attr('id');
        var url="http://w3.shop.com/api/test";
        var _this=$(this);
        $.ajax({
            url:url+"/"+id,
            dataType:"json",
            type:"POST",
            data:{id:id,"_method":"DELETE"},
            success:function(res){
                if (res.ret==1) {
                    alert(res.msg);
                    _this.parent().parent().remove();
                }
            }
        })
    })
    //ajax搜索
    $(document).on('click','#sign',function(){
        var name =$('[name="name"]').val();
        $.ajax({
            url:url,
            dataType:"json",
            data:{name:name},
            success:function(res){
                search_page(res);
            }
        })
    })
    function search_page(res){
        $('.search').empty();
        $('.pagination').empty();
        $.each(res.data.data,function(i,v){
            var tr=$("<tr class='search'></tr>");
            tr.append("<td>"+v.id+"</td>");
            tr.append("<td>"+v.name+"</td>");
            tr.append("<td>"+v.age+"</td>");
            tr.append("<td><button class='del btn btn-default' id='"+v.id+"'>删除</button></td>");
            tr.append("<td><a href='http://w3.shop.com/api/upd?id="+v.id+"' class='btn btn-default'>修改</a></td>");
            $('#list').append(tr);
        })
        //最大页码
        var last_page =res.data.last_page;
        for (i=1; i <=last_page ; i++) { 
            var page ='<li><a href="javascript:void(0)" class="page">'+i+'</a></li>';
            $('.pagination').append(page);
        }
    }
</script> 