<?php

use Hanson\Vbot\Foundation\Vbot;
use Hanson\Vbot\Message\Text;
use Hanson\Vbot\Message\Image;
use Illuminate\Support\Collection;

require_once __DIR__ . '/FightPic.php';

/**
 *入口
 */
class Index
{

    private $allow_UserName = [
        '@@fc7d9e5af8e805f0360ce17be4a72561e0798beffb98319941320fd7cf59d54f',
        '@0bbf790ad65a91b80b98ee77d598743eeafdec2ca3b905251d77562d7de16c54',
        '@51459de9033f82910e8f8bee400288c3c9b539d7fe2c998e3e4bb3febdf3867a',
        '@5831977440ddf35c4295a8940b37e02cd8b18924cd63c5a53eedb5b2e14bfc96'
    ];

    //斗图功能
    public function fightPic($picSearch)
    {
        $fight_pic = new FightPic();
        //斗图
        return $fight_pic->fight($picSearch);

    }

    //正常处理消息
    public function handleMsg($msg)
    {
        var_dump($msg['content']);

        $action = explode("：", $msg['content']);
        if (count($action) > 1) {
            //有命令
            //斗图模式
            if ($action[0] == '斗图') {
                $path = $this->fightPic($action[1]);
                Image::send($msg['from']['UserName'], $path);
            }
        }
    }

    //运行项目
    public function run($option)
    {

        // init vbot
        $vbot = new Vbot($option);

        // 获取消息处理器实例
        $messageHandler = $vbot->messageHandler;


        // 处理消息
        $messageHandler->setHandler(function (Collection $message) {
            $friends = \vbot('friends');

            if ($message['type']=='request_friend'){
                //同意好友请求
                $friends->approve($message);
            }else{
                $this->handleMsg($message);
            }
        });

        //启动服务
        $vbot->server->serve();
    }

}


?>
