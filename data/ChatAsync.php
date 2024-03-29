<?php

namespace com\hujiayucc\chatnio\data;

require_once __DIR__ . "/../bean/MessageSegment.php";
require_once __DIR__ . "/../exception/FiledException.php";
require_once __DIR__ . "/../utils/WsClient.php";
require_once __DIR__ . "/../utils/IWebSocketConnection.php";

use com\hujiayucc\chatnio\bean\MessageSegment;
use com\hujiayucc\chatnio\exception\FiledException;
use com\hujiayucc\chatnio\utils\WsClient;
use Exception;

class ChatAsync extends WsClient
{

    private string $messages = "";

    /**
     * @param MessageSegment $message 消息段
     */
    function onMessage(MessageSegment $message)
    {
        $this->messages .= $message->getMessage();
    }

    /**
     * @throws FiledException 错误信息
     */
    function onError(Exception $exception)
    {
        throw new FiledException($exception->getMessage());
    }

    /**
     * @return string 消息内容
     */
    public function getMessages(): string
    {
        return $this->messages;
    }
}