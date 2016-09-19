<?php
namespace Admin\Controller;
use Think\Controller;
class AttributeController extends Controller{
    public function add(){
        if(IS_POST){
            $attrmodel = D('Attribute');
            if($attrmodel->create(I('post.'),1)){
                $type_id = I('post.type_id');
                        if($attrmodel->add()){
                            $this->success("添加属性成功",U('lst',array('type_id'=>$type_id)));
                            exit;
                        }else{
                            $this->error('添加属性失败');
                        }
                }else{
                    $this->error($attrmodel->getError());
                }
        }
        //接收传递过来的商品类型的id
        $type_id=(int)$_GET['type_id'];
        $this->type_id=$type_id;
        //取出商品类型数据
        $typemodel = D('Type');
        $this->typedata = $typemodel->select();
        $this->display();
    }
    public function lst(){
        //要接收传递过来的商品类型的id
        $type_id = (int)$_GET['type_id'];
        //取出属性内容，
        $attrmodel = D('Attribute');
        $this->attrdata = $attrmodel->getAttr($type_id);
        //显示出所有的商品类型
        $typemodel = D('Type');
        $this->typedata = $typemodel->select();
        $this->type_id=$type_id;
        $this->display();
    }

    public function showattr(){
        $type_id = (int)$_GET['type_id'];
            //取出属性内容，
        $attrmodel = D('Attribute');
        $this->attrdata = $attrmodel->getAttr($type_id);
        $this->display();
    }

}

?>