<link href="{{asset('assets/pic_upload/css/style.css')}}" rel="stylesheet">

<script src="{{asset('assets/hadmin/js/jquery.form.js')}}"></script>
<div class="progress">
<div class="progress-bar progress-bar-striped" ><span class="percent">50%</span></div>
</div>
<script type="text/javascript">
    $('#pic').on('change',function(){
       $("#pic_").ajaxSubmit({
             dataType: 'json', //数据格式为json 
             success: function(data) {
                 if(data.status == 1){
                     $('#pic_src').attr('src',data.data);
                 }else{
                     alert("上传失败"); 
                 }
                    //  progress.hide(); 
             }, 
             error:function(xhr){ //上传失败 
                     alert("上传失败"); 
                    //  progress.hide(); 
             } 
       });
    })

/*$(document).ready(function(e) {
     var progress = $(".progress"); 
     var progress_bar = $(".progress-bar");
     var percent = $('.percent');
     $("#uploadphoto").change(function(){
         $("#myupload").ajaxSubmit({ 
             dataType: 'json', //数据格式为json 
             beforeSend: function() { //开始上传 
             progress.show();
             var percentVal = '0%';
             progress_bar.width(percentVal);
             percent.html(percentVal);
         }, 
             uploadProgress: function(event, position, total, percentComplete) { 
                 var percentVal = percentComplete + '%'; //获得进度 
                 progress_bar.width(percentVal); //上传进度条宽度变宽 
                 percent.html(percentVal); //显示上传进度百分比 
             }, 
             success: function(data) {
              
                 if(data.status == 1){
                     var src = data.url; 
                     var attstr= '<img src="'+src+'">'; 
                     $(".imglist").append(attstr);
                     $(".res").html("上传图片"+data.name+"成功，图片大小："+data.size+"K,文件地址："+data.url);
                 }else{
                     $(".res").html(data.content);
                 }
                     progress.hide(); 
             }, 
             error:function(xhr){ //上传失败 
                     alert("上传失败"); 
                     progress.hide(); 
             } 
         }); 
     });
  
});*/
</script>
