<?php

include_once __DIR__.'/core_Access.php';

$class_name = 'class1';


$parameter = $required_Parameter = array();                                                             //接口所用参数

$as = \core_Access::get_Core_Access()->get_Class($class_name)->set_Parameter($parameter)->production();  //执行接口

//$as = \core_Access::get_Core_Access()->get_Class($class_name)->required_Parameter();                     //查看接口所需参数

/**
 * 查看所有参数和检测方法
 * $parameter_Standard = new parameter_Standard();
 * $parameter_Standard->get_All();
 */

spl_autoload_unregister('_autoload');
//框架代码请在此函数下抒写，避免自动加载冲突

$array = json_decode($as['body'],true);

print_r($array); //打印出返回信息

//以脚本方式执行该命令:php index.php