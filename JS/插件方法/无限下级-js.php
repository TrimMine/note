{{-- 继承公用视图 --}}
@extends('Public.public')
{{-- 分配标题 --}}
@section('title', '浏览用户')

{{-- 分配path级别路径 --}}
@section('title_one','用户管理')
@section('title_two','浏览用户')


{{-- 分配描述 --}}
@section('description', '..')

@section('content')
    <style>
        .form-btn {margin-left: 50px;background-color: #428bca!important;color: #fff;padding: 0 10px;border: 0;line-height: 30px;}
    </style>
	<div class="col-xs-12">
    <div style="overflow:hidden;">
        <h3 class="header smaller lighter blue" style="float: left;">用户列表</h3>
        <!-- <h3 class="header smaller lighter blue" style="float: right;" ><a href="/Admin/Users/excel?{{$where_url}}">表格导出</a></h3> -->
    </div>

    <div class="table-header">最近注册用户</div>
    <div class="table-responsive">
        <div id="sample-table-2_wrapper" class="dataTables_wrapper" role="grid">
        <form id="form">
         <script src="//cdn.bootcss.com/jquery/3.1.1/jquery.js"></script>
        </div>
                <div class="col-sm-3">
                     <div id="sample-table-2_length" class="dataTables_length">
                        <label>手机:
                            <input type="text" name="phone" value="{{$_GET['phone']}}" aria-controls="sample-table-2">
                        </label>
                    </div>
                </div>
                <div class="col-sm-3">
                     <div id="sample-table-2_length" class="dataTables_length">
                        <label>账号:
                            <input type="text" name="account" value="{{$_GET['account']}}" aria-controls="sample-table-2">
                        </label>
                    </div>
                </div>
                <div class="col-sm-3">
                     <div id="sample-table-2_length" class="dataTables_length">
                        <label>昵称:
                            <input type="text" name="nickname" value="{{$_GET['nickname']}}" aria-controls="sample-table-2">
                        </label>
                    </div>
                </div>
                 <div class="col-sm-3">
                    <div class="dataTables_filter" id="sample-table-2_filter">
                        <label>
                           <button id="submit" class="btn btn-sm btn-primary">搜索</button>
                        </label>
                    </div>
                </div>
            </div>
            <script type="text/javascript">
                $(document).ready(function(){
                    $('#submit').click(function(){
                        $('#form').submit();
                    });
                });
            </script>
        </form>
    <table id="sample-table-2" class="table table-striped table-bordered table-hover dataTable" aria-describedby="sample-table-2_info">

            <thead>

                <tr role="row">
                        <th  role="columnheader" tabindex="0" aria-controls="sample-table-2" rowspan="1" colspan="1" aria-label="Domain: activate to sort column ascending" style="width: 165px;">序号</th>
                        <th  role="columnheader" tabindex="0" aria-controls="sample-table-2" rowspan="1" colspan="1" aria-label="Domain: activate to sort column ascending" style="width: 165px;">账号</th>
                        <th  role="columnheader" tabindex="0" aria-controls="sample-table-2" rowspan="1" colspan="1" aria-label="Price: activate to sort column ascending" style="width: 112px;">手机号</th>
                        <th  role="columnheader" tabindex="0" aria-controls="sample-table-2" rowspan="1" colspan="1" aria-label="Clicks: activate to sort column ascending" style="width: 123px;">头像</th>
                       <th  role="columnheader" tabindex="0" aria-controls="sample-table-2" rowspan="1" colspan="1" aria-label="Status: activate to sort column ascending" style="width: 173px;">昵称</th>
                       <th  role="columnheader" tabindex="0" aria-controls="sample-table-2" rowspan="1" colspan="1" aria-label="Status: activate to sort column ascending" style="width: 173px;">蘑菇数量</th>
                       <th  role="columnheader" tabindex="0" aria-controls="sample-table-2" rowspan="1" colspan="1" aria-label="Status: activate to sort column ascending" style="width: 173px;">积分数量</th>
                       <th  role="columnheader" tabindex="0" aria-controls="sample-table-2" rowspan="1" colspan="1" aria-label="Status: activate to sort column ascending" style="width: 173px;">直推人数</th>
                       <th  role="columnheader" tabindex="0" aria-controls="sample-table-2" rowspan="1" colspan="1" aria-label="Status: activate to sort column ascending" style="width: 173px;">签名</th>
                    <th  role="columnheader" tabindex="0" aria-controls="sample-table-2" rowspan="1" colspan="1" aria-label="Price: activate to sort column ascending" style="width: 112px;">用户注册时间</th>
                    <th  role="columnheader" tabindex="0" aria-controls="sample-table-2" rowspan="1" colspan="1" aria-label="Price: activate to sort column ascending" style="width: 112px;">操作</th>
                    </tr>
            </thead>
        <tbody role="alert" aria-live="polite" aria-relevant="all">
            @foreach($data['data'] as $k=>$v)
                <tr class="odd" data-top="ok">
                    <td class="append" style="width:50px;font-size:10px">{{$v['id']}}
                    @if($v['node_num']>=1) <i class="icon-double-angle-right span-add"  value="{{$v['id']}}" style="width:20px;font-size:20px;float:right;" data-status="1"></i>
                    @endif</td>
                    <td class=" "><a href="javascript:void(0)">{{$v['account']}}</a></td>
                    <td class=" ">{{$v['phone']}}</td>
                    <td class="hidden-480 "><img src="{{$v['headimg']}}" style="width:36px;height:36px;" ></td>
                    <td class=" ">{{$v['nickname']}}</td>
                    <td class=" ">{{$v['mushroom_sum']}}</td>
                    <td class=" ">{{$v['integral_sum']}}</td>
                    <td class=" ">{{$v['node_num']}}</td>
                    <td class=" ">{{$v['signature']}}</td>
                    <td class=" ">{{date('Y-m-d H:i',$v['created_at'])}}</td>
                    <td class=" "><a href="/Admin/Users/give.html?id={{$v['id']}}">充值</a> | <a onclick="return confirm('你确定要删除此用户吗?');" href="/Admin/Users/delete.html?id={{$v['id']}}">删除</a></td>
                </tr>
             @endforeach
        </tbody>
        </table>
        <div class="row">
             <div class="col-sm-6">
                <div class="dataTables_info" id="dataTables-example_info" role="alert" aria-live="polite" aria-relevant="all">
                    本页{{$data['to']}}条数据,共{{$data['last_page']}}页 共{{$data['total']}} 条数据
                </div>
            </div>
            <div class="col-sm-6">
                <div class="dataTables_paginate paging_simple_numbers" id="dataTables-example_paginate">
                    <ul class="pagination">
                        <li class="paginate_button previous" aria-controls="dataTables-example" tabindex="0" id="dataTables-example_previous"><a href="/Admin/Users/index.html?{{$data['where_url']}}page=1">首页</a></li>
                        <li class="paginate_button previous @if($data['prev_page_url']=='') disabled @endif" aria-controls="dataTables-example" tabindex="0" id="dataTables-example_previous"><a href="{{$data['prev_page_url']}}">上一页</a></li>
                        @for($i=(($data['form']-1) < 1?1:$data['form']-1);$i <= ($data['last_page']);$i++)
                            @if($i < ($data['form'] + 3) || $i > ($data['last_page']-3))
                            <li class="paginate_button @if($data['form']==$i) disabled @endif" aria-controls="dataTables-example" tabindex="0"><a href="@if($data['form']==$i) javascript:void(0); @else ?{{$data['where_url']}}page={{$i}} @endif">{{$i}}页</a></li>
                            @elseif($data['form'] + 5 > $i || $data['last_page'] - 5 < $i)
                                <li class="paginate_button disabled" aria-controls="dataTables-example" tabindex="0"><a href="javascript:void(0);">.</a></li>
                            @endif
                        @endfor
                        <li class="paginate_button next @if($data['next_page_url']=='') disabled @endif" aria-controls="dataTables-example" tabindex="0" id="dataTables-example_next"><a href="{{$data['next_page_url']}}">下一页</a></li>
                        <li class="paginate_button next @if($data['last_page']=='') disabled @endif" aria-controls="dataTables-example" tabindex="0" id="dataTables-example_next"><a @if($data['last_page']!='') href="?{{$data['where_url']}}page={{$data['last_page']}}" @endif>尾页</a></li>
                    </ul>
                </div>
            </div>
        </div>
            </div>

    </div>

</div>
<script type="text/javascript">
$(function () {
        var firstNum = 1;
        var colorNum = 50;
        function rightClick(box) {
            firstNum++;
            if (box.attr("data-status") != "1"){
                if (box.parent().parent().attr("data-top") == "ok") {//判断是否是顶级
                    $("#sample-table-2 tr[data-top=no]").remove();
                }
                var x = parseInt(box.parent().parent().attr("data-status"));
                var txt = "tr[data-status=" + x + "]";
                var len = $(txt).length;
                for (var i = 1; i < len; i++) {
                    $(txt).eq(1).remove();
                }
                box.attr("data-status", "1");
            }else{
                var x = 200 * Math.random().toFixed(2);
                var y = 200 * Math.random().toFixed(2);
                var z = 200 * Math.random().toFixed(2);
                var color = "rgb(" + x + "," + y + "," + z + ")";
                box.parent().parent().attr("data-status", firstNum);
                $.get('/Admin/Users/mysubordinate.html',{pid:box.attr('value')},function(data){
                    console.log(data);
                    if(data.status==1){
                        var data = data.mysubordinate;
                    }else{
                        alert('此用户没有下级');
                        return;
                    }
                    for(var i=0 ;i<data.length;i++){
                        box.parent().parent().after('<tr class="add-box" data-top="no" style="color:' + color + ';" data-status="' + firstNum + '"><td><span style="float:right" href="javascript:void(0)">'+data[i].id+'</span>' + (data[i].node_num >= 1 ? '<i class="icon-double-angle-right span-add"  value="'+data[i].id+'" style="width:20px;font-size:20px;float:right; " data-status="1"></i>' : '') + '</td><td class=" ">'+
                        ''+data[i].account+'</td>'+
                        '<td class="hidden-480 ">'+data[i].phone+'</td>'+
                        '<td class=" "><img style="width:36px;height:36px;" src='+data[i].headimg+'></td>'+
                        '<td class=" ">'+data[i].nickname+'</td>'+
                        '<td class=" ">'+data[i].mushroom_sum+'</td>'+
                        '<td class=" ">'+data[i].integral_sum+'</td>'+
                          '<td class=" ">'+data[i].node_num+'</td>'+
                            '<td class=" ">'+data[i].signature+'</td>'+
                        '<td class=" ">'+data[i].date+'</td>'+
                        '<td class=" "><a href="/Admin/Users/give.html?id='+data[i].id+'">充值</a> | <a onclick="return confirm('+'你确定要删除此用户吗?);" href="/Admin/Users/delete.html?id='+data[i].id+'">删除</a></td></tr>'

                        )
                    }
                    $(".icon-double-angle-right").unbind("click");
                    $(".icon-double-angle-right").click(function(){
                        rightClick($(this));
                    });
                });
                box.attr("data-status", "2");
            }
        }

        $(".icon-double-angle-right").click(function(){
            rightClick($(this));
        });
    });
</script>

@endsection