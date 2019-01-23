<?php

interface core_Class_Norm
{
    /**
     * 设置参数
     * @param $parameter    参数
     * @return mixed        $this
     */
    function set_Parameter($parameter);

    /**
     * 请求服务器
     * @return mixed    服务器响应值
     */
    function production();

    /**
     * 获得API URL
     * @return mixed
     */
    function get_Url();

    /**
     * 返回所需的参数数组
     * @return mixed
     */
    function required_Parameter();

}