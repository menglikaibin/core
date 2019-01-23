<?php

class parameter_Standard
{
    //参数验证规则    开始
    private $a                  = '$this->arr_validate($v,$k,$start);';                          //$a参数验证方式
    //参数验证规则    结束

    /**
     * 可靠的参数
     * @var string
     */
    public $credible_Parameter;

    public function __construct($parameter = '',$required_Parameter = '')
    {
        if ($parameter && $required_Parameter)                                                  //两个参数都有时执行filtration方法
        {
            $this->credible_Parameter = $this->filtration($parameter,$required_Parameter);      //执行参数验证
        }
    }

    /**
     * 获得所有可用参数以及格式说明
     * @return string
     */
    public function get_All()
    {
        $reflectionClass = new ReflectionClass($this);                                          //实例化反射类

        $properties      = $reflectionClass->getDefaultProperties();                            //获得类所有属性

        foreach ($properties as $k => $v)
        {
            if ($k != 'credible_Parameter')                                                     //不显示credible_Parameter参数
            {
                echo $k . '参数验证方法：' . $v . "\r\n";                                          //整理显示
            }
        }

        die;
    }

    /**
     * 过滤参数
     * @param $parameter            前端提交的参数
     * @param $required_Parameter   接口所需参数，决定可靠参数的排序与验证方式
     * @return array                返回可靠参数
     * @throws Exception            两个参数必须为数组
     */
    private function filtration($parameter,$required_Parameter)
    {
        if (!is_array($parameter))                                                              //验证参数为数组
        {
            throw new Exception('参数$parameter:必须为数组。');
        }

        if (!is_array($required_Parameter))
        {
            throw new Exception('参数$required_Parameter:必须为数组。');
        }                                                                                       //验证参数为数组

        $re = array();

        foreach ($required_Parameter as $k => $v)                                               //按接口所需参数整理用户传入参数
        {
            if (is_array($v))
            {
                $v = $k;
            }

            if ($parameter[$v]||$parameter[$v] == 0){                                           //检验参数是否存在所需参数里
                $re[$v] = $parameter[$v];
            }else{
                throw new Exception("参数有问题，需要查证！");
            }

            $validate = $this->validate($v,$re[$v]);                                            //调用检验方法检验参数

            unset($validate);
            unset($required_Parameter[$k]);
        }

        if ($required_Parameter)                                                                //接口所需参数是否全部用完
        {
            throw new Exception('接口请求参数不完整！');
        }
        return $re;
    }

    /**
     * @param $k
     * @param $v
     * @return bool
     * @throws Exception
     */
    private function validate($k , $v)
    {
        $start = true;                                                                          //状态值
        $k = strtolower($k);                                                                    //转换为小写

        if (is_array($v))
        {
            foreach ($v as $ks => $vs)
            {
                $this->validate($ks,$vs);                                                       //数组递归
            }
        }

        if (property_exists($this,$k))                                                          //检测类属性是否存在
        {
            eval($this->$k);                                                                    //使用属性定义的检验方法
        }
        elseif (is_numeric($k))                                                                 //下标数组递归进入
        {

        }
        else
        {
            throw new Exception($k.'参数不存在验证方式！');
        }

        return $start;                                                                          //返回状态值
    }

    /**
     * 验证参数是否为int
     * @param $v
     * @param $k
     * @param $start
     * @throws Exception
     */
    private function int_validate($v,$k,&$start)
    {
        if (!is_numeric($v))
        {
            $start = false;
            throw new Exception("参数$k:必须为整数。");
        }
    }

    /**
     * 验证参数是否为float
     * @param $v
     * @param $k
     * @param $start
     * @throws Exception
     */
    private function float_validate($v,$k,&$start)
    {
        if (!is_numeric($v)||!is_float($v))
        {
            $start = false;
            throw new Exception("参数$k:必须为浮点数。");
        }
    }

    /**
     * 验证参数是否为数组
     * @param $v
     * @param $k
     * @param $start
     * @throws Exception
     */
    private function arr_validate($v,$k,&$start)
    {
        if (!is_array($v))
        {
            $start = false;
            throw new Exception("参数$k:必须为数组。");
        }
    }

    /**
     * 验证参数是否为手机号
     * @param $v
     * @param $k
     * @param $start
     * @throws Exception
     */
    private function phone_validate($v,$k,&$start)
    {
        if ((string)$v[0]!=1 || strlen($v)!=11)
        {
            $start = false;
            throw new Exception("参数$k:必须为手机号格式。");
        }
    }

    /**
     * 验证参数是否为有效字符串
     * @param $v
     * @param $k
     * @param $start
     */
    private function string_validate($v,$k,&$start)
    {
        if(!is_string($v) || $v == "")
        {
            $start = false;
            throw new Exception("参数$k:必须是非空字符串。");
        }
    }

    /**
     * 验证参数是否为base64编码
     * @param $v
     * @param $k
     * @param $start
     */
    private function base64_validate($v,$k,&$start)
    {
        if(!base64_encode(base64_decode($v)))
        {
            $start = false;
            throw new Exception("参数$k:必须是base64编码。");
        }
    }

    /**
     * 验证参数是否为email
     * @param $v
     * @param $k
     * @param $start
     */
    private function email_validate($v,$k,&$start)
    {
        if (!filter_var($v, FILTER_VALIDATE_EMAIL))
        {
            $start = false;
            throw new Exception("参数$k:必须是email。");
        }
    }

    /**
     * 验证参数是否为url
     * @param $v
     * @param $k
     * @param $start
     */
    private function url_validate($v,$k,&$start)
    {
        if (!filter_var($v, FILTER_VALIDATE_URL))
        {
            $start = false;
            throw new Exception("参数$k:必须是URL。");
        }
    }

}