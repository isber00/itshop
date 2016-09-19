<?php
namespace Home\Controller;
use Think\Controller;
class OrderController extends Controller{
    public function order(){
                //验证用户是否登录， 如果用户没有登录，则跳转到登录页面，登录成功后，再调回到下订单页面。
                $user_id = $_SESSION['user_id'];
                if(!$user_id){
                        //没有登录，则跳转到登录页面。思路：把跳回的地址，存储起来，（使用session来存储）
                        $returnurl=U('Home/Order/order');
                        $_SESSION['returnurl']=$returnurl;
                        $this->redirect('User/login');
                }
                //验证购物车里面是否为空
                $cartmodel = D('Cart');
                $total = $cartmodel->getTotal();
                if(empty($total['total_number'])){
                            //购物车没有商品，无法下订单
                            $this->error('购物车里面没有商品，请赶紧选购');
                }
                //验证是否填写收货人的信息。
                //根据user_id把收货人的信息给取出来
                $addressinfo =  M('Address')->where("user_id=$user_id")->find();
                if(empty($addressinfo)){
                        //如果为空，表示没有添加收货人的信息，则跳转到填写收货人的页面
                       $this->redirect('writeaddress');
                }
                //取出购物车列表信息
                $this->cartdata = $cartmodel->cartList();
                $catemodel = D('Admin/Category');
                $this->nvdata  = $catemodel->getNav();
                $this->assign('info',$addressinfo);
                $this->assign('total',$total);
                $this->display();
    
    }
    //填写收货人的信息的。
    public function writeaddress(){
        $catemodel = D('Admin/Category');
        $this->nvdata  = $catemodel->getNav();
        if(IS_POST){
                //接收填写的收货人信息，入库。
                $user_id = $_SESSION['user_id'];
                $consignee=I('post.consignee');
                $tel =I('post.tel');
                $mobile = I('post.mobile');
                $address = I('post.address');
                $post=I('post.post');
                M("Address")->add(array(
                    'user_id'=>$user_id,
                    'consignee'=>$consignee,
                    'tel'=>$tel,
                    'mobile'=>$mobile,
                    'address'=>$address,
                    'post'=>$post
                ));
            $this->redirect('order');
        }
        $this->display();
    }
    //订单信息入库
    public function done(){
        if(IS_POST){
                 $catemodel = D('Admin/Category');
                $this->nvdata  = $catemodel->getNav();
                $cartmodel = D('Cart');
                $total = $cartmodel->getTotal();
                //接收提交的信息
                   $user_id = $_SESSION['user_id'];
                   $order_sn = 'sn_'.uniqid();
                   $total_price=$total['total_price'];
                   $consignee=I('post.consignee');
                   $address = I('post.address');
                   $mobile = I('post.mobile');
                   $shipping=I('post.shipping');
                   $payment = I('post.payment');
                   //入库it_order表：
         $order_id =  M('Order')->add(array(
                        'user_id'=>$user_id,
                        'order_sn'=>$order_sn,
                        'total_price'=>$total_price,
                        'consignee'=>$consignee,
                       'address'=>$address,
                       'mobile'=>$mobile,
                       'shipping'=>$shipping,
                       'payment'=>$payment
                   ));
                //入库it_order_goods表：
                 $cartdata = $cartmodel->cartList();
                 foreach($cartdata as $v){
                        M('OrderGoods')->add(array(
                                'order_id'=>$order_id,
                                'goods_id'=>$v['goods_id'],
                                'goods_attr_id'=>$v['goods_attr_id'],
                                'goods_number'=>$v['goods_number'],
                                'goods_price'=>$v['info']['shop_price']
                        ));
                 }
                 //要清空购物车数据
                $cartmodel->clearCart();
                $this->assign('order_sn',$order_sn);
                $this->display();
        
        }
            

           
    }
}

?>