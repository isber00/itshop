<?php
namespace Admin\Controller;
use Think\Controller;
class GoodsController extends Controller{
    public function add(){
        if(IS_POST){
           // echo "<pre>";
            ///print_r($_POST);exit;
            $goodsmodel = D('Goods');
            if($goodsmodel->create(I('post.'),1)){
                    if($goodsmodel->add()){
                            $this->success("添加商品成功",U('lst'));
                            exit;
                    }
            }
            $error = $goodsmodel->getError();//获取到模型里面的 $this->error的值
            if(empty($error)){
               $error='添加商品失败'; 
            }
            $this->error($error);
        }
        //取出商品栏目信息
        $catemodel = D('Category');
        $this->catedata = $catemodel->getTree();
        //取出商品类型
        $typemodel = D('Type');
        $this->typedata = $typemodel->select();
        $this->display();
    }
    public function demo(){
        nihao();
    }
    public function lst(){
        $goodsmodel = D('Goods');
        $this->goodsdata = $goodsmodel->select();
        $this->display();
    }
    public function showattr(){
        //接收传递的type_id
        $type_id = (int)$_GET['type_id'];
        $attrmodel = D('Attribute');
        $attrdata = $attrmodel->getAttr($type_id);
        $this->assign('attrdata',$attrdata);
        $this->display();
    }

    public function product(){
        if(IS_POST){
            $goods_attr= I("post.goods_attr");
            $goods_number = I('post.goods_number');
            foreach($goods_number as $k=>$v){
                $attr1=array();
                    foreach($goods_attr as $k1=>$v1){
                            if(empty($v1[$k])){
                                    continue;
                            }
                            $attr1[]=$v1[$k];
                    }
                   
            }
            
        }
        $goods_id = (int)$_GET['goods_id'];
        $goodsmodel = D('Goods');
        $attrs = $goodsmodel->getRadioAttr($goods_id);
        $arr=array();
        foreach($attrs as $v){
                $arr[$v['attr_id']][]=$v;
        }
       // p($arr);exit;
       $this->assign('goods_id',$goods_id);
       $this->assign('attr',$arr);
       $this->display();
    }
}
?>