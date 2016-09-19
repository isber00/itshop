<?php
namespace Home\Controller;
class UserController extends IndexController {
    public function register(){
        $catemodel = D('Admin/Category');
        //取出头部导航信息
        $this->nvdata  = $catemodel->getNav();
        if(IS_POST){
             $usermodel = D('User');
             if($usermodel->create()){
                    // 给密码加密
                    $usermodel->password = md5(md5(I('post.password')).C('MD5_KEY'));
                    if($usermodel->add()){
                            //注册成功、
                         $this->success('注册成功',U('Home/Index/index'));
                         exit;
                    }else{
                        //注册失败
                        $this->error('注册失败');
                    }
             }else{
               $this->error($usermodel->getError());
             }
        }
        $this->display();
    }

    //完成用户登录
    public function login(){
        $catemodel = D('Admin/Category');
        //取出头部导航信息
        $this->nvdata  = $catemodel->getNav();
        if(IS_POST){
            $usermodel = D('User');
            if($usermodel->login()){
                    //登录成功,调用把cookie里面的数据，移动到数据库里面。
                    $cartmodel = D('Cart');
                    $cartmodel->cookitodb();
                    $url = $_SESSION['returnurl'];
                    if(empty($url)){
                        $mubiao =U('Home/Index/index');
                    }else{
                        $mubiao = $url;
                    }
                    $this->success('登录成功',$mubiao);
                         exit;
            }else{
                //登录失败
                 $this->error('登录失败');
            }
        }
        $this->display();
    }

    public function logout(){
        if($_SESSION['user_id']>0){
                $_SESSION['user_id']=null;
                $_SESSION['username']=null;
        }
        $this->success('退出成功',U('Home/Index/index'));
    }
}

?>