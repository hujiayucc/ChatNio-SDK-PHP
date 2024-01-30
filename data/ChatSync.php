<?php

namespace com\hujiayucc\chatnio\data;

require_once __DIR__ . "/../bean/MessageSegment.php";
require_once __DIR__ . "/../bean/Token.php";
require_once __DIR__ . "/../utils/CustomSync.php";
require_once __DIR__ . "/../utils/WsClient.php";

use com\hujiayucc\chatnio\bean\MessageSegment;
use com\hujiayucc\chatnio\bean\Token;
use com\hujiayucc\chatnio\utils\CustomSync;
use com\hujiayucc\chatnio\utils\WsClient;
use Exception;

class ChatSync extends WsClient
{
    private string $messages = "";
    private CustomSync $customSync;
    public function __construct(Token $token, CustomSync $customSync)
    {
        parent::__construct($token);
        $this->customSync = $customSync;
    }

    function onMessage(MessageSegment $message)
    {
        $this->customSync->onMessage($message);
        $this->messages .= $message->getMessage();
    }

    function onError(Exception $exception)
    {
        $this->customSync->onError($exception);
    }

    /** 获取消息内容 */
    public function getMessages(): string
    {
        return $this->messages;
    }
}