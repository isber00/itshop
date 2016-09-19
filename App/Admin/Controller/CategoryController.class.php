<?php
namespace Admin\Controller;
use Think\Controller;
class CategoryController extends Controller{
    public function add(){
        $catemodel = D('Category');
        if(IS_POST){
            if($catemodel->create(I('post.'),1)){
                
                        if($catemodel->add()){
                            $this->success("添加栏目成功",U('lst'));
                            exit;
                        }else{
                            $this->error('添加栏目失败');
                        }
                }else{
                    $this->error($catemodel->getError());
                }
        }
        //取出栏目数据
        $this->catedata = $catemodel->getTree();
        $this->display();
    }
    //栏目列表
    public function lst(){
         //取出栏目数据
        $catemodel = D('Category');
        $this->catedata = $catemodel->getTree();
        $this->display();
    }
}
?>