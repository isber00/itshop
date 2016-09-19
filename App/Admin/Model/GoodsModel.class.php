<?php
namespace Admin\Model;
use Think\Model;
class GoodsModel extends Model{
        //protected $insertFields=array();
        public  function _before_insert(&$data,$options){
            //判断是否已经提交货号
            $goods_sn = I('goods_sn');
            if(empty($goods_sn)){
                     $data['goods_sn']=strtoupper('sn_'.uniqid());
            }
            $data['add_time']=time();
           $res = uploadimgfile('Goods','goods_img',$array=array(array(230,230),array(100,100)));
           if($res['info']==0){
                //失败
                $this->error=$res['error'];
           }else{
                $data['goods_ori']=$res['images'][0];
                $data['goods_img']=$res['images'][1];
                $data['goods_thumb']=$res['images'][2];
           }
        }

        public function _after_insert($data,$options){
            //得到 goods_id
            $goods_id = $data['id'];
            //接收属性的数据，
            $attrs = I("post.attr");
           //开始入库
           foreach($attrs as $k=>$v){
                    if(is_array($v)){
                                //$v是一个数组
                                foreach($v as $v1){
                                        M("GoodsAttr")->add(array(
                                                'goods_id'=>$goods_id,
                                                'attr_id'=>$k,
                                                'attr_value'=>$v1
                                        ));
                                }
                    }else{
                        //$v不是一个数组
                         M("GoodsAttr")->add(array(
                                                'goods_id'=>$goods_id,
                                                'attr_id'=>$k,
                                                'attr_value'=>$v
                      ));
                    }
           }
        }

        public function getRadioAttr($goods_id){
            $sql="select a.*,b.attr_name from it_goods_attr a left join it_attribute b on b.id=a.attr_id where attr_id in(select attr_id from it_goods_attr where goods_id=$goods_id group by attr_id having count(*)>1)";
            return $this->query($sql);
        }
        //获取精品和热卖和新品
        //参数$type是类型，该类型只能是is_best is_new is_hot
        //$number是取出数据的数量
        public function getTypedata($type,$number){
            if($type=='is_best'|| $type=='is_new'||$type=='is_hot'){
                        //开始取出数据
                      return   $this->field("goods_name,goods_thumb,shop_price,id")->where("$type=1 and is_delete=0 and is_sale=1")->order("id desc")->limit($number)->select();
            }else{
                    return false;
                    
            }
        }
}
?>