<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>ECSHOP 管理中心 - 商品列表 </title>
<meta name="robots" c>
<meta http-equiv="Content-Type" c />
<link href="/Public/admin/styles/general.css" rel="stylesheet" type="text/css" />
<link href="/Public/admin/styles/main.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/Public/js/jquery.js"></script>
<script>
$(function(){
    $("select[name=type_id]").change(function(){
        //获取商品类型的id
         var type_id = $(this).val();
         $.ajax({
            type:'get',
            url:'/admin.php/Admin/Attribute/showattr/type_id/'+type_id,
            success:function(msg){
                //返回的已经遍历好的html代码
                $("#listDiv").html(msg);
            }
         });
    });
});
</script>
</head>
<body>

<h1>
<span class="action-span"><a href="/admin.php/Admin/Attribute/add/type_id/<?php echo $type_id?>">添加属性</a></span>
<span class="action-span1"><a href="#">ECSHOP 管理中心</a> </span><span id="search_id" class="action-span1"> - 商品列表 </span>
<div style="clear:both"></div>
</h1>

<div class="form-div">

  <form action="" name="searchForm">
    <img src="/Public/admin/images/icon_search.gif" width="26" height="22" border="0" alt="SEARCH" />
    按商品类型显示：<select name="type_id"><option value="0">所有分类</option>
    <?php foreach($typedata as $v){ if($v['id']==$type_id){ $sel = "selected='selected'"; }else{ $sel=''; } ?>
    <option <?php echo $sel;?> value="<?php echo $v['id']?>"><?php echo $v['type_name']?></option>
    <?php }?>
    </select>
  </form>
</div>
<form method="post" action="" name="listForm" >

  <div class="list-div" id="listDiv">
<table cellpadding="3" cellspacing="1">
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

<table id="page-table" cellspacing="0">
  <tr>
    <td align="right" nowrap="true">
      
        
          上页&nbsp;&nbsp;1</b>&lt;&lt; [1]&nbsp;&nbsp;<a href=admin.php?c=goods&a=goodsList&page=2& title='第2页'>[2]</a>&nbsp;&nbsp;<a href=admin.php?c=goods&a=goodsList&page=3& title='第3页'>[3]</a>&nbsp;&nbsp;<a href=admin.php?c=goods&a=goodsList&page=4& title='第4页'>[4]</a>&nbsp;&nbsp;<a href=admin.php?c=goods&a=goodsList&page=5& title='第5页'>[5]</a>&nbsp;&nbsp;<a href=admin.php?c=goods&a=goodsList&page=8& title='第8页'>&gt;&gt;8</a>&nbsp;<a href=admin.php?c=goods&a=goodsList&page=2&  title='下一页'>[下一页]</a>
    
    </td>
  </tr>

</table>

</div>
</form>

<div id="footer">
共执行 7 个查询，用时 0.112141 秒，Gzip 已禁用，内存占用 3.085 MB<br />
版权所有 &copy; 2005-2010 上海商派网络科技有限公司，并保留所有权利。</div>
</body>
</html>