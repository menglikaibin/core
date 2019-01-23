<?php
/**
 * User: *****
 * Date: 2019/01/23
 * Time: 01:47
 * function: ******
 */

class class1 extends public_Extends implements core_Class_Norm
{
    private $parameter;                                                                 //参数
    private $url = 'api/contract/was';                                                              //接口URL地址
    private $required_Parameter = array('*');                                           //接口所用参数

    /**
     * 获得接口URL
     * @return mixed|string
     */
    public function get_Url()
    {
        return $this->url;
    }

    /**
     * 获得接口所用参数
     * @return array|mixed
     */
    public function required_Parameter()
    {
        return $this->required_Parameter;
    }

    /**
     * 验证参数
     * @param 参数 $parameter
     * @return $this|mixed
     */
    public function set_Parameter($parameter)
    {
        /**
         * 查看所有参数和检测方法
         * $parameter_Standard = new parameter_Standard();
         * $parameter_Standard->get_All();
         */

        $required_Parameter = $this->required_Parameter();
        $parameter_Standard = new parameter_Standard($parameter,$required_Parameter);

        $this->parameter = $parameter_Standard->credible_Parameter;

        return $this;
    }

    /**
     * 提交到服务器
     * @return mixed
     * @throws Exception
     */
    public function production()
    {
        $parameter = $this->parameter;

        $url = $this->get_Url();

        return $this->server_Submit($url,$parameter);
    }


}


