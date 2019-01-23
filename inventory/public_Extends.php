<?php

class public_Extends implements Iterator //迭代器
{
    public function current()//返回当前元素
    {

    }

    public function key()//返回当前元素的键
    {

    }

    public function next()//向前移动到下一个元素
    {

    }

    public function rewind()//返回到迭代器的第一个元素
    {

    }

    public function valid()//检查当前位置是否有效
    {

    }

    /**
     * API服务器提交请求
     * @param $url          请求地址
     * @param $parameter    可靠的参数
     * @param string $re    请求方式。默认post
     * @return mixed        服务器的响应值
     * @throws Exception    只能用post|get请求方式
     */
    public function server_Submit($url,$parameter,$re = 'post')
    {
        $parameter = json_encode($parameter,true);

//        return $parameter;

        $headers = array('Content-Type: application/json;charset=utf-8');
        //请求头

        //初始化
        $curl = curl_init();
        //设置抓取的url
        curl_setopt($curl, CURLOPT_URL, $url);
        //设置头文件的信息作为数据流输出
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        //设置请求头
        curl_setopt($curl, CURLOPT_HEADER, 1);
        //设置获取的信息以文件流的形式返回，而不是直接输出。
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        //设置提交方式
        if ($re == 'post')
        {
            //post提交方式
            curl_setopt($curl, CURLOPT_POST, 1);
            //设置post数据
            curl_setopt($curl, CURLOPT_POSTFIELDS, $parameter);
        }
        elseif ($re == 'get')
        {

        }
        else
        {
            throw new Exception("请求方式只能是POST|GET");
            die;
        }
        //执行命令
        $data = curl_exec($curl);

        //分离头信息与数据主体
        $headerSize = curl_getinfo($curl, CURLINFO_HEADER_SIZE);
        $datas['header'] = substr($data, 0, $headerSize);
        $datas['body'] = substr($data, $headerSize);

        //关闭URL请求
        curl_close($curl);
        unset($data);
        //显示获得的数据
        return $datas;
    }
}