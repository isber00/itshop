<?php
namespace Home\Controller;
class CartController extends IndexController {
    public function addCart(){
       $goods_id = (int)$_POST['goods_id'];
       $goods_number = (int)$_POST['goods_number'];
       $goods_attr_id='';
       if(count($_POST)>2){
           //有属性
            unset($_POST['goods_number']);
            unset($_POST['goods_id']);
            $goods_attr_id= implode(',',$_POST);

        }
        //添加到购物车
        $cartmodel = D('Cart');
        $cartmodel->addCart($goods_id,$goods_attr_id,$goods_number);
        $this->success('添加购物车成功',U('cartList'));
    }
    public function cartList(){
        $catemodel = D('Admin/Category');
        $this->nvdata  = $catemodel->getNav();
        $cartmodel = D('Cart');
        $cartdata = $cartmodel->cartList();
        $this->cartdata=$cartdata;
        //取出购物车数据：
          
        $this->total=$cartmodel->getTotal();
        $this->display();
    }

    //添加有一个函数用于修改购物车数据：
     public function updateCart(){
            //接收传递过来的goods_id
            $goods_id = (int)$_GET['goods_id'];
            $goods_attr_id = $_GET['goods_attr_id'];
            $cartmodel = D('Cart');
            $cartmodel->updateCart($goods_id,$goods_attr_id,1);
            echo 'ok';
     }
     //删除购物车数据的一个方法：
     public function delCart(){
           //接收传递过来的goods_id
            $goods_id = (int)$_GET['goods_id'];
            $goods_attr_id = $_GET['goods_attr_id'];
            $cartmodel = D('Cart');
            $cartmodel->delCart($goods_id,$goods_attr_id);
            //删除完毕
            $this->redirect('cartList');
     }
}

?>