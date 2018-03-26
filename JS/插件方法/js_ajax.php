<!-- 传值 输出标签 标签开关 -->
<script type="text/javascript">
$(function () {
        var flag=false;
        $(".icon-double-angle-right").click(function(){
            if (flag){
                $(".add-box").remove();
                return flag=false;
            }else{
                var box = $(this);
            $.get('/Admin/Users/mysubordinate.html',{pid:$(this).attr('value')},function(data){
                if(data.status==1){
                    var data = data.mysubordinate;
                }else{
                    alert('此用户没有下级!');
                    return;
                }
                for(var i=0 ;i<data.length;i++){
                    box.parent().parent().after('<tr class="add-box"><td><a style="float:right" href="javascript:void(0)">'+i+'</a></td><td class=" ">'+
                    ''+data[i].phone+'</td>'+
                    '<td class="hidden-480 ">'+data[i].nickname+'</td>'+
                    '<td class=" ">'+data[i].created_at+'</td>'+
                    '<td class=" ">'+data[i].zmoney+'</td>'+
                    '<td class=" ">'+data[i].score+'</td>'+
                    '<td class=" ">'+data[i].money+'</td>'+
                      '<td class=" ">'+data[i].rank+'</td>'+
                        '<td class=" ">'+data[i].zt_num+'</td>'+
                    '<td class=" ">'+data[i].dr_num+'</td>'+
                    '<td class=" ">'+' '+'</td>'+
                    '<td class=" "><a href=/Admin/Users/money.html?id='+ data[i].id + '>余额充值</a></td></tr>'

                    )
                }
            });
            return flag=true;
            }
        });
    });
