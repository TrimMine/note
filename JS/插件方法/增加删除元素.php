        <!DOCTYPE html>
        <html>
        <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title> - 文章添加</title>
        <meta name="keywords" content="">
        <meta name="description" content="">
        <link rel="shortcut icon" href="favicon.ico"> 
        <link href="__CSS__/bootstrap.min.css?v=3.3.6" rel="stylesheet">
        <link href="__CSS__/font-awesome.css?v=4.4.0" rel="stylesheet">
        <link href="__CSS__/plugins/iCheck/custom.css" rel="stylesheet">
        <link href="__CSS__/animate.css" rel="stylesheet">
        <link href="__CSS__/style.css?v=4.1.0" rel="stylesheet">    
        </head>
        <body>
                <!-- 文章添加 -->
                    <div class="wrapper wrapper-content animated fadeInRight">
                     <div class="row">
                        <div class="col-sm-12">
                            <div class="ibox float-e-margins">
                                <div class="ibox-title">
                                <h5>文章管理 -->添加</h5>
              
                                <div class="text-right">
                                    <button type="button" id="class_info" class="btn btn-w-m btn-danger" data-toggle="modal" data-target="#myModal">
                                        分类管理
                                    </button>
                                </div>
                  
                                <hr>
                                <div class="ibox-tools">
                                    <a class="collapse-link">
                                    </a>
                                <a class="dropdown-toggle" data-toggle="dropdown" href="table_data_tables.html#">
                                </a>
                                
                                <a class="close-link">
                                </a>
                            </div>
                        </div>
                        <form method="post" class="form-horizontal" action = "{:U('Advert/add_article')} " enctype="multipart/form-data" >
                          
                            <div class="form-group has-success">
                                <label class="col-sm-1 control-label">文章标题 : </label>

                                <div class="col-sm-10">
                                    <input type="text" name="title" class="form-control">
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group has-warning">
                                <label class="col-sm-1 control-label">文章描述 :</label>

                                <div class="col-sm-10">
                                    <input type="text" name="description" class="form-control">
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group has-error">
                                <label class="col-sm-1 control-label">文章详情 :</label>

                                <div class="col-sm-10">
                                    <input type="text" name="content" class="form-control">
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group has-error">
                                <label class="col-sm-1 control-label">文章图片 :</label>

                                <div class="col-sm-10">
                                    <button class="btn btn-success" type="button" onclick="$('#img').click();" >  点击上传图片  </button>
                                    <input type="file" name="pic" id="img" multiple="multiple"  style="display: none" class="form-control">
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group">
                                <div class="col-sm-4 col-sm-offset-1">
                                    <button class="btn btn-w-m btn-danger" type="submit">添加</button>
                                    <button class="btn btn-w-m btn-danger" type="reset">取消</button>
                                </div>
                            </div>
                        </form>
                    </div>
                   </div>
                </div>
             </div>
          </div>
          
         <div class="modal inmodal" id="myModal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content animated bounceInRight">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">关闭</span>
                        </button>
                        <!-- 错误成功提示信息 -->
                        <div class="ibox-content">
                            <div class="alert alert-success alert-dismissable" id="success" style="display:none" >
                                <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                                hAdmin是一个很棒的后台UI框架 
                            </div>
                            <div class="alert alert-danger alert-dismissable"  id="error" style="display:none" >
                                <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                                hAdmin是一个很棒的后台UI框架 
                            </div>
                        </div>
                        <!-- 错误成功提示信息结束 -->
                        <i class="fa fa-laptop modal-icon"></i>
                        <h4 class="modal-title">添加分类</h4>
                        <small class="font-bold">
                    </div>

                        <!-- 全部分类 -->
                    <div class="modal-body">
                        <p><strong>已有分类 : </strong>
                        <br id = 'br'>
                       <foreach name="DataClass" item="v">
                            <button type="button" data-id="{$v['id']}" class="btn btn-outline btn-danger" style="margin-left:5px;margin-top:5px"> 
                            <span>{$v['class']}</span>
                             <b style="display:none">点击删除</b>
                             </button>
                        </foreach>
                        </p>
                        <div class="form-group"><label><strong>分类名 : </strong></label> 
                        <input type="email" name="class_name" placeholder="请输入分类名" class="form-control"></div>
                    </div>
                        <!-- 全部分类结束 -->

                    <div class="modal-footer">
                        <button type="button"  class="btn btn-white" data-dismiss="modal">关闭</button>
                        <button type="button" id="save"  class="btn btn-primary">保存</button>
                    </div>
                </div>
            </div>
        </div>
