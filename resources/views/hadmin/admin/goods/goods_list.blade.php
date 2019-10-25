@extends('layouts.shop')
@section('title') 货物入库 @endsection
@section('content')
    <h3>货品添加</h3>
    <form action="{{url('hadmin/goods_stock')}}" method="post">
    <table width="100%" id="table_list" class='table table-bordered'>
        <tbody>
        @foreach($goods as $v)
            <tr>
                <th colspan="20" scope="col">商品名称：{{$v['goods_name']}} &nbsp;货号：{{$v['goods_sn']}}
                    <input type="hidden" name="goods_id" value="{{$v['goods_id']}}">
                </th>
            </tr>
        @endforeach
        <tr>
            <!-- start for specifications -->
            @foreach($arr as $k=>$v)
                <td scope="col"><div align="center"><strong>{{$k}}</strong></div></td>
            @endforeach
{{--            <td scope="col"><div align="center"><strong>颜色</strong></div></td>--}}
            <!-- end for specifications -->
            <td class="label_2">库存</td>
            <td class="label_2">&nbsp;</td>
        </tr>

        <tr id="attr_row">
            <!-- start for specifications_value -->
            @foreach($arr as $k=>$v)
                <td align="center" style="background-color: rgb(255, 255, 255);">
                    <select name="goods_attribute_id[]">
                        <option value="" selected="">请选择...</option>
                        @foreach($v as $kk=>$vv)
                            <option value="{{$vv['goods_attribute_id']}}">{{$vv['attribute_value']}}</option>
                        @endforeach
                    </select>
                </td>
            @endforeach
{{--            <td align="center" style="background-color: rgb(255, 255, 255);">--}}
{{--                <select name="attr[214][]">--}}
{{--                    <option value="" selected="">请选择...</option>--}}
{{--                    <option value="土豪金">土豪金</option>--}}
{{--                    <option value="太空灰">太空灰</option>--}}
{{--                </select>--}}
{{--            </td>--}}
            <!-- end for specifications_value -->
            <td class="label_2" style="background-color: rgb(255, 255, 255);"><input type="text" name="goods_stock[]" value="1" size="10"></td>
            <td style="background-color: rgb(255, 255, 255);"><input type="button" class="button" value="+" id="plus"></td>
        </tr>

        <tr>
            <td align="center" colspan="5" style="background-color: rgb(255, 255, 255);">
                <input type="submit" value=" 保存 ">
            </td>
        </tr>
        </tbody>
    </table>
    </form>
    <!-- 全局js -->
    <script src="{{asset('hadmin/js/jquery.min.js?v=2.1.4')}}"></script>
    <script src="{{asset('hadmin/js/bootstrap.min.js?v=3.3.6')}}"></script>
    <script>
        $(document).on('click','#plus',function(){
            var plus =$(this).val();
            if(plus == "+"){
                $(this).val("-");
                $(this).parent().parent().after($(this).parent().parent().clone());
                $(this).val("+");
            }else{
                $(this).parent().parent().remove();
            }
        })
    </script>
@endsection
