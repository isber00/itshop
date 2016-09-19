<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {
   public function __construct(){
            parent::__construct();
            
            //判断是否登陆
            if($_SESSION['user_id']>0){
                    return true;
            }
          //var_dump($_COOKIE['user_id']);
            //没有登录，则查看cookie是否有值。     
              if (!empty($_COOKIE['user_id']) && !empty($_COOKIE['password'])){ 
                  $id = $_COOKIE['user_id'];
                        $sql="select username,password from it_user where id=$id";
                        $usermodel = D('User');
                        $userinfo = $usermodel->where('id='.$id)->find();
                        if($userinfo){
                            //验证密码是否正常
                            $pass=$_COOKIE['password'];
                            if($pass==md5(($userinfo['password']).C('COOKIE_KEY'))){
                                        //正常，
                                        //把用户的信息存储到 session里面
                                         $_SESSION['user_id']=$userinfo['id'];
                                         $_SESSION['username']=$userinfo['username'];
                            }else{
                                    //把cookie给清空
                                  setcookie('user_id','',time()-1,'/');
                                  setcookie('password','',time()-1,'/');
                            }
                        }
              }


    }
    //首页数据
    public function index(){
        $catemodel = D('Admin/Category');
        $this->nvdata  = $catemodel->getNav();
        $this->catedata  = $catemodel->getTree();
        $goodsmodel = D('Admin/Goods');
        $this->bestdata = $goodsmodel->getTypedata('is_best',3);
        $this->newdata = $goodsmodel->getTypedata('is_new',3);
        $this->hotdata = $goodsmodel->getTypedata('is_hot',3);
        //取出购物车数据：
            $cartmodel = D('Cart');
            $this->total=$cartmodel->getTotal();
       //p($bestdata);exit;
        $this->display();
    }
    //取出栏目页面的数据
     public function category(){
          $catemodel = D('Admin/Category');
          $this->nvdata  = $catemodel->getNav();
          $this->catedata  = $catemodel->getTree();
          //取出购物车数据：
            $cartmodel = D('Cart');
            $this->total=$cartmodel->getTotal();
            //接收传递的栏目的id
            $cat_id = (int)$_GET['id'];
            //取出栏目表里面的最大的 id
            $max_cat_id = $catemodel->field("max(id) max_id")->find();        
            if($cat_id<=0 || $cat_id>$max_cat_id['max_id']){
                    $web_url = C('WEB_URL');
                   header("location:$web_url");
            }
            //要找出当前栏目是否有子栏目，找出子栏目后，使用goods表里面  条件：cat_id in(栏目的id)
            $catemodel = D('Admin/Category');
            $ids = $catemodel->getChild($cat_id);
            //判断是否有子栏目，如果没有子栏目则说明该栏目就是子栏目，
            if(empty($ids)){
                    $ids[]=$cat_id;//如果没有子栏目则说明该栏目就是子栏目，把自己的id添加到数组里面
            }
            //根据栏目的id取出商品的数据
            $goodsmodel = D('Admin/Goods');
            $id = implode(',',$ids);//把一个数组转成一个用逗号隔开的字符串
            $where="cat_id in($id)";

            $goodsdata = $goodsmodel->where($where)->select();
            /*//如果取出的数据为空，,并且传递 栏目id大于category表里面的最大的id,则跳转到首页
            if(empty($goodsdata)){
                   $web_url = C('WEB_URL');
                   header("location:$web_url");
            }*/
            $this->goodsdata=$goodsdata;
             $catenvdata = $catemodel->getFamily($cat_id); 
             $this->assign('catenvdata', $catenvdata);
            $this->display();

     }
     //取出商品详情页面的数据
     public function detail(){
         $catemodel = D('Admin/Category');
          $this->nvdata  = $catemodel->getNav();
          $this->catedata  = $catemodel->getTree();
          //取出购物车数据：
            $cartmodel = D('Cart');
            $this->total=$cartmodel->getTotal();
        //接收传递过来的商品的id,根据商品的id取出商品的详情数据
        $goods_id = (int)$_GET['id'];
        if($goods_id<=0){
                //说明传递goods_id不合法，就跳转到首页。
                 $web_url = C('WEB_URL');
                  header("location:$web_url");
        }
        //要取出商品的详情数据
        $goodsmodel = D('Goods');
        $goods_info = $goodsmodel ->find($goods_id);
        $this->goods_info =$goods_info;
      
        //取出当前商品的属性：
        $goodsattrmodel = M('GoodsAttr');
        $attrdata = $goodsattrmodel->field("a.id,a.attr_id,a.attr_value,b.attr_name,b.attr_type")->join("a left join it_attribute b on a.attr_id=b.id")->where("goods_id=".$goods_id)->select();
        //根据数据分割出单选属性 
        $radioattr = array();//定义一个数组用于存储商品的单选属性。
       foreach($attrdata as $v){
                if($v['attr_type']==1){
                        // 如果是单选属性
                        $radioattr[$v['attr_id']][]=$v;
                }
       } 
       //查找出当前商品所属的栏目导航
        $catenvdata = $catemodel->getFamily($goods_info['cat_id']); 
        $this->assign('catenvdata', $catenvdata);
       $this->assign('radioattr',$radioattr);
       
        $this->display();
     }

     public function demo(){
            $catemodel = D('Admin/Category');
            //$data = $catemodel->select($goods_info['cat_id']);
            p($data);
     }
}