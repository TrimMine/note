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
                       <th  role="columnheader" tabindex="0" aria-controls="sample-table-2" rowspan="1" colspan="1" aria-label="Status: activate to sort column ascending" style="width: 173px;">留言内容</th>
                       <th  role="columnheader" tabindex="0" aria-controls="sample-table-2" rowspan="1" colspan="1" aria-label="Status: activate to sort column ascending" style="width: 173px;">系统回复</th>
                       <th  role="columnheader" tabindex="0" aria-controls="sample-table-2" rowspan="1" colspan="1" aria-label="Status: activate to sort column ascending" style="width: 173px;">回复</th>
                    </tr>
            </thead>
        <tbody role="alert" aria-live="polite" aria-relevant="all">
            @foreach($info as $k=>$v)
                <tr class="odd">
                    <td class="append" style="width:50px;font-size:10px"><span class="id">{{$v['forum_id']}}</span></td>
                    <td class=" "><a href="javascript:void(0)">{{$v['account']}}</a></td>
                    <td class=" ">{{$v['phone']}}</td>
                    <td class="hidden-480 "><img src="{{$v['headimg']}}" style="width:36px;height:36px;" ></td>
                    <td class=" "><p>{{$v['nickname']}}</p></td>
                    <td class="content" style="width:100px;">{{$v['content']}}</td>
    
                    <td class="reply">{{$v['reply']}}</td>
                     <td class="kll-click_out"><a style="margin-left:20%" class="btn btn-sm btn-primary button_button" data-id="{{$v['forum_id']}}" data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo" onclick="reply({{$v['forum_id']}},'{{$v["nickname"]}}')">回复</a></td>
                </tr>
             @endforeach
        </tbody>
         <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="exampleModalLabel">回复信息</h4>
                  </div>
                  <div class="modal-body">
                    <form>
                      <div class="form-group">
                        <label for="recipient-name" class="control-label">该留言人昵称</label><br>
                        <span style="color:red;font-size:15px;font-weight:bold;" class="nickname"></span>
                      </div>
                      <div class="form-group">
                        <label for="message-text" class="control-label">请填写回复内容:</label>
                        <textarea class="form-control" id="message-text" style="height:100px"></textarea>
                      </div>
                    </form>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-default close_c" data-dismiss="modal">关闭</button>
                    <button type="button" class="btn btn-primary message" data-id={{$v['id']}}>提交回复</button>
                  </div>
                </div>
             </div>
             </div>
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
    // 定义全局id
    var id = 0;
    var box='';
    // 改变id的方法 
    var reply = function(fid,nickname){
        id = fid;
        //将模态框中的留言用户昵称为空
        $('.nickname').text('');
        // 将模态框中的留言用户昵称赋值
        $('.nickname').text(nickname);
        // 将模态框中的留言为空
        $('#message-text').val('');
    }   
    $('.button_button').on('click',function(){
        // 点击事件获取当前系统回复内容的标签
        box=$(this).parent().prev();
    })
    // 静态绑定提交按钮 提交最新的id
    $('.message').click(function(){
        // 获取系统回复的内容
        con=$('#message-text').val();
        // 判断id是否有效
        if(id==0){return false;}
        // ajax传值
       $.post('/Admin/Forum/reply.html',{content:con,id:id},function(data){
            if (data['status']==1) {
                // 返回当前系统回复内容 给标签赋值
                $(box).text(data.data);
                //完成自动点击关闭按钮
                $(".close").click();
                alert(data.message);
            }else{
                // 自动关闭标签
                $(".close").click();
                alert(data.message);
            }
       })
    });
    // 绑定关闭按钮事件(静态)
    $('.close_d').click(function(){
        id = 0;
    });
</script>
@endsection