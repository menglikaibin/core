<?php

/**
 * 自动加载方法
 * 先查找inventory类再查找interface
 * @param $class 类名
 * @throws Exception  两个文件夹都没有的情况下抛出异常
 */
spl_autoload_register('_autoload',true,true);
function _autoload($class)
{
    $file = __DIR__ . '/inventory/' .$class.'.php';
    if (!file_exists($file))
    {
        $file = __DIR__ . '/interface/' .$class.'.php';
    }

    include_once($file);
}

class core_Access
{
    static private $core_Access;    //入口类
    static private $class_Leaf;     //注册树

    private function __construct()//拒绝外部实例化
    {

    }

    private function __clone()//防止克隆
    {

    }

    /**
     * 静态类入口
     * 验证静态属性$core_Access，实现core_Access类并放在$core_Access
     * @return core_Access
     */
    static public function get_Core_Access()
    {
        if (!self::$core_Access instanceof self) {
            self::$core_Access = new self();
        }

        return self::$core_Access;
    }

    /**
     * 获得需要的类工厂
     * 在注册树上查找类，添加树，验证类
     * @param $class_name  获得类的名字
     * @return mixed       返回实现的类
     * @throws Exception   类必须继承public_Extends，实现core_Class_Norm接口
     */
    public function get_Class($class_name)
    {
        if (self::$class_Leaf[$class_name])                                             //检测数是否已存在要实现的类
        {
            $new_Class = self::$class_Leaf[$class_name];
        }else{
            $new_Class = new $class_name();

            $ReflectionClass = new ReflectionClass($class_name);                        //反射

            if(!$ReflectionClass->isSubclassOf('public_Extends'))                  //是否为其之类
            {
                throw new Exception("应用类必须继承public_Extends类");
                die;
            }

            if (!$ReflectionClass->implementsInterface('core_Class_Norm'))      //是否为其接口的实现
            {
                throw new Exception("应用类必须实现core_Class_Norm接口");
                die;
            }

            self::$class_Leaf[$class_name] = $new_Class;                                //加入注册树
        }

        return $new_Class;
    }

}