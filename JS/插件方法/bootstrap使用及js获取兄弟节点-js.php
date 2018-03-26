<!-- 模态框div -->
                        <!-- 此处为模态框的id -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="exampleModalLabel">修改用户信息</h4>
      </div>
      <div class="modal-body">
        <form>
          <div class="form-group">
            <label for="recipient-name" class="control-label">昵称:</label>
            <input type="text" class="form-control" id="nickname">
          </div>
          <div class="form-group">
            <label for="recipient-name" class="control-label">电话:</label>
            <input type="text" class="form-control" id="phone">
          </div>
          <div class="form-group">
            <label for="message-text" class="control-label">注册地址:</label>
            <textarea class="form-control" id="province"></textarea>
          </div>
          <div class="form-group">
            <label for="message-text" class="control-label">收货地址:</label>
            <textarea class="form-control" id="address"></textarea>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
        <button type="button" class="btn btn-primary">提交</button>
      </div>
    </div>
  </div>
</div>
<!-- 模态框div  结束 -->

<!-- ================修改用户信息js================= -->
<script type="text/javascript">
    $(function(){
           $('.edit').on('click',function(){
             // 显示模态框
             $('#myModal').modal('show');
             // 获取用户要修改的信息       $('#id').siblings('#id或#class').val()
             var nickname=$(this).parent().siblings(".nickname").text();
             var phone=$(this).parent().siblings(".phone").text();
             var province=$(this).parent().siblings(".province").text();
             var address=$(this).parent().siblings(".address").text();
             // 将用户信息写入到input
             $('#nickname').val(nickname);
             $('#phone').val(phone);
             $('#province').val(province);
             $('#address').val(address);
        })  
    })
   
</script>