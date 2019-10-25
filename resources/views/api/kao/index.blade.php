<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <title> - 展示</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="gray-bg">
<div class="container">
    <form class="form-inline">
        <div class="form-group">
            <label class="sr-only" for="exampleInputAmount">Amount (in dollars)</label>
            <div class="input-group">
                <input type="text" class="form-control" placeholder="天气" name="city">
            </div>
        </div>
        <button type="button" class="btn btn-primary" id="city">查询天气</button>
    </form>
    <table class="table table-striped">
        <tbody id="list">
        <tr>
            <td>id</td>
            <td>商品名称</td>
            <td>商品价钱</td>
            <td>商品图片</td>
            <td>操作</td>
        </tr>
        </tbody>
    </table>
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
</div>
<!-- 全局js -->
<script src="{{asset('hadmin/js/jquery.min.js?v=2.1.4')}}"></script>
<script src="{{asset('hadmin/js/bootstrap.min.js?v=3.3.6')}}"></script>




</body>

</html>
<script>
    var url ="http://w3.shop.com/api/kao_goods";
    $.ajax({
        url,url,
        dataType:"json",
        success:function(res){
            $('.search').empty();
            $.each(res.data.data,function(i,v){
                var tr =$("<tr class='search'></tr>");
                tr.append("<td>"+v.goods_id+"</td>");
                tr.append("<td>"+v.goods_name+"</td>");
                tr.append("<td>"+v.goods_money+"</td>");
                tr.append("<td><img src='http://w3.shop.com/"+v.goods_img+"' width='50' height='50'></td>");
                $('#list').append(tr);
            })
            //计算分页页码
            $('.pagination').empty();
            var last_page =res.data.last_page;
            for (i=1; i <=last_page ; i++) {
                var page ='<li><a href="javascript:void(0)" class="page">'+i+'</a></li>';
                $('.pagination').append(page);
            }
        }
    })
    //分页
    $(document).on('click','.page',function(){
        var page =$(this).text();
        $.ajax({
            url:url,
            dataType:"json",
            data:{page:page},
            success:function(res){
                $('.search').empty();
                $.each(res.data.data,function(i,v){
                    var tr =$("<tr class='search'></tr>");
                    tr.append("<td>"+v.goods_id+"</td>");
                    tr.append("<td>"+v.goods_name+"</td>");
                    tr.append("<td>"+v.goods_money+"</td>");
                    tr.append("<td><img src='"+v.goods_img+"'></td>");
                    $('#list').append(tr);
                })
            }
        })
    })
    $('#city').on('click',function(){
        var city =$('[name="city"]').val();
        $.ajax({
            url:url,
            dataType:"json",
            data:{city:city},
            success:function(res){
                $('.search').empty();
                var tr =$('<tr class="search"></tr>');
                tr.append('<td>'+res.data.result.area_1+'</td>');
                tr.append('<td>'+res.data.result.area_2+'</td>');
                tr.append('<td>'+res.data.result.realTime.wtNm+'</td>');
                tr.append('<td>'+res.data.result.realTime.wtTemp+'</td>');
                $('#list').append(tr);
            }
        })
    })
</script>
