<?php

use Hanson\Vbot\Message\Image;
use Hanson\Vbot\Message\Text;


/**
 * Created by PhpStorm.
 * User: baoxulong
 * Date: 2017/7/18
 * Time: PM1:17
 */
class FightPic
{

    private $py_path = __DIR__ . '/../py_spider/spider_main.py  ';
    private $pic_dir = __DIR__ . '/../images';

    public function fight($picSearch)
    {
        $is_exist = $this->isExist($picSearch);


        if ($is_exist) {
            $response = $this->runPy($picSearch);
            if ($response) {
                $pic_path = $this->getPic($picSearch);
                return $pic_path;
            } else {
                return '未知错误';
            }
        } else {
            $this->runPy($picSearch);
            sleep(2);
            echo 111;
            return $this->pic_dir . '/' . $picSearch . '/' . $picSearch . '1.png';
        }

    }


//运行python脚本
    public
    function runPy($picSearch)
    {
        $command = 'python3 ' . $this->py_path . $picSearch;
        $response = exec($command, $output, $return);
        if ($return == '0' || in_array('文件已存在', $output)) {
            return true;
        } else {
            return false;
        }
    }

//随机选取图片
    public
    function getPic($picSearch)
    {
        $dir = scandir($this->pic_dir . '/' . $picSearch);
        $real_count = count($dir) - 2;
        if ($real_count == 0) {
            $pic_path = $this->pic_dir . '/666/6661.png';
        } else {
            $pic_name = $picSearch . mt_rand(1, $real_count) . '.png';
            //获取随机图片
            $pic_path = $this->pic_dir . '/' . $picSearch . '/' . $pic_name;
        }
        //确保图片存在
        if (!file_exists($pic_path)) {
            $pic_path = $this->getPic($picSearch);
        }
        return $pic_path;
    }

//是否存在文件夹
    public
    function isExist($picSearch)
    {
        if (is_dir($this->pic_dir . '/' . $picSearch)) {
            return true;
        } else {
            return false;
        }

    }


}