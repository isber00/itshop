<?php
define('APP_PATH','./App/');
define('APP_DEBUG',TRUE);
$_GET['m']='Admin';//指定模块
$_GET['c']='Index';//指定控制器
$_GET['a']='index';//方法，
require './ThinkPHP/ThinkPHP.php';
?>