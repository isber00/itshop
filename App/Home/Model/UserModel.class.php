<?php
namespace Home\Model;
use Think\Model;
class UserModel extends Model{
    protected $_validate=array(
        array('username','require','用户名不能为空'),    
        array('username','checkusername','用户名有不合法字符',1,'callback'),    
        array('username','','用户名已经存在',1,'unique'),
        array('password','require','密码不能为空'),    
        array('password','6,12','密码长度要在6到12位',1,'length'),    
        array('rpassword','password','两次密码不一致',1,'confirm'),
        array('email','require','邮箱不能为空'), 
        array('email','email','邮箱格式不合法'), 
    );
    protected function checkusername($username){
        //使用该函数进行验证是否有非法的字符。
        //假如我们就排除  @  .   不合法，其他的都合法
        if(strpos($username,'.')!==false || strpos($username,'@')!==false){
                    return false;
        }
        return true;
    }

    //定义一个登录的方法：
    public function login(){
        //接收传递的用户名和密码
        $username = I('post.username');
        $password = I('post.password');
        $remember=I('post.remember');
        //根据用户名查找出密码，然后和输入的密码进行匹配
        $where['username']=array('eq',$username);
       $userinfo = $this->where($where)->find();//返回的是一维数组
       if($userinfo){
            //查出数据 
            // 验证输入的民是否正确
            if($userinfo['password']==md5(md5($password).C('MD5_KEY'))){
                            //用户名和密码都正确
                            if($remember==1){
                                    //要把用户的信息记录到cookie里面，记录时间比如一周
                                    $passwd = md5(($userinfo['password']).C('COOKIE_KEY'));
                                    //存储的用户的id,
                                    $times = time()+24*7*3600;
                                    setcookie('user_id',$userinfo['id'],$times,'/');
                                    //echo 'a';exit;
                                    setcookie('password',$passwd,$times,'/');
                            }
                            //把用户名保存到session里面
                            $_SESSION['user_id']=$userinfo['id'];
                            $_SESSION['username']=$username;
                            return true;
            }

            return false;

       }
        

    }
}
?>