<!-- ===========================================input 上传文件样式========================================= -->
<input type="button" value="详情图" onclick="pathdes.click()" style="width:8%;border:1px solid #ccc;background:#fff">  <img src="{{$data['detail']}}" width="70">
<input type="file"  name="detail" id="pathdes" value="{{$data['detail']}}" style="display:none" onchange="upfile.value=this.value">

<!-- ===========================================input checkbox 反选========================================= -->
 <script type="text/javascript">
function CheckedRev(){ 
	var arr = $(':checkbox'); 
	for(var i=0;i<arr.length;i++){ 
	arr[i].checked = ! arr[i].checked; 
	} 
} 
// <!-- ===========================================input checkbox 全选========================================= -->

$(function() { 
	$("#CheckAll").click(function() { 
	var flag = $(this).attr("checked"); 
	$("[name=subBox]:checkbox").each(function() { 
	$(this).attr("checked", flag); 
	}) 
	}) 
}) 
// <!-- ===========================================input checkbox 全选 全不选========================================= -->
$(function(){
        $('#all_check').on('click',function(){
            console.log($(this).attr('checked'));
          if($(this).attr('checked')!=undefined){
            $('input[type="checkbox"]').removeAttr('checked');
            // 取消选中
            $(this).removeAttr('checked');
          }else{
            var arr = $('input[type="checkbox"]');
            for (var i = 0; i < arr.length; i++) {
                arr[i].checked = true;
            }
            // 设置选中
            $(this).attr('checked','checked');
          }
        })
    })
// <!-- ===========================================input checkbox 获取当前已被选中的标签========================================= -->
 //    
       var arr = $('.check_');
       var ids = [];
       var arr_=[];
       // 循环加选中状态
       for(var i = 0; i < arr.length; i++ ){
         if (arr[i].checked){
         // 如果被选中则将id存到数组 push 存到数组中 也可以存标签
            ids.push(arr[i].dataset.id); 
            arr_.push(arr[i]);
         }
       }
// <!-- ==================================鼠标 移入 移出 图片淡入淡出获取当前已被选中的标签============================== -->

   $('.big_pic').on('mouseover',function(){
    // 获取当前图片
    var pic = $(this).attr('src');
    $('.pic').fadeIn(600);
    $('.__pic').css('border-radius','20px');
    $('.__pic').css('border-solid','20px');
    $('.__pic').attr('src',pic);
    
  })
 $('.big_pic').on('mouseout',function(){
      $('.pic').fadeOut(600);
 });
</script>
<!-- ===============css 上传文件样式================= -->
/*<input type="file" style="width:0px;height:0px;border:0px;" name="pic" id="price" value="" placeholder="公告标题" >
<input type="button" style="" onclick="$('input[type=\'file\']').click();" value="上传">
</div>*/

<!-- #=============== js正则匹配密码强度================= -->
<script type="text/javascript">
$.checkPwd = function(v){
 v=$.trim(v);
 if(v.length<6||v.length>30){
    return "密码长度为6-30位";
  }
  if(/^\d+$/.test(v))
  {
    return "全数字";
  }
  if(/^[a-z]+$/i.test(v))
  {
    return "全字母";
  }
  if(!/^[A-Za-z0-9]+$/.test(v))
  {
    return "只能含有数字有字母";
  }
  return "正确";
};
</script>
<!-- #=============== js bootstarp 模态框调用================= -->

<!-- 1.在按钮里加上 data-target="#名字"  在下方模态框加上 id=名字  -->
                           <!-- 按钮 -->
  <button type="button" data-toggle="modal"       data-target="#export_modal"         class="btn btn-danger btn-sm" id="export">导出到表格</button>
                           <!-- 模态框 -->
  <div class="modal fade" id="export_modal" role="dialog" aria-labelledby="gridSystemModalLabel">

<!-- 2.在按钮里加上 id=名字  在下方模态框加上 id=另一个名字 点击按钮 $('#另一个名字').modal(); -->
                          <!-- 按钮 -->
  <button type="button" data-toggle="modal"  data-target="" class="btn btn-danger btn-sm" id="export">导出到表格</button>

                          <!-- 模态框 -->
  <div class="modal fade" id="export_modal" role="dialog" aria-labelledby="gridSystemModalLabel">
                          <!-- 模态框唤醒JS-->
      <script type="text/javascript">
    $('#export').click(function(){
        $('#export_modal').modal();
    })
    </script>
<!-- ============================== 上传多个文件 多选================================ -->

<input type="file" name="img" multiple="multiple" />

<!-- ============================== 上传多个文件 显示即将上传的图片================================ -->
<!-- 上传图片 -->
 <input type="file" name="pic"  id="img" multiple="multiple"  style="display: none" class="form-control">
<!-- 显示图片的地方 -->
 <img id="show-img" src="{$data['pic']}" style = "height:50%;margin-left:9%;display: none"  >
