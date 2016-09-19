<?php
namespace Home\Model;
use Think\Model;
class CartModel extends Model{
    //添加到购物车的一个方法
    //参数：$goods_id,$goods_attr_id,$goods_number
     public function addCart($goods_id,$goods_attr_id,$goods_number){
         //判断用户是否登录
         $user_id = $_SESSION['user_id'];
         if($user_id>0){
                //已经登录，数据存储到数据库里面。
                 //在存储之前，要判断当前购物车表里面是否已经存在该商品
                 $row = $this->where("goods_id=$goods_id and goods_attr_id='$goods_attr_id' and user_id=$user_id")->find();
                 if($row){
                        //说明该商品已经存储在购物车数据表里面，修改购买数量即可。
                           $this->where("goods_id=$goods_id and goods_attr_id='$goods_attr_id' and user_id=$user_id")->setInc('goods_number',$goods_number); 
                 }else{
                    //该商品没有存储到购物车数据表里面，添加数据即可
                        $this->add(array(
                                'goods_id'=>$goods_id,
                                'goods_attr_id'=>$goods_attr_id,
                                'goods_number'=>$goods_number,
                                'user_id'=>$user_id
                        ));
                 }
         }else{
            //没有登录，数据存储到cookie里面
            //从cookie里面取出数据
            $cartdata = isset($_COOKIE['cart'])?unserialize($_COOKIE['cart']):array();
            //判断 $cartdata数组里面是否已经存储当前商品。
            $key = $goods_id.'-'.$goods_attr_id;
            if(isset($cartdata[$key])){
                //当前商品已经存储到cookie里面了，
                $cartdata[$key]=$cartdata[$key]+$goods_number;
            }else{
                //添加新商品了。
                $cartdata[$key]=$goods_number;
            }
            //把cartdata数组，给序列化后，存储到cookie里面
            setcookie('cart',serialize($cartdata),time()+7*24*3600,'/');
         }
     }

     //购物车列表
     public function cartList(){
            //判断是否登录，如果登录则从数据库里面取出数据，如果没有登录则从 cookie里面里面取出数据
             $user_id = $_SESSION['user_id'];
             if($user_id>0){
                        //已经登录，查询的条件是：user_id
                        $cartdata = $this->where("user_id=$user_id")->select();
             }else{
                //没有登陆
                $data = unserialize($_COOKIE['cart']);//取出cookie购物车数据
                //要把取出的购物车数据（一维数组）转换成二维数组
                //array('12-23,45'=>123,'34-67,89'=>100)
                $cartdata=array();//
                foreach($data as $k=>$v){
                        $arr = explode('-',$k);
                        $cartdata[]=array(
                            'goods_id'=>$arr[0],
                            'goods_attr_id'=>$arr[1],
                            'goods_number'=>$v
                        );
                }     
             }
             //要取出商品的详情信息（名称，图片，价格）
             $list=array();
            foreach($cartdata as $v){
                        //获取商品的详情信息。
                        $v['info']=M('Goods')->field("goods_name,shop_price,goods_thumb")->find($v['goods_id']);
                        //获取商品的属性信息。
                        $v['attr']=$this->arrtostring($v['goods_attr_id']);
                        $list[]=$v;
            }
            return $list;
     }
     //完成,数组数据到字符串的转换
     public function arrtostring($goods_attr_id){
                $data = M('GoodsAttr')->field("group_concat(concat(b.attr_name,':',a.attr_value) separator '<br/>') as string")->join("a left join  it_attribute b on a.attr_id=b.id")->where("a.id in($goods_attr_id)")->find();
                return $data['string'];
               // p($data);exit;

     }
     //计算总价和总数量
     public function getTotal(){
        //返回一个数组，该数组里面有购买数量和总价
        //（1）取出购物车里面的数据
        $cartdata = $this->cartList();
        $total_price=0;//价格
        $total_number=0;//购买数量
        foreach($cartdata as $v){
                $total_number+=$v['goods_number'];
                $total_price +=($v['info']['shop_price']*$v['goods_number']);
        }
        return array('total_price'=>$total_price,'total_number'=>$total_number);
     }

     //修改购物车的方法：
     //$goods_id商品的id$goods_attr_id商品属性的id,$goods_number购买数量
     public function updateCart($goods_id,$goods_attr_id,$goods_number){
                //要判断用户是否登录，如果登录则在修改数据库，如果没有登录，则修改cookie
                  $user_id = $_SESSION['user_id'];
             if($user_id>0){
                        //已经登录，修改数据库
                         $this->where("goods_id=$goods_id and goods_attr_id='$goods_attr_id' and user_id=$user_id")->setInc('goods_number',$goods_number);    
             }else{
                    //修改cookie
                    $cartdata = isset($_COOKIE['cart'])?unserialize($_COOKIE['cart']):array();
                    //构造key
                    //array('商品的id'-'属性的id'==> 购买数量)
                      $key = $goods_id.'-'.$goods_attr_id;
                      $cartdata[$key]+=$goods_number;
                     //把cartdata数组，给序列化后，存储到cookie里面
                    setcookie('cart',serialize($cartdata),time()+7*24*3600,'/'); 
             }
     }

     //删除购物车里面商品
     public function delCart($goods_id,$goods_attr_id){
         $user_id = $_SESSION['user_id'];
         if($user_id>0){
                //从数据库里面删除
                $this->where("goods_id=$goods_id and goods_attr_id='$goods_attr_id' and user_id=$user_id")->delete();
         }else{
            //从cookie里面删除
            $cartdata = isset($_COOKIE['cart'])?unserialize($_COOKIE['cart']):array();
            //构造键
            $key  = $goods_id.'-'.$goods_attr_id;
            unset($cartdata[$key]);
            setcookie('cart',serialize($cartdata),time()+7*24*3600,'/'); 
         }
        
     }
     //从cookie里面移动购物车数据
      public function cookitodb(){
                //从cookie里面取出数据
                 $cartdata = isset($_COOKIE['cart'])?unserialize($_COOKIE['cart']):array();
                 if(empty($cartdata)){
                        return false;
                 }
                 $user_id = $_SESSION['user_id'];
                foreach($cartdata as $k=>$v){
                    //要判断购物车数据表里面是否有该商品，如果有则更新数量，如果没有则是添加。
                     $arr = explode('-',$k);
                     $goods_id = $arr[0];
                     $goods_attr_id = $arr[1];
                     $goods_number=$v;
                     $has = $this->where("goods_id=$goods_id and goods_attr_id='$goods_attr_id' and user_id=$user_id")->find();     
                     if($has){
                        //要修改数据库表
                        $this->where("goods_id=$goods_id and goods_attr_id='$goods_attr_id' and user_id=$user_id")->setInc('goods_number',$goods_number);
                     }else{
                         //要添加数据库
                            $this->add(array(
                                'goods_id'=>$arr[0],
                                'goods_number'=>$v,
                                'goods_attr_id'=>$arr[1],
                                'user_id'=>$user_id
                            )); 
                   }
                }
                //要清除cookie
                setcookie('cart','',time()-1,'/'); 
      }

      //清空购物车数据
      public function clearCart(){
                    $user_id = $_SESSION['user_id'];
                    $this->where("user_id=$user_id")->delete();
      }
}
?>