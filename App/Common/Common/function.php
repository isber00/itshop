<?php
function p($a){
    echo "<pre>";
    print_r($a);
    echo '</pre>';
}
//定义一个上传 文件的函数
//参数1： $savepath是指定上传的子目录
//参数2：指定上传的表单域里面的名称
//参数3：指定要生成缩略图，生成几张缩略图，还要指定缩略图的尺寸。 定义一个二维数组，用于决定生成缩略图的个数和尺寸。
/*
参数如下：
$array=array(
    array(230,230),
    array(100,100)
)
*/

function uploadimgfile($savepath,$filename,$array=array()){
        $upload = new \Think\Upload();// 实例化上传类    
           //如何获取配置文件里面的值。
           $rootPath = C('UPLOAD_ROOT_PATH');//大C函数是获取配置文件里面值
           $exts = C('ALLOW_FILE_EXTS');//获取上传文件的扩展名
           $upload_max_filesize= (int)ini_get('upload_max_filesize'); //获取php.ini 文件里面配置项值
           $upload_max_file=(int)C('UPLOAD_MAX_FILE');//获取配置文件里面设置的上传文件的大小
           $maxSize = min($upload_max_filesize,$upload_max_file);
           $maxSize=$maxSize*1024*1024;
           $upload->maxSize   =    $maxSize;// 设置附件上传大小    
           $upload->exts      = $exts;// 设置附件上传类型   
           $upload->rootPath=$rootPath;//指定上传文件的根路径。
           $upload->savePath  =      $savepath.'/'; // 设置附件上传文件子路径    // 上传文件     
           $info   =   $upload->upload(); 
           if($info){
                //上传成功，如果上传成功返回原图和缩略图的路径。
                $img[0]= $info[$filename]['savepath'].$info[$filename]['savename'];//生成的原图的路径
                //判断是否生成缩略图，
                if($array){
                        // 要生成缩略图
                        foreach($array as $k=>$v){
                            $image = new \Think\Image(); 
                            $image->open($rootPath.$img[0]);//
                            //定义生成缩略图的名称
                            $thumb=$info[$filename]['savepath'].'thumb_'.$k.$info[$filename]['savename'];
                            $image->thumb($v[0],$v[1])->save($rootPath.$thumb);
                            //把生成的缩略图地址存储到$img数组里面
                            $img[]=$thumb;
                        }
                }
            //要返回原图路径和缩略图路径。
            return array(
                    'info'=>1,
                    'images'=>$img
            );

           }else{
               //上传失败，如果上传失败，要返回的数据是失败的原因和假
                 return array(
                    'info'=>0,
                    'error'=>$upload->getError()
            );

           }



}
?>