<script type="text/javascript">
      // 改变事件
        $('#img').on('change',function(){
                console.log($(this).val());
                // 显示上传的即将上传的图片
                setImageShow('img','show-img'); 
            })                //input id  //显示id
            //处理即将上传的图片获取李静设置宽高
            function setImageShow(fileId,imgId){  //上传图片显示,input内用onchange
                var docObj = document.getElementById(fileId);
                var fileList = docObj.files;
                var imgObjPreview = document.getElementById(imgId);
                imgObjPreview.style.width="200px";
                imgObjPreview.style.height=height:50%;
                imgObjPreview.style.display='block';
                imgObjPreview.src = window.URL.createObjectURL(fileList[0]);
                $('.pay').css('display','none');//如果是单图片就隐藏添加图标
            }
</script>


<!-- ============================== js input 消除非法字体================================ -->

<input id="amount"onkeyup="this.value=this.value.replace(/\D/g,'')"  
 onafterpaste="this.value=this.value.replace(/\D/g,'')"//消除非法字体
 name="amount" type="text" />

<!-- ==============================  引入js css方式================================ -->


 <script  src="/bootstrap/js/bootstrap.min.js"></script> 
<script type="text/javascript">
  (function () {
    var text = '<link rel="stylesheet" type="text/css" href="/bootstrap/css/bootstrap.min.css">'
    $('head').append(text);
  })();
</script>


<!-- ============================== js confirm================================ -->
<button type="button" class="btn btn-primary" onclick="if(!confirm('确定吗?')) return false; else  score({$member['uid']});">提交</button>

<!-- ============================== js HAdmin后台 成功错误提示弹出================================ -->

<!-- 错误成功提示信息 -->
<div class="ibox-content">
    <div class="alert alert-success alert-dismissable" id="success" style="display:none" >
        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
       
<!-- ============================== js 动态绑定 on 和change 的写法================================ -->
 <!-- 
  $(".levelSelect").change(function(){
      //does some stuff;
  });

 $(document).on('change','.levelSelect',function(){
       //does some stuff;
 })

 $(.levelSelect).on('change',function(){
        //does some stuff;
 }) 
 -->

<!-- ============================== js find()================================ -->

 <!-- find() 方法获得当前元素集合中每个元素的后代，通过选择器、jQuery 对象或元素来筛选。 -->

 <!-- 搜索所有段落中的后代 span 元素，并将其颜色设置为红色： -->
 <!-- $("p").find("span").css('color','red'); -->

<!-- ============================== js find()================================ -->
<!-- 
调试过程中，出现很奇怪的异常，该项不一定通过验证，且checkbox的状态一直是未选中的状态。但是再调试过程中查看checkbox的值，是有值的。

本以为是JQuery无法验证通过代码设置的值，再谷歌不正常的情况下到处找资料，终于发现是checkbox设置值的问题，JQuery1.6之后，使用如下代码设置

checkbox的的选中与否

-->
<script>
  //当使用radio 或者checkbox 利用js切换时不要使用attr 来改变 使用prop来改变不会出现后台改接收不到该name值 
$('.myCheckbox').prop('checked', true);
$('.myCheckbox').prop('checked', false); 
</script>

<!-- ============================== js download() 浏览器点击图片下载 而不是浏览================================ -->
<script>
function download(src) {
        var $a = document.createElement('a');
        $a.setAttribute("href", src);
        $a.setAttribute("download", "");
        var evObj = document.createEvent('MouseEvents');
        evObj.initMouseEvent( 'click', true, true, window, 0, 0, 0, 0, 0, false, false, true, false, 0, null);
        $a.dispatchEvent(evObj);
    };

</script>
<!-- ============================== js  css图片等比例放大  transform: scale(6.5); ================================ -->
<style>   
      img{
           width: 50px;
           height: 80px;
          cursor: pointer;
          transition: all 0.6s;
        }
         img:hover{
            transform: scale(6.5);
        }
        </style>
<!-- ============================== js     jquery.cookie.js插件： ================================ -->

      
    <script type="text/javascript" src="js/jquery-1.6.2.min.js"></script>  
    <script type="text/javascript" src="js/jquery.cookie.js"></script>   
      
    新增cookie：  
        $.cookie('cookieName', 'cookieValue');    
        注：如果没有设置cookie的有效期，则cookie默认在浏览器关闭前都有效，故被称为"会话cookie"。  
          
        // 创建一个cookie并设置有效时间为7天:  
        $.cookie('cookieName', 'cookieValue', { expires: 7 });  
          
        // 创建一个cookie并设置cookie的有效路径：  
        $.cookie('cookieName', 'cookieValue', { expires: 7, path: '/' });  
          
    读取cookie：  
        $.cookie('cookieName'); // 若cookie存在则返回'cookieValue'；若cookie不存在则返回null   
          
    删除cookie：把ncookie的值设为null即可  
        $.cookie('the_cookie', null);   

<!-- ============================== js     js转时间戳 ================================ -->


        //js转时间戳
    function timestampToTime(timestamp) {
        var date = new Date(timestamp * 1000);//时间戳为10位需*1000，时间戳为13位的话不需乘1000
        Y = date.getFullYear() + '-';
        M = (date.getMonth()+1 < 10 ? '0'+(date.getMonth()+1) : date.getMonth()+1) + '-';
        D = date.getDate() + ' ';
        h = date.getHours() + ':';
        m = date.getMinutes() + ':';
        s = date.getSeconds();
        return Y+M+D+h+m+s;
    