<?php
namespace Admin\Model;
use Think\Model;
class CategoryModel extends Model{
    protected $_validate=array(
        array('cat_name','require','栏目名称不能为空')    
    );
    public function getTree(){
        $arr = $this->select();
      return   $this->_getTree($arr);
    }
    public function _getTree($arr,$parent_id=0,$lev=0){
        static $list=array();
        foreach($arr as $v){
            if($v['parent_id']==$parent_id){
                    $v['lev']=$lev;
                    $list[]=$v;
                    $this->_getTree($arr,$v['id'],$lev+1);
            }
        }
        return $list;
    }

    //定义一个方法，用于取出导航栏
    public function getNav(){
        return $this->where("parent_id=0")->select();
    }

    //定义一个函数，用于找出当前栏目的子栏目；
     //$cat_id是栏目的id
    public function getChild($cat_id){
        $arr = $this->select();//取出所有的栏目数据
        return $this->_getChild($arr,$cat_id);
    }

    public function _getChild($arr,$cat_id){
          static $ids =array();
          foreach($arr as $v){
            if($v['parent_id']==$cat_id){
                    $ids[]=$v['id'];
                    $this->_getChild($arr,$v['id']);
            }
          }
          return $ids;
    }
    //查找家谱树
   //参数：要传递一个栏目的id,
   //根据栏目的id查找，上级栏目，
    public function getFamily($cat_id){
        $arr = $this->select();
        return array_reverse($this->_getFamily($arr,$cat_id));
    }
    public function _getFamily($arr,$cat_id){
        static $list=array();//定义一个静态数组，用于存储找到的栏目数据
        foreach($arr as $v){
                if($v['id']==$cat_id){
                        //找到了
                        $list[]=$v;
                        //递归查找
                        $this->_getFamily($arr,$v['parent_id']);
                }
        }
        return $list;
    }
}
?>