</script>

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
        .kll-out_box {
            position: absolute;
            top: 220px;
            left: 456px;
            z-index: 500;
            background: rgba(0,0,0,0.4);
            width: 300px;
            height: 209px;
            border-radius: 5px;
            display: none;
        }
        .kll-out_box h2 {
            font-size: 30px;
            line-height: 50px;
            text-align: center;
            color: #fff;
            font-weight: 900;
        }
        .kll-out_box p {
            width: 50px;
            line-height: 30px;
            position: absolute;
            top: 130px;
            border-radius: 10px;
            cursor: pointer;
        }
        .kll-out_yes {
            left: 80px;
            color: #000;
            background: rgba(0,255,0,0.9);
            text-align: center;
        }
        .kll-out_no {
            right: 80px;
            color: #fff;
            background: rgba(0,0,255,0.9);
            text-align: center;
        }
        .user_active {
            cursor: pointer;
        }
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
        <div class="kll-out_box">
            <h2>是否确认激活</h2>
            <p class="kll-out_yes">是</p>
            <p class="kll-out_no">否</p>
        </div>
    <table id="sample-table-2" class="table table-striped table-bordered table-hover dataTable" aria-describedby="sample-table-2_info">

            <thead>

                <tr role="row">
                        <th  role="columnheader" tabindex="0" aria-controls="sample-table-2" rowspan="1" colspan="1" aria-label="Domain: activate to sort column ascending" style="width: 165px;">序号</th>
                        <th  role="columnheader" tabindex="0" aria-controls="sample-table-2" rowspan="1" colspan="1" aria-label="Domain: activate to sort column ascending" style="width: 165px;">账号</th>
                        <th  role="columnheader" tabindex="0" aria-controls="sample-table-2" rowspan="1" colspan="1" aria-label="Price: activate to sort column ascending" style="width: 112px;">手机号</th>
                        <th  role="columnheader" tabindex="0" aria-controls="sample-table-2" rowspan="1" colspan="1" aria-label="Clicks: activate to sort column ascending" style="width: 123px;">头像</th>
                       <th  role="columnheader" tabindex="0" aria-controls="sample-table-2" rowspan="1" colspan="1" aria-label="Status: activate to sort column ascending" style="width: 173px;">昵称</th>
                       <th  role="columnheader" tabindex="0" aria-controls="sample-table-2" rowspan="1" colspan="1" aria-label="Status: activate to sort column ascending" style="width: 173px;">用户状态</th>
                       <th  role="columnheader" tabindex="0" aria-controls="sample-table-2" rowspan="1" colspan="1" aria-label="Status: activate to sort column ascending" style="width: 173px;">蘑菇数量</th>
                       <th  role="columnheader" tabindex="0" aria-controls="sample-table-2" rowspan="1" colspan="1" aria-label="Status: activate to sort column ascending" style="width: 173px;">每天交易额</th>
                       <th  role="columnheader" tabindex="0" aria-controls="sample-table-2" rowspan="1" colspan="1" aria-label="Status: activate to sort column ascending" style="width: 173px;">重置密码</th>
                        <th  role="columnheader" tabindex="0" aria-controls="sample-table-2" rowspan="1" colspan="1" aria-label="Status: activate to sort column ascending" style="width: 173px;">进入该账户</th>
                    </tr>
            </thead>
        <tbody role="alert" aria-live="polite" aria-relevant="all">
            @foreach($data['data'] as $k=>$v)
                <tr class="odd">
                    <td class="append" style="width:50px;font-size:10px"><span class="id">{{$v['id']}}</span></td>
                    <td class=" "><a href="javascript:void(0)">{{$v['account']}}</a></td>
                    <td class=" ">{{$v['phone']}}</td>
                    <td class="hidden-480 "><img src="{{$v['headimg']}}" style="width:36px;height:36px;" ></td>
                    <td class=" ">{{$v['nickname']}}</td>
                    <td class="kll-click_out">@if($v['status']==2)已激活 @else <span class="user_active">点击激活</span>@endif</td>

                    <td class="mushroom_sum">
                    <input type="" name="" value="{{$v['mushroom_sum']}}" readonly="readonly"  onkeyup="this.value=this.value.replace(/\D/g,'')" onafterpaste="this.value=this.value.replace(/\D/g,'')"  style="border:0px"></td>

                    <td class="maxdeal_num">
                    <input type="" name="" value="{{$v['maxdeal_num']}}" readonly="readonly" onkeyup="this.value=this.value.replace(/\D/g,'')" onafterpaste="this.value=this.value.replace(/\D/g,'')" style="border:0px" ></td>
                     <td class="kll-click_out"><button style="margin-left"  class="btn btn-sm btn-inverse button_button" data-id='{{$v['id']}}' onclick="if (confirm('确认重置密码吗?')){button_fun(this)}">重置密码</button></td>
                     <td class="kll-click_out"><a  class="btn btn-sm btn-primary button_button" data-id='{{$v['id']}}' onclick="if (confirm('确认要进入该账户的前台页面么?')){a_fun(this)}">进入该账户</a></td>
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
/*点击修改 修改用户蘑菇数量*/
$(function(){
    var demo='';
    var old_val=0;
    $('.mushroom_sum input').dblclick(function(){
        //去除只读属性
         $(this).removeAttr('readonly');
         // 获取当前标签的值
             old_val=$(this).val();
             demo=$(this);
             // alert($(this).parent('.mushroom_sum').parent().children().children('.id').text());

    })
    $('.mushroom_sum input').on("change", function () {
        // 获取当前input修改后的值
        var mu_val = $(this).val();
        // 获取当前修改的人的id
        var uid =$(this).parent('.mushroom_sum').parent().children().children('.id').text()
        // 传入后台修改数据
        $.get('/Admin/Users/edit.html',{num:mu_val,old_num:old_val,id:uid,type:1},function(data){
                if (data.status==1) {
                alert(data.message);
                }else{
                    demo.val(old_val);
                    alert(data.message);
                }
            });
    }).on("blur", function () {
        $(this).attr('readonly','readonly');
    });

})
/*点击修改 修改用户每日交易额*/
$(function(){
    var demo='';
    var old_val=0;
    var blurChange = 0;
    $('.maxdeal_num input').dblclick(function(){
        //去除只读属性
         $(this).removeAttr('readonly');
         // 获取当前标签的值
             old_val=$(this).val();
             demo=$(this);
             // alert($(this).parent('.mushroom_sum').parent().children().children('.id').text());
             blurChange = 1;

    })
    $('.maxdeal_num input').on("change", function () {
        // 获取当前input修改后的值
        var mu_val = $(this).val();
        // 获取当前修改的人的id
        var uid =$(this).parent('.maxdeal_num').parent().children().children('.id').text()
        // 传入后台修改数据
        $.get('/Admin/Users/edit.html',{num:mu_val,old_num:old_val,id:uid,type:3},function(data){
                if (data.status==1) {
                    if (blurChange) {
                        alert(data.message);
                        blurChange = 0;
                    }
                }else{
                    //是当前标签变回原来的值
                    demo.val(old_val);
                    // 输出错误信息
                    if (blurChange) {
                        alert(data.message);
                        blurChange = 0;
                    }
                }
            });
    }).on("blur", function () {
        $(this).attr('readonly','readonly');
    });

})
/*修改用激活状态*/
// $(function(){
//     $('.user_active').on("click", function() {
//         var box = $(this);
//         var uid =$(this).parent().parent().children().children('.id').text();
//         // 传入后台修改数据
//         $.get('/Admin/Users/edit.html',{id:uid,type:2},function(data){
//             if (data.status==1) {
//                 box.text('已激活')
//                 alert(data.message);
//             }else{
//                 alert(data.message);
//             }
//         });
//         $(this).attr('readonly','readonly');
//     });

// })
/*修改用激活状态*/
$(function () {
        var box;
        var uid;
        $(".user_active").on("click", function () {
            box = $(this);
            uid =$(this).parent().parent().children().children('.id').text();
            $(".kll-out_box").css("display", "block");
        });
        $(".kll-out_yes").on("click", function () {
            $.get('/Admin/Users/edit.html',{id:uid,type:2},function(data){
                if (data.status==1) {
                    box.text('已激活')
                    alert(data.message);
                }else{
                    alert(data.message);
                }
            });
            box.attr('readonly','readonly');
            $(".kll-out_box").css("display", "none");
        });
        $(".kll-out_no").on("click", function () {
            $(".kll-out_box").css("display", "none");
        });
});

// 重置用户密码
var button_fun=function(b){
        var uid = $(b).parent().parent().children().children('.id').text();
        // 获取当前修改的人的id
        $.get('/Admin/Users/edit.html',{id:uid,type:4},function(data){
            if (data.status==1) {
                // alert(data.message);
            }else{
                alert(data.message);
            }
        })
}
//进入指定用户
var a_fun=function(b){
        var uid = $(b).parent().parent().children().children('.id').text();
        // 获取当前修改的人的id
        $.get('/Admin/Users/edit.html',{id:uid,type:5},function(data){
            if (data.status==1) {
                // alert(data.message);
                window.location.href="http://cjmla.366dian.com/index.html";
            }else{
                alert(data.message);
            }
        })
}
</script>

@endsection