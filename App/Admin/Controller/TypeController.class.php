<?php
namespace Admin\Controller;
use Think\Controller;
class TypeController extends Controller{
    public function add(){
        if(IS_POST){
                $typemodel = D('Type');
                if($typemodel->create(I('post.'),1)){
                        if($typemodel->add()){
                            $this->success("添加商品类型成功",U('lst'));
                            exit;
                        }else{
                            $this->error('添加商品类型失败');
                        }
                }else{
                    $this->error($typemodel->getError());
                }
        }
        $this->display();
    }
    //商品类型列表
     public function lst(){
         //取出商品类型数据
        $typemodel = D('Type');
        $this->typedata = $typemodel->field("a.id,a.type_name,count(b.id) attr_count")->join("a left join it_attribute b on a.id=b.type_id")->group("a.id")->select();
        $this->display();
     }
}

?>