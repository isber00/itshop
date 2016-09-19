<?php
return array(
	//'配置项'=>'配置值'
    'DB_TYPE'   => 'mysql', // 数据库类型
        'DB_HOST'   => 'localhost', // 服务器地址
        'DB_NAME'   => 'itshop', // 数据库名
        'DB_USER'   => 'root', // 用户名
        'DB_PWD'    => 'root', // 密码
        'DB_PORT'   => 3306, // 端口
        'DB_PREFIX' => 'it_', // 数据库表前缀 
        'UPLOAD_ROOT_PATH'=>'./Public/Uploads/',//配置上传文件的根路径
        'ALLOW_FILE_EXTS'=>array('jpg','png', 'jpeg'),//配置允许上传的扩展名称
        'UPLOAD_MAX_FILE'=>'3M',//  配置上传单个文件的最大值
        'WEB_URL'=>'http://www.itshop.com',
        'MD5_KEY'=>'#$%#$%qsdfcbtrR',
        'COOKIE_KEY'=>'rtruik$^%&'

);