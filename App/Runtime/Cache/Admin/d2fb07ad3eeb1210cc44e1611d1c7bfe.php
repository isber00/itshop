<?php if (!defined('THINK_PATH')) exit();?><table cellpadding="3" cellspacing="1">
  <tr>
    <th>
      <input onclick='listTable.selectAll(this, "checkboxes")' type="checkbox" />
      <a href="#">编号</a><img src="/Public/admin/images/sort_desc.gif"/>    </th>
    <th><a href="#">属性名称</a></th>
    <th><a href="#">商品类型</a></th>
    <th><a href="#">属性类型</a></th>
    <th><a href="#">属性值的录入方式</a></th>
    <th><a href="#">可选值列表</a></th>
        <th>操作</th>
  </tr>
  <?php foreach($attrdata as $v){?>
      <tr>
    <td><input type="checkbox" name="checkboxes[]" value="32" /><?php echo $v['id']?></td>
    <td class="first-cell" style=""><span ><?php echo $v['attr_name']?></span></td>
    <td><span ><?php echo $v['type_name']?></span></td>
    <td align="right"><span ><?php echo $v['attr_type']==1?'单选属性':'唯一属性'?>
    <td align="right"><span ><?php echo $v['attr_input_type']==1?'列表选择':'手工输入'?>
    </span></td>
    <td align="center"><?php echo $v['attr_value']?></td>
        <td align="center">
      <a href="#" target="_blank" title="查看"><img src="/Public/admin/images/icon_view.gif" width="16" height="16" border="0" /></a>
      <a href="#" title="编辑"><img src="/Public/admin/images/icon_edit.gif" width="16" height="16" border="0" /></a>
      <a href="#" title="复制"><img src="/Public/admin/images/icon_copy.gif" width="16" height="16" border="0" /></a>
      <a href="#"  title="回收站"><img src="/Public/admin/images/icon_trash.gif" width="16" height="16" border="0" /></a>
      <a href="#" title="货品列表"><img src="/Public/admin/images/icon_docs.gif" width="16" height="16" border="0" /></a>          </td>
  </tr>
    <?php }?>   
</table>