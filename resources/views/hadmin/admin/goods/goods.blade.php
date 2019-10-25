@extends('layouts.hadmin')
@section('title') 商品 @endsection
@section('content')
    <h3>商品添加</h3>
    <ul class="nav nav-tabs">
        <li role="presentation" class="active"><a href="javascript:;" name='basic'>基本信息</a></li>
        <li role="presentation" ><a href="javascript:;" name='attr'>商品属性</a></li>
        <li role="presentation" ><a href="javascript:;" name='detail'>商品详情</a></li>
    </ul>
    <br>
    <form action='{{url('hadmin/goods_do')}}' method="POST" enctype="multipart/form-data" id='form'>

        <div class='div_basic div_form'>
            <div class="form-group">
                <label for="exampleInputEmail1">商品名称</label>
                <input type="text" class="form-control" name='goods_name'>
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">商品分类</label>
                <select class="form-control" name='cat_id'>
                    <option value='0'>请选择</option>
                    @foreach($goods_cat as $v)
                        <option value="{{$v->cat_id}}">{{$v->cat_name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">商品货号</label>
                <input type="text" class="form-control" name='goods_sn'>
            </div>

            <div class="form-group">
                <label for="exampleInputEmail1">商品价钱</label>
                <input type="text" class="form-control" name='goods_price'>
            </div>

            <div class="form-group">
                <label for="exampleInputFile">商品图片</label>
                <input type="file" name='goods_img'>
            </div>
        </div>
        <div class='div_detail div_form' style='display:none'>
            <div class="form-group">
                <label for="exampleInputFile">商品详情</label>
                <textarea class="form-control" rows="3" name="goods_desc"></textarea>
            </div>
        </div>
        <div class='div_attr div_form' style='display:none'>
            <div class="form-group">
                <label for="exampleInputEmail1">商品类型</label>
                <select class="form-control" name='type_id' id="goods_type">
                    <option>请选择</option>
                    @foreach($goods_type as $v)
                        <option value="{{$v->type_id}}">{{$v->type_name}}</option>
                    @endforeach
                </select>
            </div>
            <br>

            <table width="100%" id="attrTable" class='table table-bordered'>
                <tr>
                    <td>前置摄像头</td>
                    <td>
                        <input type="hidden" name="attr_id_list[]" value="211">
                        <input name="attr_value_list[]" type="text" value="" size="20">
                        <input type="hidden" name="attr_price_list[]" value="0">
                    </td>
                </tr>
                <tr>
                    <td><a href="javascript:void(0);"  class="plus">[+]</a>颜色</td>
                    <td>
                        <input type="hidden" name="attr_id_list[]" value="214">
                        <input name="attr_value_list[]" type="text" value="" size="20">
                        属性价格 <input type="text" name="attr_price_list[]" value="" size="5" maxlength="10">
                    </td>
                </tr>
            </table>
            <!-- <div class="form-group">
                    颜色:
                    <input type="text" name='attr_value_list[]'>
            </div> -->
            <!-- <div class="form-group" style='padding-left:26px'>
                <a href="javascript:;">[+]</a>内存:
                <input type="text" name='attr_value_list[]'>
                属性价格:<input type="text" name='attr_price_list[][]'>
            </div> -->

        </div>

        <input type="submit" class="btn btn-default" id='btn' value="添加">
    </form>
    <script type="text/javascript">
        //标签页 页面渲染
        $(".nav-tabs a").on("click",function(){
            $(this).parent().siblings('li').removeClass('active');
            $(this).parent().addClass('active');
            var name = $(this).attr('name');  // attr basic
            $(".div_form").hide();
            $(".div_"+name).show();  // $(".div_"+name)
        })
        $('#goods_type').on('change',function(){
            var type_id =$(this).val();
            $.ajax({
                url:"{{url('hadmin/goods_change')}}",
                dataType:"json",
                data:{type_id:type_id},
                success:function(res){
                    console.log(res);
                    $('#attrTable').empty();
                    $.each(res,function(i,v){
                        if(v.is_attribute ==1)
                        {
                            var tr =$('<tr><td>'+v.attribute_name+'</td><td><input type="hidden" name="attribute_id" value="'+v.attribute_id+'"><input name="attribute_value[]" type="text"size="20"><input type="hidden" name="attribute_price[]" value="0"></td></tr>');
                        }else{
                            var tr =$('<tr><td><a href="javascript:void(0);" class="plus">[+]</a>'+v.attribute_name+'</td><td><input type="hidden" name="attribute_id" value="'+v.attribute_id+'"><input name="attribute_value[]" type="text" value="" size="20">属性价格 <input type="text" name="attribute_price[]" value="0" size="5" maxlength="10"></td></tr>');
                        }
                        $('#attrTable').append(tr);
                    })
                }
            })
        })
        //加减号处理
        $(document).on('click','.plus',function(){

            if($(this).html()=="[+]"){
                $(this).html('[-]');
                $(this).parent().parent().after($(this).parent().parent().clone());
                $(this).html('[+]');
            }else{
                $(this).parent().parent().remove();
            }
        })

    </script>
@endsection
