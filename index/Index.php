<?php

use Hanson\Vbot\Foundation\Vbot;
use Hanson\Vbot\Message\Text;
use Hanson\Vbot\Message\Image;
use Hanson\Vbot\Message\Emoticon;
use Hanson\Vbot\Message\Video;
use Hanson\Vbot\Message\Voice;
use Illuminate\Support\Collection;

require_once __DIR__ . '/FightPic.php';
require_once __DIR__ . '/ChatBot.php';

/**
 *入口
 */
class Index
{


    //斗图功能
    public function fightPic($picSearch)
    {
        $fight_pic = new FightPic();
        //斗图
        return $fight_pic->fight($picSearch);

    }

    //只能聊天
    public function smartChat($content, $fromUser)
    {
        $chatbot = new ChatBot($content, $fromUser);
        $response = $chatbot->run();
        return $response;
    }

    //正常处理消息
    public function handleMsg($msg)
    {
        $action = explode("：", $msg['content']);
        if (count($action) > 1) {
            //有命令
            //斗图模式
            if ($action[0] == '斗图') {
                $path = $this->fightPic($action[1]);
                Image::send($msg['from']['UserName'], $path);
            }elseif ($action[0]=='天气'){
                $response = $this->smartChat($msg['content'], $msg['from']['UserName']);
                foreach ($response as $ans) {
                    if (isset($ans)) {
                    Text::send($msg['from']['UserName'], $ans);
                    }
                }
            }
        } elseif ($msg['fromType'] == 'Friend') {
            //排除群聊
            $response = $this->smartChat($msg['content'], $msg['from']['UserName']);
            foreach ($response as $ans) {
                if (isset($ans)) {
                    Text::send($msg['from']['UserName'], $ans);
                }
            }
        }
    }

    //运行项目
    public function run($option)
    {
//        $message=[
//            'fromType'=>'Friend',
//            'content'=>'天气',
//            'from'=>['UserName'>'@a2ab1a0a35f2f528ba4c941f584a04addf6711e068a1df993acdc8f5a45e7975'],
//        ];

        // init vbot
        $vbot = new Vbot($option);

        // 获取消息处理器实例
        $messageHandler = $vbot->messageHandler;


        // 处理消息
        $messageHandler->setHandler(function (Collection $message) {
            $friends = \vbot('friends');

            if ($message['type'] == 'request_friend') {
                //同意好友请求
                $friends->approve($message);
            } elseif ($message['type'] === 'recall') {
                Text::send($message['from']['UserName'], $message['content'] . ' : ' . $message['origin']['content']);
                if ($message['origin']['type'] === 'image') {
                    Image::send($message['from']['UserName'], $message['origin']);
                } elseif ($message['origin']['type'] === 'emoticon') {
                    Emoticon::send($message['from']['UserName'], $message['origin']);
                } elseif ($message['origin']['type'] === 'video') {
                    Video::send($message['from']['UserName'], $message['origin']);
                } elseif ($message['origin']['type'] === 'voice') {
                    Voice::send($message['from']['UserName'], $message['origin']);
                }
            } else {
                $this->handleMsg($message);
            }
        });

        //启动服务
        $vbot->server->serve();
    }

}


?>
