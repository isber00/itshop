<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>ECSHOP 管理中心 - 商品列表 </title>
<meta name="robots" c>
<meta http-equiv="Content-Type" c />
<link href="/Public/admin/styles/general.css" rel="stylesheet" type="text/css" />
<link href="/Public/admin/styles/main.css" rel="stylesheet" type="text/css" />
</head>
<body>

<h1>
<span class="action-span"><a href="/admin.php/Admin/Goods/add">添加新商品</a></span>
<span class="action-span1"><a href="#">ECSHOP 管理中心</a> </span><span id="search_id" class="action-span1"> - 商品列表 </span>
<div style="clear:both"></div>
</h1>

<div class="form-div">


</div>
<form method="post" action="" name="listForm" >

  <div class="list-div" id="listDiv">
<table cellpadding="3" cellspacing="1">
  <tr>
    <th>
      <input onclick='listTable.selectAll(this, "checkboxes")' type="checkbox" />
      <a href="#">编号</a><img src="/Public/admin/images/sort_desc.gif"/>    </th>

    <th><a href="#">商品名称</a></th>
    <th><a href="#">货号</a></th>
    <th><a href="#">价格</a></th>
    <th><a href="#">上架</a></th>
    <th><a href="#">精品</a></th>
    <th><a href="#">新品</a></th>

    <th><a href="#">热销</a></th>
    <th><a href="#">推荐排序</a></th>
        <th><a href="#">库存</a></th>
        <th>操作</th>
  </tr>
  <?php foreach($goodsdata as $v){?>
      <tr>
    <td><input type="checkbox" name="checkboxes[]" value="32" /><?php echo $v['id']?></td>

    <td class="first-cell" style=""><span ><?php echo $v['goods_name']?></span></td>
    <td><span ><?php echo $v['goods_sn']?></span></td>
    <td align="right"><span ><?php echo $v['shop_price']?>
    </span></td>
    <td align="center"><img src="/Public/admin/images/<?PHP echo $v['is_sale']==1?'yes':'no'?>.gif"  /></td>
    <td align="center"><img src="/Public/admin/images/<?PHP echo $v['is_best']==1?'yes':'no'?>.gif"  /></td>
    <td align="center"><img src="/Public/admin/images/<?PHP echo $v['is_new']==1?'yes':'no'?>.gif"  /></td>
    <td align="center"><img src="/Public/admin/images/<?PHP echo $v['is_hot']==1?'yes':'no'?>.gif"  /></td>

    <td align="center"><span >100</span></td>
        <td align="right"><span ><?php echo $v['goods_number']?></span></td>
        <td align="center">
      <a href="#" target="_blank" title="查看"><img src="/Public/admin/images/icon_view.gif" width="16" height="16" border="0" /></a>
      <a href="#" title="编辑"><img src="/Public/admin/images/icon_edit.gif" width="16" height="16" border="0" /></a>
      <a href="#" title="复制"><img src="/Public/admin/images/icon_copy.gif" width="16" height="16" border="0" /></a>
      <a href="#"  title="回收站"><img src="/Public/admin/images/icon_trash.gif" width="16" height="16" border="0" /></a>
      <a href="/admin.php/Admin/Goods/product/goods_id/<?php echo $v['id']?>" title="货品列表"><img src="/Public/admin/images/icon_docs.gif" width="16" height="16" border="0" /></a>          </td>
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