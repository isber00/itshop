<?php if (!defined('THINK_PATH')) exit();?><table>
<?php
foreach($attrdata as $v){ if($v['attr_type']==1){ if($v['attr_input_type']==0){ echo "<tr><td>".$v['attr_name']."</td><td>"; echo "<input type='text' name='attr[".$v['id']."]' /></td></tr>"; }else{ echo "<tr><td><a href='javascript:' onclick='copysel(this)'>[+]</a>".$v['attr_name'].":</td><td>"; echo "<select name='attr[".$v['id']."][]'>"; $attrs = explode(',',$v['attr_value']); foreach($attrs as $v1){ echo "<option value='".$v1."'>".$v1."</option>"; } echo "</select></td></tr>"; } }else{ if($v['attr_input_type']==0){ echo "<tr><td>".$v['attr_name']."</td><td>"; echo "<input type='text' name='attr[".$v['id']."]' /></td></tr>"; }else{ echo "<tr><td>".$v['attr_name'].":</td><td>"; echo "<select name='attr[".$v['id']."]'>"; $attrs = explode(',',$v['attr_value']); foreach($attrs as $v1){ echo "<option value='".$v1."'>".$v1."</option>"; } echo "</select></td></tr>"; } } } ?>

</table>
<script>
function copysel(o){
        //取出当前行
        var trs = $(o).parent().parent();
        // 如果a标签里面是[+]则开始复制，如果是[-]则删除当前行
        if($(o).html()=='[+]'){
                //定义新行
                var new_trs = trs.clone();//
                //把新行里面的[+]改成[-]
                new_trs.find('a').html('[-]');
                //把新行添加到当前行的后面
                trs.after(new_trs);
        }else{
            trs.remove();
        }
    
}
    
</script>