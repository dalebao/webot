<?php

/**
 * Created by PhpStorm.
 * User: baoxulong
 * Date: 2017/7/18
 * Time: PM10:01
 */
class RedisController
{

    public function __construct()
    {

    }

    public function connect()
    {
        $redis = new Redis();
        $redis->connect('127.0.0.1', 6379);
        return $redis;
    }


    public function save($imageBase64,$picName,$dirName)
    {
        $redis = $this->connect();
        $redis->hSet($dirName,$picName,$imageBase64);
    }

    public function isExist($picName,$dirName){
        $redis = $this->connect();
        return $redis->hExists($dirName,$picName);
    }

    public function get($picName,$dirName){
        $redis = $this->connect();
        return $redis->hGet($dirName,$picName);
    }

}

