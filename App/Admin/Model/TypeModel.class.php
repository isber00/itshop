<?php
namespace Admin\Model;
use Think\Model;
class TypeModel extends Model{
    protected $insertFields=array('type_name');//定义提交的字段
    protected $_validate=array(
        array('type_name','require','商品类型不能为空')    
    );
}


?>