</body>
</html>             
<!-- 自定义js -->
<script src="__JS__/jquery.min.js?v=2.1.4"></script>
<script src="__JS__/content.js?v=1.0.0"></script>

<script src="__JS__/bootstrap.min.js?v=3.3.6"></script>
<!-- iCheck -->
<script src="__JS__/plugins/iCheck/icheck.min.js"></script>
<script>
    $(document).ready(function () {
        $('.i-checks').iCheck({
            checkboxClass: 'icheckbox_square-green',
            radioClass: 'iradio_square-green',
        });
    });
</script>
<script type="text/javascript">
$(function(){

    // 添加分类
    $('#save').on('click',function(){
        var data = $('input[name="class_name"]').val()
        $.post("{:U('ArticleClass/add_class')}",{class:data},function(data){
            if (data.status == 'success') {
                // 弹出成功提示
                $('#success').slideDown(300);
                // 2秒后自动隐藏
                setTimeout("$('#success').slideUp(300)",2000);
                
                $('.modal-body p').append("<button type='button' data-id='"+data.id+"' class='btn btn-outline btn-danger'"+ 
                    "style='margin-left:5px;margin-top:5px'>"+
                        "<span>"+data.name.class+"</span>"+
                         "<b style='display:none'>点击删除</b></button>")


            }else{
                // 弹出成功提示
                $('#error').slideDown(300);
                // 2秒后自动隐藏
                setTimeout("$('#error').slideUp(300)",2000); 
            }
        })
    });

    // 鼠标移入样式
    $('.modal-body p').on('mouseover',function(e){
        // 委托btn
        // 将jquery获取的class属性转化为字符串
        var str = ' ' + $(e.target).attr('class');
        // 判断字符串中是否有'btn-outline'字符存在,若存在说明该元素是button,执行事件
        if(str.match('btn-outline')) {
            // 显示删除标签
            $(e.target).children('b').show();
            // 隐藏原标签
            $(e.target).children('span').hide();
            // 鼠标移除恢复样式
             $(e.target).on('mouseleave',function(e){
                // 委托btn
                // 将jquery获取的class属性转化为字符串
                var str = ' ' + $(e.target).attr('class');
                var str1 = ' ' + $(e.target).parent().attr('class');
                // 判断字符串中是否有'btn-outline'字符存在,若存在说明该元素是button,执行事件
                if(str.match('btn-outline')) {
                    // 显示删除标签
                    $(e.target).children('b').hide()
                    // 隐藏原标签
                    $(e.target).children('span').show();
                } else if (str1.match('btn-outline')) {
                    // 显示删除标签
                    $(e.target).parent().children('b').hide()
                    // 隐藏原标签
                    $(e.target).parent().children('span').show();
                }
            });
        }
        
        
    });
    
     // 点击删除
     $('.modal-body p').on('click',function(e){
        console.log($(e.target));
        var str = ' ' + $(e.target).attr('class');
        var str1 = ' ' + $(e.target).parent().attr('class');
        if (str.match('btn-outline') || str1.match('btn-outline')) {
            var id = $(e.target).attr('data-id');
            // 保存删除前的标签
            var box = $(e.target);
            if (!id) {
                id = $(e.target).parent().attr('data-id');
                box = $(e.target).parent();
            }
            $.get('{:U("ArticleClass/delete_class")}',{id:id},function(data){
                if (data.status == 'success') {
                    // 隐藏已经删除的标签
                    box.hide();
                    $('#success').slideDown(300);
                    setTimeout("$('#success').slideUp(300)",2000); 
                }else{
                    $('#error').slideDown(300);
                    setTimeout("$('#error').slideUp(300)",2000); 
                }

            })
        }
    });

})

</script>





