onclick="return confirm('你确定要重置此用户密码吗?');"
// 事例
<input name="Submit" type="submit" class="inputedit" value="删除"
 onclick="{if(confirm('确定纪录吗?')){
  this.document.formname.submit();
  return true;}return false;
 }"><input name="按钮" type="button" ID="ok" onclick="{if(confirm('确定删除吗?')){
 window.location='Action.asp?Action=Del&TableName=Item&ID=<%=ID%>';
 return true;
}return false;}" value="删除栏目" />"
// 样式中 id具有唯一性 获取遍历的事件时用class获取最为稳妥
// TODO 将js整合到一起
<script type="text/javascript">
 $('.delete').on('click',function(){
        if (!confirm('确定删除吗')) {
            return false;
        }
        var  id = $(this).attr('data-id') 
        var box = $(this)
        $.post("{:U('Content/del')}",{id:id},function(res){
            if (res.status == 'success') {
                box.parent().parent().remove();
            }else{
                alert(res.message)
            }
        })
    })
</script>