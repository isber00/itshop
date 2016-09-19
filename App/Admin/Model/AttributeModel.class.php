<?php
namespace Admin\Model;
use Think\Model;
class AttributeModel extends Model{
    protected $_validate=array(
        array('attr_name','require','属性名称不能为空'),
        array('type_id','number','商品类型必须是数字'),
         array('attr_type','require','必须选择属性类型'),
        #验证属性类型的值只能是0或1
        array('attr_type',array(0,1),'属性值不合法',1,'in'),
        array('attr_input_type','require','必须选择属性输入方式'),
        array('attr_input_type',array(0,1),'录入方式不合法',1,'in'),
    );
   //根据商品类型的id 取出属性数据
   public function getAttr($type_id){
       if(empty($type_id)){
                $where='';
       }else{
                $where['type_id']=array('eq',$type_id);
       }   
        $data = $this->field("a.*,b.type_name")->join("a left join it_type b on a.type_id=b.id")->where($where)->select();
        return $data;
   }
}

?>