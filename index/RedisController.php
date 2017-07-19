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


    public function save($key,$value)
    {
        $redis = $this->connect();

        return $redis->SADD($key,$value);
    }

    public function isExist($key){
        $redis = $this->connect();
        return $redis->exists($key);
    }

    public function get($key){
        $redis = $this->connect();
        return $redis->sMembers($key);
    }
    public function remove($key,$value){
        $redis = $this->connect();
        return $redis->sRem($key,$value);
    }

    public function del($key){
        $redis = $this->connect();
        return $redis->del($key);
    }
}



