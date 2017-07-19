<?php

/**
 * Created by PhpStorm.
 * User: baoxulong
 * Date: 2017/7/19
 * Time: AM11:13
 */
class ChatBot
{
    private $config = [
        'key' => 'e1961d581e424ef998fcf3c1925ce1ab'
    ];
    private $api = 'http://www.tuling123.com/openapi/api';

    public function __construct($fromUser, $info, $loc = null)
    {
        if (!empty($fromUser)) {
            $this->config['userid'] = $fromUser;
        }
        if (!empty($info)) {
            $action = explode("：", $info);

            if (count($action) > 1) {
                if ($action[1] == '天气') {
                    $this->config['info'] = $action[1];
                    $this->config['loc'] = $action[2];
                }
            } else {
                $this->config['info'] = $info;
            }
        }
        if (isset($loc)) {
            $this->config['loc'] = $loc;
        }
    }


    public function run()
    {
        $response = $this->sendPost();
        $response = json_decode($response);
        $results = [];
        if ($response->text) {
            $results['text'] = $response->text;
            $results['url'] = isset($response->url) ? $response->url : null;
            $results['name'] = isset($response->list['name']) ? $response->list['name'] : null;
            $results['info'] = isset($response->list['info']) ? $response->list['info'] : null;
            $results['datailurl'] = isset($response->list['datailurl']) ? $response->list['datailurl'] : null;
        }
        return $results;
    }

    public function sendPost()
    {
        $postdata = http_build_query($this->config);
        $options = array(
            'http' => array(
                'method' => 'POST',
                'header' => 'Content-type:application/x-www-form-urlencoded',
                'content' => $postdata,
                'timeout' => 15 * 60 // 超时时间（单位:s）
            )
        );
        $context = stream_context_create($options);
        $result = file_get_contents($this->api, false, $context);

        return $result;
    }


}

