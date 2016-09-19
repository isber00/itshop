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
function copybutton(o){
    var trs = $(o).parent().parent();
    if($(o).val()=='+'){
        var new_trs = trs.clone();
        new_trs.find(":button").val('-');
        trs.before(new_trs);
    }else{
        trs.remove();
    }
}

</script>
</head>
<body>

<h1>
<span class="action-span"><a href="/index.php/Admin/Goods/add">添加新商品</a></span>
<span class="action-span1"><a href="#">ECSHOP 管理中心</a> </span><span id="search_id" class="action-span1"> - 商品列表 </span>
<div style="clear:both"></div>
</h1>

<div class="form-div">


</div>
<form method="post" action="" name="listForm" >

  <div class="list-div" id="listDiv">
<table cellpadding="3" cellspacing="1">
  <tr>
        <?php foreach($attr as $v){?>
        <th><?php echo $v[0]['attr_name']?></th>
        <?php } ?>
        <th>库存</a></th>
        <th>操作</th>
  </tr>
  <tr>
        <?php foreach($attr as $k=>$v){?>
        <td>
        <select name="goods_attr[<?php echo $attr[$k][0]['attr_id'];?>][]">
                    <option value="">请选择</option>
                    <?php foreach($v as $v1){?>
                                <option value="<?php echo $v1['id']?>"><?php echo $v1['attr_value']?></option>
                    <?php }?>
        </select>
        </td>
        <?php } ?>
        <td><input type="text" name="goods_number[]"/></td>
        <td><input type="button" value="+" onclick="copybutton(this)"/></td>
  </tr>
  <tr align="center"><td  colspan="<?php echo (count($attr)+2);?>"><input type="submit" value="保存"/></td></tr>
</table>

<table id="page-table" cellspacing="0">
  <tr>
   <td align="right" nowrap="true">
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