<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8"><link rel="icon" href="https://jscdn.com.cn/highcharts/images/favicon.ico">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        /* css 代码  */
    </style>
    <script src="https://code.highcharts.com.cn/highcharts/highcharts.js"></script>
    <script src="https://code.highcharts.com.cn/highcharts/highcharts-more.js"></script>
    <script src="https://code.highcharts.com.cn/highcharts/modules/exporting.js"></script>
    <script src="https://img.hcharts.cn/highcharts-plugins/highcharts-zh_CN.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- 全局js -->
    <script src="{{asset('hadmin/js/jquery.min.js?v=2.1.4')}}"></script>
    <script src="{{asset('hadmin/js/bootstrap.min.js?v=3.3.6')}}"></script>
</head>
<body class="gray-bg">
    <center>
        <form class="form-inline">
            <div class="form-group">
                <label class="sr-only" for="exampleInputAmount">Amount (in dollars)</label>
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="天气" name="city">
                </div>
            </div>
            <button type="button" class="btn btn-primary" id="city">查询天气</button>
        </form>
    </center>
<div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
<script>
    // JS 代码
    $.ajax({
        url:"{{url('api/weather')}}",
        dataType:"json",
        data:{city:"北京"},
        success:function(res){
            weather(res.result);
        }
    })




    $('#city').on('click',function(){
        var city =$('[name="city"]').val();
        $.ajax({
            url:"{{url('api/weather')}}",
            dataType:"json",
            data:{city:city},
            success:function(res){
                console.log(res);
                //调用方法
                weather(res.result);
            }
        })
    })

    function weather(weatherData){
        console.log(weatherData);
        var categories =[];
        var data = []; //x轴日期对应的最高最低气温
        //循环
        $.each(weatherData.futureDay,function(i,v){
            //尾部追加周期
            categories.push(v.week);
            //定义arr数组中添加温度
            var arr = [parseInt(v.wtTemp1),parseInt(v.wtTemp2)];
            //追加温度
            data.push(arr);
        })
        console.log(data);
        // console.log(categories);return;
        var chart = Highcharts.chart('container', {
            chart: {
                type: 'columnrange', // columnrange 依赖 highcharts-more.js
                inverted: true
            },
            title: {
                text: '一周天气气温'
            },
            subtitle: {
                text: ''+weatherData.area_1+weatherData.area_2+''
            },
            xAxis: {
                categories:categories
            },
            yAxis: {
                title: {
                    text: '温度 ( °C )'
                }
            },
            tooltip: {
                valueSuffix: '°C'
            },
            plotOptions: {
                columnrange: {
                    dataLabels: {
                        enabled: true,
                        formatter: function () {
                            return this.y + '°C';
                        }
                    }
                }
            },
            legend: {
                enabled: false
            },
            series: [{
                name: '温度',
                data: data
            }]
        });
    }
</script>
</body>
</html>
